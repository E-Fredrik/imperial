<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (($request->user()->role ?? '') !== 'admin') {
                abort(403);
            }
            return $next($request);
        });
    }

    // show all bookings for admin
    public function index(): View
    {
        $bookings = Booking::with('room','payments','user')->orderByDesc('created_at')->paginate(25);
        return view('admin.bookings.index', compact('bookings'));
    }

    // show create form for admin (optional - reuse user controller)
    public function create(): View
    {
        $rooms = Room::orderBy('room_number')->get();
        $users = User::orderBy('first_name')->get();
        return view('admin.bookings.create', compact('rooms','users'));
    }


    // store booking (admin-created)
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id'      => ['required','exists:users,id'],
            'room_id'      => ['required','exists:rooms,id'],
            'move_in_date' => ['required','date'],
            'proof' => ['nullable','file','image','max:4096'],
            'id_card' => ['nullable','file','image','max:4096'],
        ]);

        $room = Room::findOrFail($data['room_id']);
        if ($room->status !== 'available') {
            return back()->withErrors(['room_id' => 'Room is not available'])->withInput();
        }

        $monthly = (int) $room->price;
        $booking = Booking::create([
            'user_id' => $data['user_id'],
            'room_id' => $room->id,
            'move_in_date' => $data['move_in_date'],
            'monthly_rent' => $monthly,
            'status' => 'pending',
        ]);

        $room->update(['status' => 'pending']);

        // handle optional proof upload (admin may supply proof when creating)
        $proofPath = null;
        if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
            $file = $request->file('proof');
            $contents = file_get_contents($file->getRealPath());
            $hash = sha1($contents . Str::random(6));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $path = 'payments/' . $filename;
            Storage::disk('public')->put($path, $contents);
            $proofPath = $path;
        }

        // handle optional id_card upload (save path on the selected user)
        if ($request->hasFile('id_card') && $request->file('id_card')->isValid()) {
            $file = $request->file('id_card');
            $contents = file_get_contents($file->getRealPath());
            $hash = sha1($contents . Str::random(6));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $idPath = 'id_cards/' . $filename;
            Storage::disk('public')->put($idPath, $contents);

            // update the user's id_card field
            $user = User::find($data['user_id']);
            if ($user) {
                $user->update(['id_card' => $idPath]);
            }
        }

        // Create initial payment with NO late fee
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $monthly, // No late fee for initial booking
            'payment_for_month' => date('Y-m', strtotime($data['move_in_date'])),
            'monthly_rent' => $monthly,
            'late_fee' => 0, // Always 0 for initial booking
            'proof' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.bookings.index')->with('success','Booking created.');
    }

    // optional: show single booking in admin
    public function show(Booking $booking): View
    {
        $booking->load('room','payments','user');
        return view('admin.bookings.show', compact('booking'));
    }

    // optional: delete booking
    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->payments()->delete();
        $room = $booking->room;
        if ($room && in_array($room->status, ['pending','available'])) {
            $room->update(['status' => 'available']);
        }
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success','Booking deleted.');
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'move_out_date' => ['nullable','date'],
        ]);

        // If move_out_date is provided, validate and handle payment removal
        if (!empty($data['move_out_date']) && $booking->move_in_date) {
            $moveInTs = $booking->move_in_date->getTimestamp();
            $moveOutTs = strtotime($data['move_out_date']);
            if ($moveOutTs < $moveInTs) {
                return back()->withErrors(['move_out_date' => 'Move-out must be on or after move-in date.'])->withInput();
            }

            // Get the move-out month (start of month)
            $moveOutDate = Carbon::parse($data['move_out_date']);
            $moveOutMonth = $moveOutDate->copy()->startOfMonth();

            // Remove pending payments for months >= move-out month (inclusive)
            $paymentsToRemove = Payment::where('booking_id', $booking->id)
                ->where('status', 'pending')
                ->get()
                ->filter(function ($payment) use ($moveOutMonth) {
                    try {
                        $paymentMonth = Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
                    } catch (\Throwable $e) {
                        return false;
                    }
                    // Remove payments for move-out month and beyond
                    return $paymentMonth->greaterThanOrEqualTo($moveOutMonth);
                });

            $removedCount = 0;
            foreach ($paymentsToRemove as $payment) {
                Log::info('Admin removing payment due to move-out date', [
                    'payment_id' => $payment->id,
                    'payment_month' => $payment->payment_for_month,
                    'move_out_month' => $moveOutMonth->format('Y-m'),
                ]);
                $payment->delete();
                $removedCount++;
            }

            $booking->move_out_date = $moveOutDate;
            $booking->save();

            $message = 'Move-out date updated.';
            if ($removedCount > 0) {
                $message .= " {$removedCount} future payment(s) have been removed.";
            }

            return redirect()->route('admin.bookings.show', $booking)->with('success', $message);
        }

        // If move_out_date is being cleared (set to null)
        if (empty($data['move_out_date']) && $booking->move_out_date) {
            $oldMoveOut = $booking->move_out_date;
            $booking->move_out_date = null;
            $booking->save();

            // Recreate next-month payment if booking is active
            if ($booking->status === 'booked') {
                // Find the latest accepted payment
                $latestAcceptedPayment = Payment::where('booking_id', $booking->id)
                    ->where('status', 'accepted')
                    ->orderBy('payment_for_month', 'desc')
                    ->first();

                if ($latestAcceptedPayment) {
                    // Calculate next month based on latest accepted payment
                    $latestPaymentMonth = Carbon::createFromFormat('Y-m', $latestAcceptedPayment->payment_for_month);
                    $nextPaymentMonth = $latestPaymentMonth->copy()->addMonth();
                    $nextMonthString = $nextPaymentMonth->format('Y-m');

                    // Check if payment already exists
                    $exists = Payment::where('booking_id', $booking->id)
                        ->where('payment_for_month', $nextMonthString)
                        ->exists();

                    if (!$exists) {
                        // Calculate late fee if generating after the 1st
                        $today = now();
                        $firstDayOfPaymentMonth = $nextPaymentMonth->copy()->startOfMonth();
                        $lateFee = 0;

                        if ($today->greaterThan($firstDayOfPaymentMonth)) {
                            $lateFee = (int) ($booking->monthly_rent * 0.1);
                            Log::info('Late fee applied when admin recreates payment after move-out cancel', [
                                'today' => $today->format('Y-m-d'),
                                'payment_month_start' => $firstDayOfPaymentMonth->format('Y-m-d'),
                                'late_fee' => $lateFee,
                            ]);
                        }

                        $payment = Payment::create([
                            'booking_id' => $booking->id,
                            'amount' => $booking->monthly_rent + $lateFee,
                            'payment_for_month' => $nextMonthString,
                            'monthly_rent' => $booking->monthly_rent,
                            'late_fee' => $lateFee,
                            'status' => 'pending',
                            'expires_at' => null,
                        ]);

                        Log::info('Admin recreated upcoming payment after move-out cancel', [
                            'booking_id' => $booking->id,
                            'old_move_out' => $oldMoveOut->format('Y-m-d'),
                            'new_payment_id' => $payment->id,
                            'payment_for_month' => $nextMonthString,
                            'late_fee' => $lateFee,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.bookings.show', $booking)->with('success', 'Move-out date cancelled. Upcoming payment recreated if necessary.');
        }

        // If no changes to move_out_date
        return redirect()->route('admin.bookings.show', $booking)->with('info', 'No changes made.');
    }

    public function decline(Request $request, Booking $booking): RedirectResponse
    {
        // decline latest payment (if any)
        $latestPayment = $booking->payments()->orderByDesc('created_at')->first();
        if ($latestPayment && $latestPayment->status !== 'declined') {
            $latestPayment->update(['status' => 'declined']);
        }

        // set booking status to declined
        $booking->update(['status' => 'declined']);

        // free up room
        $room = $booking->room;
        if ($room) {
            $room->update(['status' => 'available']);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking and latest payment declined.');
    }
}

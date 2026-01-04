<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // show current user's bookings (admin users are redirected to admin payments)
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();
        if (($user->role ?? '') === 'admin') {
            return redirect()->route('admin.payments.index');
        }

        return redirect()->route('profile');
    }

    // show create form (available rooms only)
    public function create(): View
    {
        $rooms = Room::where('status', 'available')->orderBy('room_number')->get();
        return view('bookings.create', compact('rooms'));
    }

    // store booking + initial pending payment
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'room_id' => ['required','exists:rooms,id'],
            'move_in_date' => ['required','date','after_or_equal:today'], // prevent past dates
            'id_card' => ['nullable','file','image','max:4096'],
        ]);

        $room = Room::findOrFail($data['room_id']);

        // double-check availability
        if ($room->status !== 'available') {
            return back()->withErrors(['room_id' => 'Room is not available'])->withInput();
        }

        // monthly_rent follows the room price
        $monthly = (int) $room->price;

        // Normalize move-in date to start of day
        $moveInDate = Carbon::parse($data['move_in_date'])->startOfDay();
        $paymentForMonth = $moveInDate->format('Y-m');

        // NO LATE FEE FOR INITIAL BOOKING
        // Late fees only apply to recurring monthly payments when user pays after due date

        // create booking (pending)
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'move_in_date' => $moveInDate,
            'monthly_rent' => $monthly,
            'status' => 'pending',
        ]);

        // mark room as pending so others can't book
        $room->update(['status' => 'pending']);

        // Handle optional ID card upload
        if ($request->hasFile('id_card') && $request->file('id_card')->isValid()) {
            $file = $request->file('id_card');
            $contents = file_get_contents($file->getRealPath());
            $hash = sha1($contents . Str::random(6));
            $filename = $hash . '.' . $file->getClientOriginalExtension();
            $idPath = 'id_cards/' . $filename;
            Storage::disk('public')->put($idPath, $contents);

            $user = Auth::user();
            $user->update(['id_card' => $idPath]);
        }

        // Create initial payment record for the first month
        // NO LATE FEE - user is just booking the room
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $monthly, // Only monthly rent, no late fee
            'payment_for_month' => $paymentForMonth,
            'monthly_rent' => $monthly,
            'late_fee' => 0, // Always 0 for initial booking
            'status' => 'pending',
            'expires_at' => now()->addHours(24), // 24h to complete first payment
        ]);

        return redirect()->route('payment.show', $payment)->with('success', 'Booking created! Please complete payment within 24 hours to confirm.');
    }

    // show booking details (owner or admin)
    public function show(Booking $booking): View
    {
        $user = Auth::user();
        if ($booking->user_id !== $user->id && ($user->role ?? '') !== 'admin') {
            abort(403);
        }
        $booking->load('room','payments','user');
        return view('bookings.show', compact('booking'));
    }

    // cancel booking if pending or declined
    public function destroy(Booking $booking): RedirectResponse
    {
        $user = Auth::user();
        if ($booking->user_id !== $user->id && ($user->role ?? '') !== 'admin') {
            abort(403);
        }

        if (! in_array($booking->status, ['pending','declined'])) {
            return back()->withErrors(['booking' => 'Cannot cancel a confirmed booking.']);
        }

        $room = $booking->room;
        if ($room && in_array($room->status, ['pending','available'])) {
            $room->update(['status' => 'available']);
        }

        $booking->payments()->delete();
        $booking->delete();

        return redirect()->route('profile')->with('success', 'Booking cancelled.');
    }

    /**
     * Update move-out date (user self-service)
     */
    public function updateMoveOutDate(Request $request, Booking $booking): RedirectResponse
    {
        $user = Auth::user();

        if ($booking->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'move_out_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $moveOutDate = Carbon::parse($data['move_out_date']);
        $moveInDate = $booking->move_in_date;

        if ($moveOutDate->lessThan($moveInDate)) {
            return back()->withErrors(['move_out_date' => 'Move-out date must be after move-in date.'])->withInput();
        }

        // Get the move-out month (start of month)
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
            Log::info('Removing payment due to move-out date (user)', [
                'payment_id' => $payment->id,
                'payment_month' => $payment->payment_for_month,
                'move_out_month' => $moveOutMonth->format('Y-m'),
            ]);
            $payment->delete();
            $removedCount++;
        }

        $booking->move_out_date = $moveOutDate;
        $booking->save();

        $message = 'Move-out date set to ' . $moveOutDate->format('M d, Y') . '.';
        if ($removedCount > 0) {
            $message .= " {$removedCount} future payment(s) removed.";
        }

        return back()->with('success', $message);
    }

    /**
     * Cancel/remove move-out date — recreate next-month payment if missing
     */
    public function cancelMoveOutDate(Request $request, Booking $booking): RedirectResponse
    {
        $user = Auth::user();

        if ($booking->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $oldMoveOut = $booking->move_out_date;
        $booking->move_out_date = null;
        $booking->save();

        // Recreate next-month payment if booking is active
        if ($booking->status === 'booked') {
            // Find the latest accepted payment to determine what the next month should be
            $latestAcceptedPayment = Payment::where('booking_id', $booking->id)
                ->where('status', 'accepted')
                ->orderBy('payment_for_month', 'desc')
                ->first();

            if ($latestAcceptedPayment) {
                // Calculate next month based on latest accepted payment
                $latestPaymentMonth = Carbon::createFromFormat('Y-m', $latestAcceptedPayment->payment_for_month);
                $nextPaymentMonth = $latestPaymentMonth->copy()->addMonth();
                $nextMonthString = $nextPaymentMonth->format('Y-m');

                // Check if payment already exists for that month
                $exists = Payment::where('booking_id', $booking->id)
                    ->where('payment_for_month', $nextMonthString)
                    ->exists();

                if (!$exists) {
                    // Calculate late fee if generating after the 1st of the month
                    $today = now();
                    $firstDayOfPaymentMonth = $nextPaymentMonth->copy()->startOfMonth();
                    $lateFee = 0;

                    if ($today->greaterThan($firstDayOfPaymentMonth)) {
                        $lateFee = (int) ($booking->monthly_rent * 0.1); // 10% late fee
                        Log::info('Late fee applied when recreating payment after move-out cancel', [
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
                        'expires_at' => null, // No expiry for recurring payments
                    ]);

                    Log::info('Recreated upcoming payment after move-out cancel (user)', [
                        'booking_id' => $booking->id,
                        'old_move_out' => $oldMoveOut ? Carbon::parse($oldMoveOut)->format('Y-m-d') : null,
                        'new_payment_id' => $payment->id,
                        'payment_for_month' => $nextMonthString,
                        'late_fee' => $lateFee,
                    ]);
                }
            } else {
                Log::info('No accepted payments found, cannot recreate next payment', [
                    'booking_id' => $booking->id,
                ]);
            }
        }

        return back()->with('success', 'Move-out date cancelled. Upcoming payment recreated if necessary.');
    }
}

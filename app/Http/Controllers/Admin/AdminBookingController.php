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

        // if provided, ensure move_out_date is not before move_in_date
        if (! empty($data['move_out_date']) && $booking->move_in_date) {
            $moveInTs = $booking->move_in_date->getTimestamp();
            $moveOutTs = strtotime($data['move_out_date']);
            if ($moveOutTs < $moveInTs) {
                return back()->withErrors(['move_out_date' => 'Move-out must be on or after move-in date.'])->withInput();
            }
        }

        // assign and save (avoid relying on $fillable)
        $booking->move_out_date = $data['move_out_date'] ?? null;
        $booking->save();

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Move-out date updated.');
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

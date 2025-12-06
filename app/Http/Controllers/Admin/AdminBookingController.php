<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.bookings.create', compact('rooms'));
    }

    // store booking (admin-created) - optional
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id'      => ['required','exists:users,id'],
            'room_id'      => ['required','exists:rooms,id'],
            'move_in_date' => ['required','date'],
            'monthly_rent' => ['required','numeric','min:0'],
        ]);

        $room = Room::findOrFail($data['room_id']);
        if ($room->status !== 'available') {
            return back()->withErrors(['room_id' => 'Room is not available'])->withInput();
        }

        $booking = Booking::create([
            'user_id' => $data['user_id'],
            'room_id' => $room->id,
            'move_in_date' => $data['move_in_date'],
            'monthly_rent' => $data['monthly_rent'],
            'status' => 'pending',
        ]);

        $room->update(['status' => 'pending']);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $data['monthly_rent'],
            'payment_for_month' => date('Y-m', strtotime($data['move_in_date'])),
            'monthly_rent' => $data['monthly_rent'],
            'late_fee' => 0,
            'paid_at' => null,
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
}

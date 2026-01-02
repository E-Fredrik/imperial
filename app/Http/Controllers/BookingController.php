<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // optionally add admin role middleware if you have it
    }

    // list recent payments for admin review
    public function index(): View
    {
        $payments = Payment::with('booking.user','booking.room')->orderBy('created_at','desc')->paginate(25);
        return view('admin.payments.index', compact('payments'));
    }

    // admin accepts or declines a payment
    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $request->validate([
            'action' => ['required','in:accept,decline'],
        ]);

        $action = $request->input('action');

        if ($action === 'accept') {
            // mark payment accepted
            $payment->update([
                'status' => 'accepted',
                'paid_at' => now(),
            ]);

            $booking = $payment->booking;
            $booking->update(['status' => 'booked']);

            $room = $booking->room;
            if ($room) {
                $room->update(['status' => 'booked']);
            }

            return redirect()->back()->with('success','Payment accepted and booking confirmed.');
        }

        // decline branch
        if ($action === 'decline') {
            $payment->update(['status' => 'declined']);

            $booking = $payment->booking;
            $booking->update(['status' => 'declined']);

            // free up room for others
            $room = $booking->room;
            if ($room) {
                $room->update(['status' => 'available']);
            }

            return redirect()->back()->with('success','Payment declined and room released.');
        }

        return redirect()->back();
    }
}

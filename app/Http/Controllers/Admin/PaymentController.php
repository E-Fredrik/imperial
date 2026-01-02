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
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentController extends Controller
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

    // list recent payments for admin review
    public function index(): View
    {
        $payments = Payment::with('booking.user','booking.room')->orderBy('created_at','desc')->paginate(25);
        return view('admin.payments.index', compact('payments'));
    }

    // Show single payment details
    public function show(Payment $payment): View
    {
        $payment->load('booking.user', 'booking.room');
        return view('admin.payments.show', compact('payment'));
    }

    // Admin can manually update payment status if needed (e.g., for cash payments)
    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $request->validate([
            'action' => ['required','in:accept,decline'],
        ]);

        $action = $request->input('action');

        if ($action === 'accept') {
            Log::info('Admin manually accepting payment', [
                'payment_id' => $payment->id,
                'admin_id' => auth(),
            ]);

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

            // Generate next month's payment (respects move-out date)
            $this->generateNextMonthPayment($booking, $payment);

            Log::info('Admin payment accepted and next payment generated', [
                'payment_id' => $payment->id,
                'booking_id' => $booking->id,
            ]);

            return redirect()->back()->with('success','Payment accepted, booking confirmed, and next month payment generated (if applicable).');
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

    /**
     * Generate next month's payment (respects move-out date)
     */
    protected function generateNextMonthPayment(Booking $booking, Payment $currentPayment): void
    {
        try {
            // Parse current payment month
            $currentPaymentMonth = Carbon::createFromFormat('Y-m', $currentPayment->payment_for_month);
            
            // Next payment is for the next month
            $nextPaymentMonth = $currentPaymentMonth->copy()->addMonth();
            $nextMonthString = $nextPaymentMonth->format('Y-m');

            Log::info('Admin generating next payment', [
                'current_payment_month' => $currentPayment->payment_for_month,
                'next_payment_month' => $nextMonthString,
                'booking_id' => $booking->id,
            ]);

            // Check if booking has a move-out date set
            if ($booking->move_out_date) {
                $moveOutMonth = Carbon::parse($booking->move_out_date)->startOfMonth();
                
                // Don't generate payment if next month is AFTER move-out month
                if ($nextPaymentMonth->greaterThan($moveOutMonth)) {
                    Log::info('Skipping payment generation - after move-out date', [
                        'booking_id' => $booking->id,
                        'next_payment_month' => $nextMonthString,
                        'move_out_month' => $moveOutMonth->format('Y-m'),
                        'move_out_date' => $booking->move_out_date->format('Y-m-d'),
                    ]);
                    return;
                }
            }

            // Check if next payment already exists
            $existingPayment = Payment::where('booking_id', $booking->id)
                ->where('payment_for_month', $nextMonthString)
                ->first();

            if ($existingPayment) {
                Log::info('Next month payment already exists', [
                    'booking_id' => $booking->id,
                    'month' => $nextMonthString,
                ]);
                return;
            }

            // Calculate late fee ONLY if we're generating this payment AFTER the 1st of the month it's due
            // This means the user hasn't paid on time and is now overdue
            $lateFee = 0;
            $today = now();
            $firstDayOfPaymentMonth = $nextPaymentMonth->copy()->startOfMonth();
            
            // Only add late fee if today is AFTER the 1st of the payment month
            // This means the payment is being generated late (user is overdue)
            if ($today->greaterThan($firstDayOfPaymentMonth)) {
                $lateFee = (int) ($booking->monthly_rent * 0.1); // 10% late fee
                Log::info('Late fee applied for overdue recurring payment', [
                    'today' => $today->format('Y-m-d'),
                    'payment_month_start' => $firstDayOfPaymentMonth->format('Y-m-d'),
                    'late_fee' => $lateFee,
                ]);
            }

            // Create next payment (no expiration for recurring payments)
            $nextPayment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->monthly_rent + $lateFee,
                'payment_for_month' => $nextMonthString,
                'monthly_rent' => $booking->monthly_rent,
                'late_fee' => $lateFee,
                'status' => 'pending',
                'expires_at' => null, // No 24h expiration for recurring payments
            ]);

            Log::info('Next month payment generated by admin', [
                'payment_id' => $nextPayment->id,
                'booking_id' => $booking->id,
                'month' => $nextMonthString,
                'amount' => $nextPayment->amount,
                'late_fee' => $lateFee,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to generate next month payment (admin)', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}

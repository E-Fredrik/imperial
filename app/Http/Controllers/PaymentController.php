<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->middleware('auth')->except(['webhook']);
        $this->midtrans = $midtrans;
    }

    /**
     * Show payment page with Midtrans Snap
     */
    public function show(Payment $payment): View|RedirectResponse
    {
        $user = Auth::user();
        
        Log::info('Payment show page accessed', [
            'payment_id' => $payment->id,
            'user_id' => $user->id,
            'payment_status' => $payment->status,
        ]);

        // Check if user owns this payment
        if ($payment->booking->user_id !== $user->id && ($user->role ?? '') !== 'admin') {
            Log::warning('Unauthorized payment access attempt', [
                'payment_id' => $payment->id,
                'user_id' => $user->id,
                'owner_id' => $payment->booking->user_id,
            ]);
            abort(403);
        }

        // If already paid, redirect
        if ($payment->status === 'accepted') {
            Log::info('Payment already completed', ['payment_id' => $payment->id]);
            return redirect()->route('profile')->with('info', 'This payment has already been completed.');
        }

        // Check if payment has expired (only for first payment with 24h window)
        if ($payment->expires_at && $payment->isExpired()) {
            Log::info('Payment has expired', ['payment_id' => $payment->id]);
            $this->handleExpiredPayment($payment);
            return redirect()->route('profile')->with('error', 'This payment has expired. Please contact support if you have any questions.');
        }

        try {
            Log::info('Creating snap token', ['payment_id' => $payment->id]);
            
            $snapToken = $this->midtrans->createSnapToken($payment);
            
            Log::info('Snap token created successfully', [
                'payment_id' => $payment->id,
                'has_token' => !empty($snapToken),
            ]);
            
            return view('payments.show', [
                'payment' => $payment,
                'snapToken' => $snapToken,
                'clientKey' => $this->midtrans->getClientKey(),
                'snapJsUrl' => $this->midtrans->getSnapJsUrl(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create snap token in controller', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('profile')->with('error', 'Failed to initialize payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle finish redirect from Midtrans
     */
    public function finish(Request $request): RedirectResponse
    {
        $orderId = $request->get('order_id');
        $transactionStatus = $request->get('transaction_status');
        
        Log::info('=== Payment Finish Callback ===', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'all_params' => $request->all(),
        ]);

        if (!$orderId) {
            Log::warning('No order_id in finish callback');
            return redirect()->route('profile')->with('error', 'Payment information not found.');
        }

        // Find payment by order_id
        $payment = Payment::where('midtrans_order_id', $orderId)->first();

        if (!$payment) {
            Log::warning('Payment not found for order_id', ['order_id' => $orderId]);
            return redirect()->route('profile')->with('error', 'Payment record not found.');
        }

        // Verify status with Midtrans
        try {
            $status = $this->midtrans->getTransactionStatus($orderId);
            
            if ($status) {
                $this->handlePaymentStatus($payment, $status);
                
                $actualStatus = $status['transaction_status'] ?? $transactionStatus;
                
                if (in_array($actualStatus, ['capture', 'settlement'])) {
                    return redirect()->route('profile')->with('success', 'Payment successful! Your booking is confirmed.');
                } elseif ($actualStatus === 'pending') {
                    return redirect()->route('profile')->with('info', 'Payment is pending. Please complete the payment or wait for confirmation.');
                } else {
                    return redirect()->route('profile')->with('error', 'Payment was not completed. Status: ' . $actualStatus);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error verifying transaction status', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
        }

        // Fallback based on URL parameter
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            return redirect()->route('profile')->with('success', 'Payment successful! Your booking is confirmed.');
        } elseif ($transactionStatus === 'pending') {
            return redirect()->route('profile')->with('info', 'Payment is pending. Please complete the payment.');
        } else {
            return redirect()->route('profile')->with('error', 'Payment was not completed.');
        }
    }

    /**
     * Handle Midtrans webhook notification
     */
    public function webhook(Request $request): \Illuminate\Http\JsonResponse
    {
        $notification = $request->all();
        
        Log::info('=== Midtrans Webhook Received ===', [
            'notification' => $notification,
        ]);

        // Verify signature
        if (!$this->midtrans->verifySignature($notification)) {
            Log::warning('Invalid webhook signature', [
                'notification' => $notification,
            ]);
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        $orderId = $notification['order_id'] ?? null;
        
        if (!$orderId) {
            Log::warning('Order ID not found in webhook');
            return response()->json(['status' => 'error', 'message' => 'Order ID not found'], 400);
        }

        $payment = Payment::where('midtrans_order_id', $orderId)->first();

        if (!$payment) {
            Log::warning('Payment not found for webhook', ['order_id' => $orderId]);
            return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
        }

        $this->handlePaymentStatus($payment, $notification);

        Log::info('Webhook processed successfully', ['order_id' => $orderId]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Handle payment status update
     */
    protected function handlePaymentStatus(Payment $payment, array $status): void
    {
        $transactionStatus = $status['transaction_status'] ?? '';
        $fraudStatus = $status['fraud_status'] ?? '';
        $paymentType = $status['payment_type'] ?? '';

        Log::info('Processing payment status', [
            'payment_id' => $payment->id,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_type' => $paymentType,
        ]);

        $payment->payment_type = $paymentType;
        $payment->midtrans_response = $status;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $this->acceptPayment($payment);
            } elseif ($fraudStatus === 'challenge') {
                $payment->status = 'pending';
                $payment->save();
            }
        } elseif ($transactionStatus === 'settlement') {
            $this->acceptPayment($payment);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $this->handleExpiredPayment($payment);
        } elseif ($transactionStatus === 'pending') {
            $payment->status = 'pending';
            $payment->save();
        }
    }

    /**
     * Mark payment as accepted and update related records
     */
    protected function acceptPayment(Payment $payment): void
    {
        Log::info('Accepting payment', ['payment_id' => $payment->id]);

        $payment->status = 'accepted';
        $payment->paid_at = now();
        $payment->save();

        $booking = $payment->booking;
        if (!$booking) {
            Log::error('Booking not found for payment', ['payment_id' => $payment->id]);
            return;
        }

        // Update booking status
        $booking->update(['status' => 'booked']);
        
        // Update room status to 'booked' (occupied)
        if ($booking->room) {
            $booking->room->update(['status' => 'booked']);
            Log::info('Room status updated to booked', ['room_id' => $booking->room->id]);
        }

        // Generate next month's payment
        $this->generateNextMonthPayment($booking, $payment);

        Log::info('Payment accepted and next payment generated', ['payment_id' => $payment->id]);
    }

    /**
     * Generate next month's payment
     */
    protected function generateNextMonthPayment(Booking $booking, Payment $currentPayment): void
    {
        try {
            // Parse current payment month
            $currentPaymentMonth = Carbon::createFromFormat('Y-m', $currentPayment->payment_for_month);
            
            // Next payment is for the next month
            $nextPaymentMonth = $currentPaymentMonth->copy()->addMonth();
            $nextMonthString = $nextPaymentMonth->format('Y-m');

            Log::info('Generating next payment', [
                'current_payment_month' => $currentPayment->payment_for_month,
                'next_payment_month' => $nextMonthString,
            ]);

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

            // Calculate late fee based on whether we're past the 1st of the payment month
            $lateFee = 0;
            $today = now();
            $firstDayOfPaymentMonth = $nextPaymentMonth->copy()->startOfMonth();
            
            // Only add late fee if today is after the 1st of the payment month
            if ($today->greaterThan($firstDayOfPaymentMonth)) {
                $lateFee = (int) ($booking->monthly_rent * 0.1); // 10% late fee
                Log::info('Late fee applied for payment generated after due date', [
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

            Log::info('Next month payment generated', [
                'payment_id' => $nextPayment->id,
                'booking_id' => $booking->id,
                'month' => $nextMonthString,
                'amount' => $nextPayment->amount,
                'late_fee' => $lateFee,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to generate next month payment', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Handle expired payment
     */
    protected function handleExpiredPayment(Payment $payment): void
    {
        Log::info('Handling expired payment', ['payment_id' => $payment->id]);

        $payment->status = 'declined';
        $payment->save();

        $booking = $payment->booking;
        if (!$booking) {
            return;
        }

        // Check if this is the first payment for the booking (has 24h expiration)
        $acceptedPayments = Payment::where('booking_id', $booking->id)
            ->where('status', 'accepted')
            ->count();

        if ($acceptedPayments === 0 && $payment->expires_at) {
            // First payment expired (only first payment has expires_at), cancel the booking
            Log::info('First payment expired, canceling booking', [
                'booking_id' => $booking->id,
            ]);

            $booking->update(['status' => 'declined']);
            
            if ($booking->room) {
                $booking->room->update(['status' => 'available']);
                Log::info('Room released due to expired first payment', [
                    'room_id' => $booking->room->id,
                ]);
            }
        } else {
            // Subsequent payment expired (no expires_at), keep booking active
            Log::info('Subsequent payment declined', [
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
            ]);
        }
    }

    /**
     * Show upcoming payments for current user
     */
    public function upcoming(): View
    {
        $user = Auth::user();
        
        $currentBooking = $user->bookings()
            ->where('status', 'booked')
            ->whereNull('move_out_date')
            ->with('room')
            ->first();
        
        $upcomingPayments = Payment::with('booking.room')
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('status', 'pending')
            ->orderBy('payment_for_month')
            ->get();

        return view('payments.upcoming', compact('upcomingPayments', 'currentBooking'));
    }
}

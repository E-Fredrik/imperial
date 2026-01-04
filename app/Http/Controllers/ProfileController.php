<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Payment;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        
        if (! $user) {
            return redirect()->route('login');
        }

        // Load all payments for transaction history
        $transactions = Payment::with(['booking.room'])
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByDesc('paid_at')
            ->orderByDesc('created_at')
            ->get();

        // Filter pending payments: only show those due within 10 days or overdue
        $pendingRaw = $transactions->filter(function ($payment) {
            if ($payment->status !== 'pending') {
                return false;
            }

            // Parse the payment month
            $paymentDate = Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
            $daysUntilDue = now()->diffInDays($paymentDate, false);

            // Show if overdue (negative days) or due within 10 days
            return $daysUntilDue <= 10;
        });

        // --- UPDATED: Only apply late fee to RECURRING payments (not first payments) ---
        foreach ($pendingRaw as $payment) {
            try {
                // Skip first payment (has expires_at set) - no late fees for first payment
                if ($payment->expires_at) {
                    Log::info('Skipping late fee for first payment', [
                        'payment_id' => $payment->id,
                        'has_expires_at' => true,
                    ]);
                    continue;
                }

                $paymentMonth = Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
                $firstDayOfPaymentMonth = $paymentMonth->copy()->startOfMonth();
                $today = now()->startOfDay();

                // Only apply late fee if today is after the payment due date (1st of month)
                if ($today->greaterThan($firstDayOfPaymentMonth)) {
                    $booking = $payment->booking;
                    if ($booking) {
                        $calculatedLateFee = (int) ($booking->monthly_rent * 0.1); // 10%
                        $expectedAmount = $payment->monthly_rent + $calculatedLateFee;

                        // Only update if DB doesn't already reflect the late fee / amount
                        if ((int)$payment->late_fee !== $calculatedLateFee || (int)$payment->amount !== $expectedAmount) {
                            $payment->late_fee = $calculatedLateFee;
                            $payment->amount = $expectedAmount;
                            $payment->save();
                            Log::info('Applied late fee on profile view (recurring payment only)', [
                                'payment_id' => $payment->id,
                                'late_fee' => $calculatedLateFee,
                                'amount' => $expectedAmount,
                            ]);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to apply late fee on profile view', [
                    'payment_id' => $payment->id ?? null,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        // --- END UPDATED ---
        
        // Convert pending payments into view-friendly objects (no Carbon in blade)
        $pendingPayments = $pendingRaw->map(function($payment) {
            $paymentDate = Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
            $today = now()->startOfDay();
            $daysUntilDue = $today->diffInDays($paymentDate, false);
            
            // NEW: For first payments (with expires_at), never show as overdue
            $isFirstPayment = $payment->expires_at !== null;
            $isOverdue = !$isFirstPayment && ($daysUntilDue < 0);
            
            $statusText = $isOverdue ? 'Overdue' : ($isFirstPayment ? 'Pending' : 'Due Soon');
            $statusBadgeClass = $isOverdue ? 'status-overdue' : ($isFirstPayment ? 'status-pending' : 'status-due-soon');

            return (object)[
                'model' => $payment,
                'month_label' => $paymentDate->format('F Y'),
                'due_date_label' => $paymentDate->format('M d, Y'),
                'days_until_due' => $daysUntilDue,
                'is_overdue' => $isOverdue,
                'is_first_payment' => $isFirstPayment,
                'status_text' => $statusText,
                'status_badge_class' => $statusBadgeClass,
                'amount_display' => 'Rp ' . number_format($payment->amount, 0, ',', '.'),
                'late_fee' => $payment->late_fee,
                'booking_room_number' => optional($payment->booking->room)->room_number ?? '-',
            ];
        })->values();

        // Count all pending payments for the badge
        $totalPendingCount = $transactions->where('status', 'pending')->count();

        // Get upcoming payments (pending status only) and exclude those after move-out
        $upcomingRaw = Payment::with(['booking.room'])
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('status', 'pending')
            ->orderBy('payment_for_month')
            ->get()
            ->filter(function ($payment) {
                $booking = $payment->booking;
                if ($booking && $booking->move_out_date) {
                    $paymentMonth = Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
                    $moveOutDate = Carbon::parse($booking->move_out_date)->startOfMonth();
                    return $paymentMonth->lessThanOrEqualTo($moveOutDate);
                }
                return true;
            });

        $upcomingPayments = $upcomingRaw->map(function($payment) {
            $paymentMonth = Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
            $dueDate = $paymentMonth->copy()->startOfMonth();
            $today = now()->startOfDay();
            $daysUntilDue = $today->diffInDays($dueDate, false);
            
            // NEW: For first payments, never show as overdue
            $isFirstPayment = $payment->expires_at !== null;
            $isOverdue = !$isFirstPayment && ($daysUntilDue < 0);
            $isDueSoon = $daysUntilDue >= 0 && $daysUntilDue <= 7;

            if ($isFirstPayment) {
                $statusBadgeClass = 'status-pending';
                $statusText = 'Pending (24h)';
            } elseif ($isOverdue) {
                $statusBadgeClass = 'status-overdue';
                $statusText = 'Overdue';
            } elseif ($isDueSoon) {
                $statusBadgeClass = 'status-due-soon';
                $statusText = 'Due Soon';
            } else {
                $statusBadgeClass = 'status-upcoming';
                $statusText = 'Upcoming';
            }

            return (object)[
                'model' => $payment,
                'month_label' => $paymentMonth->format('F Y'),
                'due_date_label' => $dueDate->format('M d, Y'),
                'days_until_due' => $daysUntilDue,
                'is_overdue' => $isOverdue,
                'is_first_payment' => $isFirstPayment,
                'status_text' => $statusText,
                'status_badge_class' => $statusBadgeClass,
                'amount_display' => 'Rp ' . number_format($payment->amount, 0, ',', '.'),
                'late_fee' => $payment->late_fee,
                'booking_room_number' => optional($payment->booking->room)->room_number ?? '-',
            ];
        })->values()->take(3);

        return view('profile', compact('user', 'transactions', 'pendingPayments', 'totalPendingCount', 'upcomingPayments'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

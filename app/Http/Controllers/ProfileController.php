<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $pendingPayments = $transactions->filter(function ($payment) {
            if ($payment->status !== 'pending') {
                return false;
            }

            // Parse the payment month
            $paymentDate = Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
            $daysUntilDue = now()->diffInDays($paymentDate, false);
            
            // Show if overdue (negative days) or due within 10 days
            return $daysUntilDue <= 10;
        });

        // Count all pending payments for the badge
        $totalPendingCount = $transactions->where('status', 'pending')->count();

        return view('profile', compact('user', 'transactions', 'pendingPayments', 'totalPendingCount'));
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

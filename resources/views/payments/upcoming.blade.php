@extends('layouts.layout')
@section('title', 'Upcoming Payments')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .payment-timeline {
        position: relative;
        padding-left: 2rem;
    }
    .payment-timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #fbbf24, #3b82f6);
    }
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #0a0a0a;
        border-radius: 12px;
        border: 1px solid #2a2a2a;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 1.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: #fbbf24;
        border: 3px solid #000;
    }
    .timeline-item.due-soon::before {
        background: #f87171;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .payment-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .payment-month {
        font-size: 1.25rem;
        font-weight: 700;
        color: #FAEBD7;
    }
    .payment-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fbbf24;
    }
    .payment-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
        padding: 1rem;
        background: #1a1a1a;
        border-radius: 8px;
    }
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    .detail-label {
        font-size: 0.75rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .detail-value {
        font-size: 1rem;
        color: #FAEBD7;
        font-weight: 600;
        margin-top: 0.25rem;
    }
    .due-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .due-urgent {
        background: #991b1b;
        color: #fca5a5;
    }
    .due-soon {
        background: #92400e;
        color: #fbbf24;
    }
    .due-later {
        background: #1e3a8a;
        color: #60a5fa;
    }
</style>
@endpush

@section('content')
<section class="profile-section">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('profile') }}" style="color:#FAEBD7; text-decoration:none;">
                <i class="bi bi-arrow-left"></i> Back to Profile
            </a>
        </div>

        <div class="profile-card" style="margin-bottom: 2rem;">
            <h2 style="margin-bottom: 1rem;">
                <i class="bi bi-calendar-check"></i> Upcoming Payments
            </h2>
            <p style="color: #999;">View and manage your future payment schedule</p>

            @if($currentBooking)
                <div style="margin-top: 1rem; padding: 1rem; background: #1a1a1a; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <i class="bi bi-house-door" style="color: #fbbf24;"></i>
                        <span style="color: #999; font-size: 0.875rem;">Current Booking</span>
                    </div>
                    <div style="color: #FAEBD7; font-weight: 600;">
                        Room {{ $currentBooking->room->room_number ?? '-' }}
                        <span style="color: #999; font-weight: 400; margin-left: 0.5rem;">
                            • {{ $currentBooking->room->type ?? '-' }}
                            • Floor {{ $currentBooking->room->floor ?? '-' }}
                        </span>
                    </div>
                    <div style="color: #999; font-size: 0.875rem; margin-top: 0.5rem;">
                        Monthly Rent: <span style="color: #FAEBD7; font-weight: 600;">Rp {{ number_format($currentBooking->monthly_rent, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif
        </div>

        @if($upcomingPayments->isEmpty())
            <div class="transaction-card" style="text-align: center; padding: 3rem;">
                <i class="bi bi-calendar-x" style="font-size: 3rem; color: #666; margin-bottom: 1rem;"></i>
                <p style="color: #999; margin: 0;">No upcoming payments scheduled</p>
            </div>
        @else
            <div class="payment-timeline">
                @foreach($upcomingPayments as $payment)
                    @php
                        $paymentDate = \Carbon\Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
                        $daysUntilDue = now()->diffInDays($paymentDate, false);
                        $isOverdue = $daysUntilDue < 0;
                        $isDueSoon = $daysUntilDue >= 0 && $daysUntilDue <= 10;
                        $isDueLater = $daysUntilDue > 10;
                        
                        if ($isOverdue) {
                            $dueBadgeClass = 'due-urgent';
                            $dueBadgeText = 'Overdue';
                            $timelineClass = 'due-soon';
                        } elseif ($isDueSoon) {
                            $dueBadgeClass = 'due-soon';
                            $dueBadgeText = 'Due in ' . $daysUntilDue . ' days';
                            $timelineClass = 'due-soon';
                        } else {
                            $dueBadgeClass = 'due-later';
                            $dueBadgeText = 'Due in ' . $daysUntilDue . ' days';
                            $timelineClass = '';
                        }
                    @endphp

                    <div class="timeline-item {{ $timelineClass }}">
                        <div class="payment-info">
                            <div>
                                <div class="payment-month">{{ $paymentDate->format('F Y') }}</div>
                                <span class="due-badge {{ $dueBadgeClass }}">{{ $dueBadgeText }}</span>
                            </div>
                            <div class="payment-amount">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="payment-details">
                            <div class="detail-item">
                                <span class="detail-label">Room</span>
                                <span class="detail-value">
                                    {{ optional($payment->booking->room)->room_number ?? '-' }}
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Monthly Rent</span>
                                <span class="detail-value">
                                    Rp {{ number_format($payment->monthly_rent, 0, ',', '.') }}
                                </span>
                            </div>

                            @if($payment->late_fee > 0)
                            <div class="detail-item">
                                <span class="detail-label">Late Fee</span>
                                <span class="detail-value" style="color: #f87171;">
                                    Rp {{ number_format($payment->late_fee, 0, ',', '.') }}
                                </span>
                            </div>
                            @endif

                            <div class="detail-item">
                                <span class="detail-label">Status</span>
                                <span class="detail-value" style="color: #fbbf24; text-transform: uppercase;">
                                    {{ $payment->status }}
                                </span>
                            </div>

                            @if($payment->expires_at)
                            <div class="detail-item">
                                <span class="detail-label">Payment Window Expires</span>
                                <span class="detail-value" style="font-size: 0.875rem;">
                                    {{ $payment->expires_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                            @if($payment->status === 'pending')
                                <a href="{{ route('payment.show', $payment) }}" 
                                   class="btn" 
                                   style="background:#FAEBD7; color:#000; font-weight:600; padding:0.75rem 2rem; border-radius:8px; text-decoration:none; flex:1; text-align:center;">
                                    <i class="bi bi-credit-card"></i> Pay Now
                                </a>
                            @else
                                <button disabled 
                                        class="btn" 
                                        style="background:#666; color:#ccc; font-weight:600; padding:0.75rem 2rem; border-radius:8px; border:none; flex:1; cursor:not-allowed;">
                                    Payment Processing
                                </button>
                            @endif
                        </div>

                        @if($isOverdue)
                            <div style="margin-top: 1rem; padding: 0.75rem; background: #3a1a1a; border-left: 3px solid #f87171; border-radius: 4px;">
                                <i class="bi bi-exclamation-triangle" style="color: #f87171;"></i>
                                <span style="color: #fca5a5; font-size: 0.875rem; margin-left: 0.5rem;">
                                    This payment is overdue. Please complete it as soon as possible to avoid additional fees.
                                </span>
                            </div>
                        @elseif($isDueSoon)
                            <div style="margin-top: 1rem; padding: 0.75rem; background: #1a1a0a; border-left: 3px solid #fbbf24; border-radius: 4px;">
                                <i class="bi bi-clock" style="color: #fbbf24;"></i>
                                <span style="color: #fbbf24; font-size: 0.875rem; margin-left: 0.5rem;">
                                    Payment due soon. Complete before {{ $paymentDate->format('d M Y') }} to avoid late fees.
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
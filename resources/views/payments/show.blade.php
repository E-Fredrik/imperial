@extends('layouts.layout')
@section('title', 'Payment')

@push('styles')
<style>
    .payment-container {
        min-height: 70vh;
        background: #000;
        padding: 3rem 0;
    }
    .payment-card {
        background: #0a0a0a;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.6);
        color: #FAEBD7;
        max-width: 600px;
        margin: 0 auto;
    }
    .payment-details {
        margin-bottom: 2rem;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #2a2a2a;
    }
    .detail-label {
        color: #999;
    }
    .detail-value {
        font-weight: 600;
        color: #FAEBD7;
    }
    .pay-button {
        background: #FAEBD7;
        color: #000;
        border: none;
        padding: 1rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.3s;
    }
    .pay-button:hover {
        background: #E5D4B8;
        transform: translateY(-2px);
    }
    .pay-button:disabled {
        background: #666;
        cursor: not-allowed;
        transform: none;
    }
    .loading-spinner {
        display: none;
        margin-left: 10px;
    }
    .pay-button.loading .loading-spinner {
        display: inline-block;
    }
    .pay-button.loading .button-text {
        opacity: 0.7;
    }
</style>
@endpush

@section('content')
<section class="payment-container">
    <div class="container">
        <div class="payment-card">
            <h2 style="margin-bottom: 1.5rem; text-align: center;">Complete Payment</h2>
            
            <div class="payment-details">
                <div class="detail-row">
                    <span class="detail-label">Room</span>
                    <span class="detail-value">{{ optional($payment->booking->room)->room_number ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Period</span>
                    <span class="detail-value">{{ $payment->payment_for_month }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Monthly Rent</span>
                    <span class="detail-value">Rp {{ number_format($payment->monthly_rent, 0, ',', '.') }}</span>
                </div>
                @if($payment->late_fee > 0)
                <div class="detail-row">
                    <span class="detail-label">Late Fee</span>
                    <span class="detail-value" style="color: #ff6b6b;">Rp {{ number_format($payment->late_fee, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="detail-row" style="border-bottom: 2px solid #FAEBD7; margin-top: 1rem; padding-top: 1rem;">
                    <span class="detail-label" style="font-weight: 600; color: #FAEBD7;">Total Amount</span>
                    <span class="detail-value" style="font-size: 1.25rem;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <button id="pay-button" class="pay-button">
                <span class="button-text">Pay Now</span>
                <span class="loading-spinner">⏳</span>
            </button>
            
            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="{{ route('profile') }}" style="color: #999; text-decoration: none;">← Back to Profile</a>
            </div>

            <div style="margin-top: 2rem; padding: 1rem; background: #1a1a1a; border-radius: 8px;">
                <p style="color: #666; font-size: 0.85rem; margin: 0; text-align: center;">
                    <i class="bi bi-shield-check"></i> Secured by Midtrans Payment Gateway
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    const payButton = document.getElementById('pay-button');
    const snapToken = '{{ $snapToken }}';

    payButton.addEventListener('click', function() {
        // Disable button and show loading
        payButton.disabled = true;
        payButton.classList.add('loading');
        
        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = '{{ route("payment.finish") }}?order_id=' + result.order_id + '&transaction_status=settlement';
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = '{{ route("payment.finish") }}?order_id=' + result.order_id + '&transaction_status=pending';
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert('Payment failed. Please try again.');
                payButton.disabled = false;
                payButton.classList.remove('loading');
            },
            onClose: function() {
                console.log('Payment popup closed');
                payButton.disabled = false;
                payButton.classList.remove('loading');
            }
        });
    });
</script>
@endpush
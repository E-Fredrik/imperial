<x-admin-layout>
    <x-slot name="title">Payments Management</x-slot>
    <x-slot name="header">Payments Management</x-slot>
    <x-slot name="icon">bi-credit-card</x-slot>

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h3>All Payments</h3>
        </div>

        <div style="overflow-x: auto;">

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Booking</th>
                    <th>User</th>
                    <th>Room</th>
                    <th>Month</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="btn-admin-info" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                <i class="bi bi-link-45deg"></i> #{{ $payment->booking_id }}
                            </a>
                        </td>
                        <td>
                            {{ optional($payment->booking->user)->first_name ?? '-' }}
                            {{ optional($payment->booking->user)->last_name ?? '' }}<br />
                            <span style="font-size: 0.75rem; color: #999;">{{ optional($payment->booking->user)->email ?? '' }}</span>
                        </td>
                        <td><strong>{{ optional($payment->booking->room)->room_number ?? '-' }}</strong></td>
                        <td>{{ $payment->payment_for_month }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge-status badge-{{ $payment->status == 'accepted' ? 'available' : ($payment->status == 'pending' ? 'pending' : 'booked') }}">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="btn-admin-info">
                                    <i class="bi bi-eye"></i> View
                                </a>

                                @if($payment->status !== 'accepted')
                                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="accept" />
                                        <button type="submit" class="btn-admin-success">
                                            <i class="bi bi-check-circle"></i> Accept
                                        </button>
                                    </form>
                                @endif

                                @if($payment->status !== 'declined')
                                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}" onsubmit="return confirm('Decline this payment?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="decline" />
                                        <button type="submit" class="btn-admin-danger">
                                            <i class="bi bi-x-circle"></i> Decline
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 3rem; color: #666;">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p style="margin-top: 1rem;">No payments found.</p>
                        </td>
                    </tr>
                @endforelse
        </div>

        <div style="margin-top: 2rem;">
            {{ $payments->links() }}
        </div>
    </div>
</x-admin-layout>
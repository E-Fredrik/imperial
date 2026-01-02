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
            <h3><i class="bi bi-credit-card me-2"></i>All Payments</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.bookings.create') }}" class="btn-admin-primary">
                    <i class="bi bi-plus-circle"></i> New Booking
                </a>
            </div>
        </div>

        <div class="mb-3 p-3" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px;">
            <p style="color: #60a5fa; font-size: 0.9rem; margin: 0;">
                <i class="bi bi-info-circle me-1"></i>
                <strong>Note:</strong> Payments are processed via Midtrans. Status updates automatically when customers complete payment. You can still manually accept/decline payments for cash or offline transactions.
            </p>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 100px;">Booking</th>
                        <th style="width: 180px;">User</th>
                        <th style="width: 100px;">Room</th>
                        <th style="width: 120px;">Month</th>
                        <th style="width: 130px;">Amount</th>
                        <th style="width: 120px;">Payment Type</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td data-label="ID">{{ $payment->id }}</td>
                            <td data-label="Booking">
                                <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" style="color: #60a5fa; text-decoration: underline;">
                                    #{{ $payment->booking_id }}
                                </a>
                            </td>
                            <td data-label="User">
                                <div>
                                    <strong>{{ optional($payment->booking->user)->first_name ?? '-' }} {{ optional($payment->booking->user)->last_name ?? '' }}</strong>
                                </div>
                                <div style="font-size: 0.75rem; color: #999;">
                                    {{ optional($payment->booking->user)->email ?? '' }}
                                </div>
                            </td>
                            <td data-label="Room">
                                <strong>{{ optional($payment->booking->room)->room_number ?? '-' }}</strong>
                            </td>
                            <td data-label="Month">
                                {{ $payment->payment_for_month }}
                            </td>
                            <td data-label="Amount">
                                <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                                @if($payment->late_fee > 0)
                                    <div style="font-size: 0.75rem; color: #f87171;">
                                        +Rp {{ number_format($payment->late_fee, 0, ',', '.') }} late fee
                                    </div>
                                @endif
                            </td>
                            <td data-label="Payment Type">
                                <span style="font-size: 0.875rem; color: #999;">
                                    {{ $payment->payment_type ?? 'N/A' }}
                                </span>
                            </td>
                            <td data-label="Status">
                                <span class="status-badge status-{{ $payment->status }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="btn-admin-info" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    
                                    @if($payment->status === 'pending')
                                        <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="accept" />
                                            <button type="submit" class="btn-admin-primary" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;" title="Manual accept (for cash payments)">
                                                <i class="bi bi-check-circle"></i> Accept
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.payments.update', $payment) }}" onsubmit="return confirm('Decline this payment?');" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="decline" />
                                            <button type="submit" class="btn-admin-danger" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;">
                                                <i class="bi bi-x-circle"></i> Decline
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No payments found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
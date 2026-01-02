<x-admin-layout>
    <x-slot name="title">Booking Details</x-slot>
    <x-slot name="header">Booking Details</x-slot>
    <x-slot name="icon">bi-calendar-check</x-slot>

    <div class="admin-card" style="max-width: 1200px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-calendar-check me-2"></i>Booking #{{ $booking->id }}</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.bookings.index') }}" class="btn-admin-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Bookings
                </a>
                @if($booking->status === 'pending')
                    <form action="{{ route('admin.bookings.decline', $booking) }}" method="POST" onsubmit="return confirm('Decline this booking and the latest payment?');" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-admin-danger">
                            <i class="bi bi-x-circle"></i> Decline Booking
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success mb-4">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->has('move_out_date'))
            <div class="alert-danger mb-4">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first('move_out_date') }}
            </div>
        @endif

        <div class="row g-4 mb-4">
            <!-- Left Column: User & Room Info -->
            <div class="col-lg-8">
                <!-- User Information -->
                <div class="info-section mb-4">
                    <h4 class="section-title">
                        <i class="bi bi-person-circle me-2"></i>User Information
                    </h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Name</span>
                            <span class="info-value">{{ optional($booking->user)->first_name ?? '-' }} {{ optional($booking->user)->last_name ?? '' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ optional($booking->user)->email ?? '-' }}</span>
                        </div>
                        @if(optional($booking->user)->phone_number)
                            <div class="info-item">
                                <span class="info-label">Phone</span>
                                <span class="info-value">{{ $booking->user->phone_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Room Information -->
                <div class="info-section mb-4">
                    <h4 class="section-title">
                        <i class="bi bi-door-closed me-2"></i>Room Information
                    </h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Room Number</span>
                            <span class="info-value">{{ optional($booking->room)->room_number ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Type</span>
                            <span class="info-value">{{ optional($booking->room)->type ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Price</span>
                            <span class="info-value">Rp {{ number_format(optional($booking->room)->price ?? $booking->monthly_rent, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Room Status</span>
                            <span class="status-badge status-{{ optional($booking->room)->status ?? 'unavailable' }}">
                                {{ ucfirst(optional($booking->room)->status ?? 'N/A') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="info-section">
                    <h4 class="section-title">
                        <i class="bi bi-calendar-event me-2"></i>Booking Details
                    </h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Move-in Date</span>
                            <span class="info-value">{{ optional($booking->move_in_date)->format('M d, Y') ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Move-out Date</span>
                            <div class="d-flex align-items-center gap-2">
                                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="d-flex align-items-center gap-2" style="flex: 1;">
                                    @csrf
                                    @method('PUT')
                                    <input
                                        type="date"
                                        name="move_out_date"
                                        value="{{ old('move_out_date', optional($booking->move_out_date)->format('Y-m-d')) }}"
                                        class="form-control"
                                        style="background: #111; color: #FAEBD7; border: 1px solid #333; padding: 0.5rem; border-radius: 6px; max-width: 200px;">
                                    <button type="submit" class="btn-admin-primary" style="padding: 0.5rem 1rem; white-space: nowrap;">
                                        <i class="bi bi-check-circle"></i> Save
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="info-item text-end">
                            <span class="info-label">Monthly Rent</span>
                            <span class="info-value">Rp {{ number_format($booking->monthly_rent, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Booking Status</span>
                            <span class="badge-status badge-{{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <h4 class="summary-title">
                        <i class="bi bi-graph-up me-2"></i>Summary
                    </h4>
                    <div class="summary-stats">
                        <div class="summary-stat">
                            <div class="stat-label">Monthly Rent</div>
                            <div class="stat-value">Rp {{ number_format($booking->monthly_rent, 0, ',', '.') }}</div>
                        </div>
                        <div class="summary-stat">
                            <div class="stat-label">Total Payments</div>
                            <div class="stat-value">Rp {{ number_format($booking->payments->sum('amount'), 0, ',', '.') }}</div>
                        </div>
                        <div class="summary-stat">
                            <div class="stat-label">Payment Count</div>
                            <div class="stat-value">{{ $booking->payments->count() }}</div>
                        </div>
                        <div class="summary-stat">
                            <div class="stat-label">Pending Payments</div>
                            <div class="stat-value" style="color: #fbbf24;">
                                {{ $booking->payments->where('status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="summary-stat">
                            <div class="stat-label">Accepted Payments</div>
                            <div class="stat-value" style="color: #4ade80;">
                                {{ $booking->payments->where('status', 'accepted')->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="payments-section">
            <h4 class="section-title mb-3">
                <i class="bi bi-credit-card me-2"></i>Payment History
            </h4>
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 120px;">Month</th>
                            <th style="width: 130px;">Amount</th>
                            <th style="width: 100px;">Proof</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->payments as $payment)
                            <tr>
                                <td data-label="ID">{{ $payment->id }}</td>
                                <td data-label="Month">{{ $payment->payment_for_month }}</td>
                                <td data-label="Amount">
                                    <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                                    @if($payment->late_fee > 0)
                                        <br><small style="color: #f87171;">+Rp {{ number_format($payment->late_fee, 0, ',', '.') }} late fee</small>
                                    @endif
                                </td>
                                <td data-label="Proof">
                                    @php
                                        $path = $payment->proof ?? '';
                                        if ($path !== '' && file_exists(public_path($path))) {
                                            $url = asset($path);
                                        } elseif ($path) {
                                            $url = asset('storage/' . ltrim($path, '/'));
                                        } else {
                                            $url = null;
                                        }
                                    @endphp
                                    @if($url)
                                        <a href="{{ $url }}" target="_blank" class="btn-admin-info" style="padding: 0.3rem 0.8rem; font-size: 0.875rem;">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    @else
                                        <span style="color: #666;">—</span>
                                    @endif
                                </td>
                                <td data-label="Status">
                                    <span class="badge-status badge-{{ $payment->status }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td data-label="Actions">
                                    <div class="d-flex gap-2 flex-wrap">
                                        @if($payment->status !== 'accepted')
                                            <form method="POST" action="{{ route('admin.payments.update', $payment) }}" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="accept" />
                                                <button type="submit" class="btn-admin-primary" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;">
                                                    <i class="bi bi-check-circle"></i> Accept
                                                </button>
                                            </form>
                                        @endif

                                        @if($payment->status !== 'declined')
                                            <form method="POST" action="{{ route('admin.payments.update', $payment) }}" onsubmit="return confirm('Decline this payment?');" style="display: inline;">
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
                                <td colspan="6" style="text-align: center; padding: 3rem; color: #666;">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p style="margin-top: 1rem;">No payments recorded.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
    .info-section {
        background: rgba(250, 235, 215, 0.03);
        border: 1px solid rgba(250, 235, 215, 0.1);
        border-radius: 12px;
        padding: 1.5rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #FAEBD7;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    /* Right-align specific info items (e.g., Monthly Rent) */
    .info-item.text-end {
        justify-self: end;
        text-align: right;
    }

    .info-item.text-end .info-label,
    .info-item.text-end .info-value {
        display: block;
        text-align: right;
    }

    .info-label {
        font-size: 0.875rem;
        color: #999;
        font-weight: 500;
    }

    .info-value {
        font-size: 1rem;
        color: #FAEBD7;
        font-weight: 600;
    }

    .summary-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        height: 100%;
    }

    .summary-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #60a5fa;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .summary-stats {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .summary-stat {
        padding: 1rem;
        background: rgba(250, 235, 215, 0.03);
        border-radius: 8px;
        border: 1px solid rgba(250, 235, 215, 0.1);
    }

    .stat-label {
        font-size: 0.875rem;
        color: #999;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #FAEBD7;
    }

    .payments-section {
        margin-top: 2rem;
        padding: 1.5rem;
        background: rgba(250, 235, 215, 0.03);
        border: 1px solid rgba(250, 235, 215, 0.1);
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .summary-card {
            margin-top: 1rem;
        }
    }
    </style>
</x-admin-layout>
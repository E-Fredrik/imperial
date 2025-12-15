<x-admin-layout>
    <x-slot name="title">Bookings Management</x-slot>
    <x-slot name="header">Bookings Management</x-slot>
    <x-slot name="icon">bi-calendar-check</x-slot>

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h3>All Bookings</h3>
            <a href="{{ route('admin.bookings.create') }}" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Create Booking
            </a>
        </div>

        <div style="overflow-x: auto;">

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Room</th>
                    <th>Move-in</th>
                    <th>Rent</th>
                    <th>Proof</th>
                    <th>Payments</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>
                            {{ optional($booking->user)->first_name ?? '-' }}
                            {{ optional($booking->user)->last_name ?? '' }}<br/>
                            <span style="font-size: 0.75rem; color: #999;">{{ optional($booking->user)->email ?? '' }}</span>
                        </td>
                        <td><strong>{{ optional($booking->room)->room_number ?? '-' }}</strong></td>
                        <td>{{ optional($booking->move_in_date)->format('Y-m-d') ?? '-' }}</td>
                        <td>Rp {{ number_format($booking->monthly_rent, 0, ',', '.') }}</td>
                        <td>
                                            @php
                                                $p = $booking->payments->last();
                                                $proofPath = $p->proof ?? '';
                                                if ($proofPath !== '' && file_exists(public_path($proofPath))) {
                                                    $proofUrl = asset($proofPath);
                                                } elseif ($proofPath) {
                                                    $proofUrl = asset('storage/' . ltrim($proofPath, '/'));
                                                } else {
                                                    $proofUrl = null;
                                                }
                                            @endphp
                            @if($proofUrl)
                                <a href="{{ $proofUrl }}" target="_blank" class="btn-admin-info" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            @else
                                <span style="color: #666;">—</span>
                            @endif
                        </td>
                        <td>
                            @foreach($booking->payments as $p)
                                <div style="margin-bottom: 0.5rem;">
                                    <strong>Rp {{ number_format($p->amount, 0, ',', '.') }}</strong>
                                    <span style="color: #999; font-size: 0.75rem;"> — {{ $p->status }}</span>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge-status badge-{{ $booking->status }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-admin-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                @if($booking->status === 'pending')
                                    <form action="{{ route('admin.bookings.decline', $booking) }}" method="POST" onsubmit="return confirm('Decline this booking and the latest payment?');">
                                        @csrf
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
                        <td colspan="9" style="text-align: center; padding: 3rem; color: #666;">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p style="margin-top: 1rem;">No bookings found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </div>

        <div style="margin-top: 2rem;">
            {{ $bookings->links() }}
        </div>
    </div>
</x-admin-layout>
<x-admin-layout>
    <x-slot name="title">Bookings Management</x-slot>
    <x-slot name="header">Bookings Management</x-slot>
    <x-slot name="icon">bi-calendar-check</x-slot>

    <link href="{{ asset('css/booking.css') }}" rel="stylesheet">

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-calendar-check me-2"></i>All Bookings</h3>
            <a href="{{ route('admin.bookings.create') }}" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Add New Booking
            </a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Room</th>
                        <th>ID Card</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td data-label="ID">#{{ $booking->id }}</td>
                            <td data-label="User">
                                <div>
                                    <strong style="color: #FAEBD7;">{{ $booking->user->name ?? 'N/A' }}</strong>
                                    <small style="display: block; opacity: 0.8;">{{ $booking->user->email ?? '' }}</small>
                                </div>
                            </td>
                            <td data-label="Room">
                                <strong style="color: #FAEBD7;">{{ $booking->room->room_number ?? 'N/A' }}</strong>
                                <small style="display: block; opacity: 0.8;">Floor {{ $booking->room->floor ?? '' }}</small>
                            </td>
                            <td data-label="ID Card">
                                @if($booking->user->id_card)
                                    <button class="btn-admin-info btn-sm" data-bs-toggle="modal" data-bs-target="#idCardModal{{ $booking->id }}">
                                        <i class="bi bi-card-image"></i> View ID Card
                                    </button>
                                @else
                                    <span style="opacity: 0.6;">No ID Card</span>
                                @endif
                            </td>
                            <td data-label="Duration">
                                <div>
                                    <strong style="color: #FAEBD7;">Start:</strong>
                                    <span>{{ $booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') : 'Not set' }}</span>
                                    <br>
                                    <strong style="color: #FAEBD7;">End:</strong>
                                    <span>{{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') : 'Not set' }}</span>
                                </div>
                            </td>
                            <td data-label="Status">
                                <span class="status-badge status-{{ strtolower($booking->status) }}">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-admin-secondary btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this booking?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- ID Card Modal -->
                        @if($booking->user->id_card)
                        <div class="modal fade" id="idCardModal{{ $booking->id }}" tabindex="-1" aria-labelledby="idCardModalLabel{{ $booking->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="background: #1a1a1a; border: 2px solid rgba(250, 235, 215, 0.2);">
                                    <div class="modal-header" style="border-bottom: 1px solid rgba(250, 235, 215, 0.1);">
                                        <h5 class="modal-title" style="color: #FAEBD7;">
                                            <i class="bi bi-card-image me-2"></i>ID Card - {{ $booking->user->name }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center" style="padding: 2rem;">
                                        <img src="{{ asset('storage/' . $booking->user->id_card) }}" 
                                             alt="ID Card" 
                                             style="max-width: 100%; height: auto; border-radius: 8px; cursor: zoom-in;"
                                             onclick="this.style.transform = this.style.transform === 'scale(1.5)' ? 'scale(1)' : 'scale(1.5)'">
                                        <p style="margin-top: 1rem; color: rgba(250, 235, 215, 0.7); font-size: 0.875rem;">
                                            <i class="bi bi-info-circle"></i> Click image to zoom
                                        </p>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid rgba(250, 235, 215, 0.1);">
                                        <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem;">
                                <div class="empty-state">
                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                                    <p style="margin-top: 1rem; opacity: 0.7;">No bookings found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(250, 235, 215, 0.1);">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
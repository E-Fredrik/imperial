<x-admin-layout>
    <x-slot name="title">Rooms Management</x-slot>
    <x-slot name="header">Rooms Management</x-slot>
    <x-slot name="icon">bi-door-closed</x-slot>

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-door-closed me-2"></i>All Rooms</h3>
            <a href="{{ route('admin.rooms.create') }}" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Add New Room
            </a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Floor</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td data-label="ID">{{ $room->id }}</td>
                            <td data-label="Room"><strong style="font-size: 1.1rem; color: #FAEBD7;">{{ $room->room_number }}</strong></td>
                            <td data-label="Type">{{ $room->type }}</td>
                            <td data-label="Floor">{{ $room->floor }}F</td>
                            <td data-label="Size">{{ $room->length }}x{{ $room->width }}m</td>
                            <td data-label="Price"><strong>Rp {{ number_format($room->price, 0, ',', '.') }}</strong></td>
                            <td data-label="Status">
                                <span class="status-badge status-{{ $room->status }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-admin-secondary">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this room?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No rooms found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rooms->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $rooms->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

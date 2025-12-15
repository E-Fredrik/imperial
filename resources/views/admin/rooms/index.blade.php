<x-admin-layout>
    <x-slot name="title">Rooms Management</x-slot>
    <x-slot name="header">Rooms Management</x-slot>
    <x-slot name="icon">bi-door-closed</x-slot>

    <div class="admin-card">
        <div class="card-header">
            <h3>All Rooms</h3>
            <a href="{{ route('admin.rooms.create') }}" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Add New Room
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Floor</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th style="width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td><strong style="font-size: 1.1rem; color: #FAEBD7;">{{ $room->room_number }}</strong></td>
                            <td>{{ $room->type }}</td>
                            <td>{{ $room->floor }}F</td>
                            <td>{{ $room->length }}x{{ $room->width }}m</td>
                            <td><strong>Rp {{ number_format($room->price, 0, ',', '.') }}</strong></td>
                            <td>
                                <span class="badge-status badge-{{ $room->status }}">
                                    {{ $room->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-admin-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

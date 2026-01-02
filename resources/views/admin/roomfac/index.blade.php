<x-admin-layout>
    <x-slot name="title">Room Facilities Management</x-slot>
    <x-slot name="header">Room Facilities Management</x-slot>
    <x-slot name="icon">bi-check2-square</x-slot>

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-check2-square me-2"></i>All Room Facilities</h3>
            <a href="{{ route('admin.roomfac.create') }}" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Add New Facility
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 200px;">Name</th>
                        <th>Description</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilities as $facility)
                        <tr>
                            <td data-label="ID">{{ $facility->id }}</td>
                            <td data-label="Name"><strong>{{ $facility->name }}</strong></td>
                            <td data-label="Description">
                                <div style="max-height: 100px; overflow: auto; color: #FAEBD7;">
                                    {!! $facility->description !!}
                                </div>
                            </td>
                            <td data-label="Actions">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.roomfac.edit', $facility) }}" class="btn-admin-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.roomfac.destroy', $facility) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
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
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No room facilities found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($facilities->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $facilities->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

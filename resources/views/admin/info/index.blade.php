<x-admin-layout>
    <x-slot name="title">Information Management</x-slot>
    <x-slot name="header">Information Management</x-slot>
    <x-slot name="icon">bi-info-circle</x-slot>

    @if (session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="card-header">
            <h3>All Information</h3>
            @if (Route::has('admin.info.create'))
                <a href="{{ route('admin.info.create') }}" class="btn-admin-primary">
                    <i class="bi bi-plus-circle"></i> Create New Information
                </a>
            @endif
        </div>

        <div style="overflow-x: auto;">

        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 200px;">Title</th>
                    <th>Content</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($info as $information)
                    <tr>
                        <td>{{ $information->id }}</td>
                        <td><strong>{{ $information->title }}</strong></td>
                        <td>
                            <div style="max-height: 100px; overflow: auto; color: #FAEBD7;">
                                {!! $information->content !!}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.info.edit', $information) }}" class="btn-admin-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.info.destroy', $information) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
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
                        <td colspan="4" style="text-align: center; padding: 3rem; color: #666;">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p style="margin-top: 1rem;">No information entries found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </div>

        <div style="margin-top: 2rem;">
            {{ $info->links() }}
        </div>
    </div>
</x-admin-layout>
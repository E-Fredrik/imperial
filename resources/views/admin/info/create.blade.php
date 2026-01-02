<x-admin-layout>
    <x-slot name="title">Add Information</x-slot>
    <x-slot name="header">Add Information</x-slot>
    <x-slot name="icon">bi-info-circle</x-slot>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-info-circle me-2"></i>Create New Information</h3>
            <a href="{{ route('admin.info.index') }}" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Information
            </a>
        </div>

        @if ($errors->any())
            <div class="alert-danger">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.info.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="form-group">
                <label for="title">
                    <i class="bi bi-tag me-1"></i>Title
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}"
                    required
                    placeholder="e.g., Terms & Conditions, House Rules">
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content">
                    <i class="bi bi-card-text me-1"></i>Content
                </label>
                <x-trix-input 
                    id="content" 
                    name="content" 
                    :value="old('content')" 
                    autocomplete="off" />
                <small>
                    <i class="bi bi-info-circle me-1"></i>Use the editor toolbar to format your content
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="{{ route('admin.info.index') }}" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Create Information
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="title">Edit Room Facility</x-slot>
    <x-slot name="header">Edit Room Facility</x-slot>
    <x-slot name="icon">bi-check2-square</x-slot>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-check2-square me-2"></i>Edit Room Facility</h3>
            <a href="{{ route('admin.roomfac.index') }}" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Facilities
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

        <form action="{{ route('admin.roomfac.update', $roomfac) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="form-group">
                <label for="name">
                    <i class="bi bi-tag me-1"></i>Facility Name
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $roomfac->name) }}"
                    required
                    placeholder="e.g., Air Conditioner, Water Heater, Private Bathroom">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">
                    <i class="bi bi-card-text me-1"></i>Description
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    placeholder="Describe the facility details...">{{ old('description', $roomfac->description) }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="{{ route('admin.roomfac.index') }}" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Update Facility
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

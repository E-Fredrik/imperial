<x-admin-layout>
    <x-slot name="title">Edit Kost Facility</x-slot>
    <x-slot name="header">Edit Kost Facility</x-slot>
    <x-slot name="icon">bi-building</x-slot>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-building me-2"></i>Edit Kost Facility</h3>
            <a href="{{ route('admin.kostfac.index') }}" class="btn-admin-secondary">
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

        <form action="{{ route('admin.kostfac.update', $kostfac) }}" method="POST" enctype="multipart/form-data">
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
                    value="{{ old('name', $kostfac->name) }}"
                    required
                    placeholder="e.g., WiFi, Parking, Swimming Pool">
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
                    placeholder="Describe the facility details...">{{ old('description', $kostfac->description) }}</textarea>
            </div>

            <!-- Existing Images -->
            @if($kostfac->facilities_images->isNotEmpty())
                <div class="form-group">
                    <label>
                        <i class="bi bi-images me-1"></i>Existing Images
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        @foreach($kostfac->facilities_images as $fi)
                            @php
                                $image = $fi->image;
                                $path = $image->image_path ?? '';
                                $publicCandidate = public_path($path);
                                if ($path !== '' && file_exists($publicCandidate)) {
                                    $imgUrl = asset($path);
                                } else {
                                    $imgUrl = asset('storage/' . ltrim($path, '/'));
                                }
                            @endphp
                            <div style="position: relative; background: rgba(250, 235, 215, 0.05); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 10px; padding-top: 0.75rem; padding-right: 0.75rem; padding-left: 0.75rem;">
                                <img
                                    id="thumb-{{ $image->id }}"
                                    data-image-id="{{ $image->id }}"
                                    data-original-src="{{ $imgUrl }}"
                                    src="{{ $imgUrl }}"
                                    alt="Facility image"
                                    style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 0.8rem;"
                                />
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label for="replace-{{ $image->id }}" style="cursor: pointer; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 6px; padding: 0.5rem; text-align: center; color: #60a5fa; font-size: 0.875rem; transition: all 0.2s;">
                                        <i class="bi bi-arrow-repeat me-1"></i>Replace
                                    </label>
                                    <input 
                                        id="replace-{{ $image->id }}"
                                        type="file"
                                        name="replace_images[{{ $image->id }}]"
                                        accept="image/*"
                                        class="replace-input"
                                        data-image-id="{{ $image->id }}"
                                        style="display: none;">
                                    <span id="status-{{ $image->id }}" style="font-size: 0.75rem; color: #999; text-align: center; min-height: 1rem;"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Add New Images -->
            <div class="form-group">
                <label for="images">
                    <i class="bi bi-images me-1"></i>Add New Images (Optional)
                </label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    multiple 
                    accept="image/*">
                <small>
                    <i class="bi bi-info-circle me-1"></i>Upload additional images (PNG, JPG, JPEG)
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="{{ route('admin.kostfac.index') }}" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Update Facility
                </button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/editRoom.js') }}"></script>
</x-admin-layout>
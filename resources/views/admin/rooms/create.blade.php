<x-admin-layout>
    <x-slot name="title">Add New Room</x-slot>
    <x-slot name="header">Add New Room</x-slot>
    <x-slot name="icon">bi-door-closed</x-slot>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-door-closed me-2"></i>Create New Room</h3>
            <a href="{{ route('admin.rooms.index') }}" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Rooms
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

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Room Number -->
            <div class="form-group">
                <label for="room_number">
                    <i class="bi bi-hash me-1"></i>Room Number
                </label>
                <input 
                    type="text" 
                    name="room_number" 
                    id="room_number" 
                    value="{{ old('room_number') }}"
                    required
                    placeholder="e.g., A, B, C, 101, 102">
            </div>

            <div class="row g-3">
                <!-- Price -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">
                            <i class="bi bi-cash-coin me-1"></i>Monthly Price (Rp)
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                value="{{ old('price') }}"
                                required
                                placeholder="1850000">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('price').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('price').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">
                            <i class="bi bi-collection me-1"></i>Room Type
                        </label>
                        <input 
                            type="text" 
                            name="type" 
                            id="type" 
                            value="{{ old('type') }}"
                            required
                            placeholder="e.g., Single, Double, Suite">
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <!-- Length -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="length">
                            <i class="bi bi-arrows-expand me-1"></i>Length (m)
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                step="0.01"
                                name="length" 
                                id="length" 
                                value="{{ old('length') }}"
                                required
                                placeholder="3">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('length').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('length').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Width -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="width">
                            <i class="bi bi-arrows-expand me-1"></i>Width (m)
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                step="0.01"
                                name="width" 
                                id="width" 
                                value="{{ old('width') }}"
                                required
                                placeholder="2">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('width').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('width').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floor -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="floor">
                            <i class="bi bi-building me-1"></i>Floor
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                name="floor" 
                                id="floor" 
                                value="{{ old('floor') }}"
                                required
                                placeholder="1">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('floor').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('floor').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">
                    <i class="bi bi-toggle-on me-1"></i>Status
                </label>
                <select name="status" id="status" required>
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
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
                    placeholder="Describe the room features and amenities...">{{ old('description') }}</textarea>
            </div>

            <!-- Regular Room Images -->
            <div class="form-group">
                <label for="images">
                    <i class="bi bi-images me-1"></i>Room Images (Optional)
                </label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    multiple 
                    accept="image/*">
                <small>
                    <i class="bi bi-info-circle me-1"></i>Upload multiple regular room images (PNG, JPG, JPEG). These will be shown in the carousel.
                </small>
            </div>

            <!-- 360° Room Image (NEW) -->
            <div class="form-group">
                <label for="image_360">
                    <i class="bi bi-globe me-1"></i>360° Panoramic Image (Optional)
                </label>
                <input 
                    type="file" 
                    name="image_360" 
                    id="image_360" 
                    accept="image/*">
                <small style="display: block; margin-top: 0.5rem;">
                    <i class="bi bi-info-circle me-1"></i>Upload a 360° equirectangular panoramic image for the immersive room view
                </small>
                <small style="display: block; margin-top: 0.25rem; color: rgba(250, 235, 215, 0.5);">
                    <i class="bi bi-lightbulb me-1"></i>Tip: Use a 360° camera or panorama app to capture the full room view. Recommended format: JPEG, aspect ratio 2:1
                </small>
            </div>

            <!-- Facilities -->
            <div class="form-group">
                <label>
                    <i class="bi bi-check2-square me-1"></i>Facilities
                </label>
                <div class="facilities-grid">
                    @foreach($facilities as $facility)
                        <label class="facility-label">
                            <input type="checkbox" 
                                   name="facilities[]" 
                                   value="{{ $facility->id }}" 
                                   {{ is_array(old('facilities')) && in_array($facility->id, old('facilities')) ? 'checked' : '' }}>
                            <span>{{ $facility->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="{{ route('admin.rooms.index') }}" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Create Room
                </button>
            </div>
        </form>
    </div>

    <script>
        // 360° Image preview functionality
        document.getElementById('image_360').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-360-preview');
                    const container = document.getElementById('image-360-preview-container');
                    preview.src = e.target.result;
                    container.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else if (!file) {
                document.getElementById('image-360-preview-container').style.display = 'none';
            }
        });
    </script>
</x-admin-layout>
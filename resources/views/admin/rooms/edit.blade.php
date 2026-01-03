<x-admin-layout>
    <x-slot name="title">Edit Room</x-slot>
    <x-slot name="header">Edit Room</x-slot>
    <x-slot name="icon">bi-door-closed</x-slot>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-door-closed me-2"></i>Edit Room</h3>
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

        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Room Number -->
            <div class="form-group">
                <label for="room_number">
                    <i class="bi bi-hash me-1"></i>Room Number
                </label>
                <input 
                    type="text" 
                    name="room_number" 
                    id="room_number" 
                    value="{{ old('room_number', $room->room_number) }}"
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
                                value="{{ old('price', $room->price) }}"
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
                            value="{{ old('type', $room->type) }}"
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
                                value="{{ old('length', $room->length) }}"
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
                                value="{{ old('width', $room->width) }}"
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
                                value="{{ old('floor', $room->floor) }}"
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
                    @php $s = old('status', $room->status ?? 'available'); @endphp
                    <option value="available" {{ $s === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ $s === 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="unavailable" {{ $s === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
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
                    placeholder="Describe the room features and amenities...">{{ old('description', $room->description) }}</textarea>
            </div>

            <!-- Existing Images -->
            @if($room->rooms_images->isNotEmpty())
                <div class="form-group">
                    <label>
                        <i class="bi bi-images me-1"></i>Existing Images
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        @foreach($room->rooms_images as $ri)
                            @php
                                $image = $ri->image;
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
                                    alt="Room image"
                                    style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 0.8rem;"
                                />
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label for="replace-{{ $image->id }}" class="btn-admin-secondary" style="width: 100%; justify-content: center; font-size: 0.85rem; padding: 0.5rem;">
                                        <i class="bi bi-upload me-1"></i> Replace
                                    </label>
                                    <input
                                        id="replace-{{ $image->id }}"
                                        type="file"
                                        name="replace_images[{{ $image->id }}]"
                                        accept="image/*"
                                        style="display: none;"
                                        class="replace-input"
                                        data-image-id="{{ $image->id }}"
                                    />
                                    <span id="status-{{ $image->id }}" style="font-size: 0.75rem; color: #999; text-align: center;"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <small style="display: block; margin-top: 0.5rem;">
                        <i class="bi bi-info-circle me-1"></i>Click "Replace" to choose a new image for each slot
                    </small>
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

            <!-- Facilities -->
            <div class="form-group">
                <label>
                    <i class="bi bi-check2-square me-1"></i>Facilities
                </label>
                <div class="facilities-grid">
                    @php
                        // Get current facility IDs from the room
                        $currentFacilityIds = $room->rooms_facilities()->pluck('facility_id')->toArray();
                    @endphp
                    @foreach($facilities as $facility)
                        <label class="facility-label">
                            <input type="checkbox" 
                                   name="facilities[]" 
                                   value="{{ $facility->id }}" 
                                   {{ in_array($facility->id, $currentFacilityIds) ? 'checked' : '' }}>
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
                    <i class="bi bi-check-circle"></i> Update Room
                </button>
            </div>
        </form>
    </div>

    <script src="{{ asset('JS/editRoom.js') }}"></script>
</x-admin-layout>
@props(['room'])

<div id="roomModal-{{ $room->id }}" class="room-modal" style="display: none; opacity: 0; visibility: hidden;">
    <div class="modal-backdrop" onclick="closeRoomModal({{ $room->id }})"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeRoomModal({{ $room->id }})">
            <i class="bi bi-arrow-left"></i> Back
        </button>
        
        <div class="modal-body">
            <div class="modal-images">
                <div id="roomCarousel-{{ $room->id }}" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        @php
                            $regularImages = $room->images()->where('is_360', false)->get();
                        @endphp
                        
                        @if($regularImages->count() > 0)
                            @foreach($regularImages as $index => $image)
                                @php
                                    $imagePath = $image->image_path;
                                    $publicPath = public_path($imagePath);
                                    
                                    if (file_exists($publicPath)) {
                                        $imageUrl = asset($imagePath);
                                    } else {
                                        $imageUrl = asset('storage/' . ltrim($imagePath, '/'));
                                    }
                                @endphp
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $imageUrl }}" alt="Room {{ $room->room_number }}" style="width: 100%; height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <div class="no-image-modal" style="width: 100%; height: 400px; display: flex; align-items: center; justify-content: center; background: #2a2a2a; color: #999;">
                                    <div style="text-align: center;">
                                        <i class="bi bi-image" style="font-size: 4rem;"></i>
                                        <p style="margin-top: 1rem;">No Image Available</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($regularImages->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel-{{ $room->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel-{{ $room->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
                
                <div class="room-3d-view">
                    <h4 style="color:#FAEBD7; margin-bottom:1rem;">3D Room View</h4>

                    @php
                        $image360 = $room->images()->where('is_360', true)->first();
                    @endphp

                    @if($image360)
                        @php
                            $imagePath = $image360->image_path;
                            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                $panoramaUrl = $imagePath;
                            } elseif (file_exists(public_path($imagePath))) {
                                $panoramaUrl = asset($imagePath);
                            } else {
                                $panoramaUrl = asset('storage/' . ltrim($imagePath, '/'));
                            }
                        @endphp
                        <div class="panellum-container">
                            <div id="panorama-{{ $room->id }}" class="panellum-viewer" data-panorama-url="{{ $panoramaUrl }}"></div>
                        </div>
                    @else
                        <div class="view-placeholder">
                            <i class="bi bi-box" style="font-size:3rem; color:#666;"></i>
                            <p style="color:#999; margin-top:1rem;">360° view not available</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="modal-info">
                <div class="info-header">
                    <div>
                        <h2>Room {{ $room->room_number }}</h2>
                        <p>{{ $room->type }} • {{ $room->length }}x{{ $room->width }}m • Floor {{ $room->floor }}</p>
                    </div>
                </div>
                
                <div class="price-section">
                    <div class="price-badge">
                        <span class="monthly-label">Monthly Rate</span>
                        <span class="price">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                    </div>
                    <span class="availability-tag {{ $room->status }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </div>
                
                <div class="facilities-section">
                    <h3>Facilities</h3>
                    <div class="facilities-grid">
                        @php
                            $facilities = $room->rooms_facilities()->with('room_facility')->get();
                        @endphp
                        
                        @if($facilities->count() > 0)
                            @foreach($facilities as $roomFacility)
                                @if($roomFacility->room_facility)
                                    <div class="facility-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>{{ $roomFacility->room_facility->name }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p style="color:#999;">No facilities listed</p>
                        @endif
                    </div>
                </div>
                
                @if($room->description)
                    <div class="description-section">
                        <h3>Description</h3>
                        <p style="color:#ccc;">{{ $room->description }}</p>
                    </div>
                @endif
                
                <div class="booking-section">
                    <h3>Book This Room</h3>
                    <form action="{{ route('bookings.create') }}" method="GET">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        
                        <div class="date-input-group">
                            <label for="check_in_{{ $room->id }}">Move-in Date</label>
                            <input type="date" 
                                   id="check_in_{{ $room->id }}" 
                                   name="check_in" 
                                   class="form-control" 
                                   style="background:#2a2a2a; border:1px solid #666; color:#FAEBD7; padding:0.8rem; border-radius:8px;"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                        </div>
                        
                        <div class="action-buttons">
                            <button type="button" class="btn-cancel" onclick="closeRoomModal({{ $room->id }})">Cancel</button>
                            @if($room->status === 'available')
                                @auth
                                    <button type="submit" class="btn-book">Book Now</button>
                                @else
                                    <button type="button" class="btn-book" onclick="alert('Please login to book a room'); window.location.href='/login';">Book Now</button>
                                @endauth
                            @else
                                <button type="button" class="btn-book" disabled>Not Available</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
// Store viewer instances
const pannellumViewers = {};

function openRoomModal(roomId) {
    console.log('Opening modal for room:', roomId);
    const modal = document.getElementById('roomModal-' + roomId);
    
    if (!modal) {
        console.error('Modal not found:', 'roomModal-' + roomId);
        return;
    }
    
    // Show the modal first
    modal.style.display = 'flex';
    modal.style.visibility = 'visible';
    
    // Force a reflow
    void modal.offsetHeight;
    
    // Add opacity transition
    requestAnimationFrame(() => {
        modal.style.opacity = '1';
        modal.classList.add('active');
        
        // Initialize Pannellum after modal is visible and layout is complete
        setTimeout(() => {
            initializePannellum(roomId);
        }, 100);
    });
    
    document.body.style.overflow = 'hidden';
}

function initializePannellum(roomId) {
    const panoramaDiv = document.getElementById('panorama-' + roomId);
    
    if (!panoramaDiv) {
        console.log('No 360° viewer found for room:', roomId);
        return;
    }
    
    // Destroy existing viewer if present
    if (pannellumViewers[roomId]) {
        try {
            pannellumViewers[roomId].destroy();
            delete pannellumViewers[roomId];
        } catch (error) {
            console.error('Error destroying existing viewer:', error);
        }
    }
    
    // Get the panorama URL from data attribute
    const panoramaUrl = panoramaDiv.getAttribute('data-panorama-url');
    
    if (!panoramaUrl) {
        console.error('No panorama URL found for room:', roomId);
        return;
    }
    
    // Ensure the container has dimensions
    const container = panoramaDiv.closest('.panellum-container');
    if (!container || container.offsetHeight === 0) {
        console.error('Container has no height for room:', roomId);
        return;
    }
    
    try {
        console.log('Initializing Pannellum for room:', roomId, 'with URL:', panoramaUrl);
        
        // Initialize Pannellum viewer
        pannellumViewers[roomId] = pannellum.viewer('panorama-' + roomId, {
            "type": "equirectangular",
            "panorama": panoramaUrl,
            "autoLoad": true,
            "autoRotate": -2,
            "showControls": true,
            "showFullscreenCtrl": true,
            "mouseZoom": true,
            "pitch": 0,
            "yaw": 0,
            "hfov": 110
        });
        
        console.log('Pannellum initialized successfully for room:', roomId);
    } catch (error) {
        console.error('Error initializing Pannellum for room:', roomId, error);
    }
}

function closeRoomModal(roomId) {
    console.log('Closing modal for room:', roomId);
    const modal = document.getElementById('roomModal-' + roomId);
    
    if (!modal) {
        console.error('Modal not found:', 'roomModal-' + roomId);
        return;
    }
    
    modal.classList.remove('active');
    modal.style.opacity = '0';
    
    setTimeout(() => {
        modal.style.display = 'none';
        modal.style.visibility = 'hidden';
        
        // Destroy Pannellum viewer to free resources
        if (pannellumViewers[roomId]) {
            try {
                pannellumViewers[roomId].destroy();
                delete pannellumViewers[roomId];
                console.log('Pannellum destroyed for room:', roomId);
            } catch (error) {
                console.error('Error destroying Pannellum:', error);
            }
        }
    }, 300);
    
    document.body.style.overflow = 'auto';
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const activeModal = document.querySelector('.room-modal.active');
        if (activeModal) {
            const modalId = activeModal.id.replace('roomModal-', '');
            closeRoomModal(modalId);
        }
    }
});
</script>
@endpush
@endonce
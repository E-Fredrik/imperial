@props(['room'])

<div id="roomModal-{{ $room->id }}" class="room-modal" style="display: none; opacity: 0; visibility: hidden;">
    <div class="modal-backdrop" onclick="closeRoomModal({{ $room->id }})"></div>
    <div class="modal-content">
        <!-- Back button moved outside modal-body to stay fixed -->
        <button class="modal-close" onclick="closeRoomModal({{ $room->id }})" style="position: fixed; top: 80px; left: 20px; z-index: 10002;">
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
                                    <img src="{{ $imageUrl }}" alt="Room {{ $room->room_number }}" style="width: 100%; height: 100%; object-fit: contain; background: #000;">
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
                    <form action="{{ route('bookings.create') }}" method="GET" onsubmit="return validateModalBookingForm({{ $room->id }})">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        
                        <div class="date-input-group">
                            <label for="check_in_{{ $room->id }}">Move-in Date</label>
                            <input type="date" 
                                   id="check_in_{{ $room->id }}" 
                                   name="check_in" 
                                   class="form-control" 
                                   style="background:#2a2a2a; border:1px solid #666; color:#FAEBD7; padding:0.8rem; border-radius:8px;"
                                   value="{{ date('Y-m-d') }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            <small style="color: #999; font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                                <i class="bi bi-info-circle"></i> Move-in date cannot be in the past. You have a 5-day grace period from the 1st of each month before late fees apply.
                            </small>
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
        console.log('No panorama div found for room:', roomId);
        return;
    }
    
    const panoramaUrl = panoramaDiv.dataset.panoramaUrl;
    
    if (!panoramaUrl) {
        console.log('No panorama URL for room:', roomId);
        return;
    }
    
    // Clean up existing viewer if it exists
    if (pannellumViewers[roomId]) {
        try {
            pannellumViewers[roomId].destroy();
            delete pannellumViewers[roomId];
        } catch (error) {
            console.error('Error destroying existing Pannellum:', error);
        }
    }
    
    try {
        pannellumViewers[roomId] = pannellum.viewer(panoramaDiv, {
            type: 'equirectangular',
            panorama: panoramaUrl,
            autoLoad: true,
            showControls: true,
            mouseZoom: true,
            draggable: true,
            hotSpotDebug: false,
            compass: false,
            northOffset: 0,
            pitch: 0,
            yaw: 0,
            hfov: 100,
            minHfov: 50,
            maxHfov: 120
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

// Validate move-in date in modal before submitting
function validateModalBookingForm(roomId) {
    const dateInput = document.getElementById('check_in_' + roomId);
    if (!dateInput) return true;
    
    const selectedDate = new Date(dateInput.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (selectedDate < today) {
        alert('Move-in date cannot be in the past. Please select today or a future date.');
        dateInput.focus();
        return false;
    }
    
    return true;
}

// Prevent typing/pasting invalid dates in all modal date inputs
document.addEventListener('DOMContentLoaded', function() {
    // Find all modal date inputs
    const modalDateInputs = document.querySelectorAll('[id^="check_in_"]');
    
    modalDateInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                alert('Move-in date cannot be in the past. Please select today or a future date.');
                this.value = '{{ date("Y-m-d") }}';
            }
        });
    });
});

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
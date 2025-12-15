@extends('layouts.layout')
@section('title', 'Home')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/room.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Your Premium Boarding Experience</h1>
                <p class="hero-description">
                    Discover comfort and convenience with our modern boarding house. Interactive room 
                    selection, instant booking, and premium amenities await you.
                </p>
                <div class="mb-4">
                    <span class="badge-tag mr-2">Premium Rooms</span>
                    <span class="badge-tag mr-2">24/7 Available</span>
                    <span class="badge-tag">High Satisfaction Rate</span>
                </div>
                <div>
                    <a href="{{ route('rooms') }}" class="btn-explore">Explore Rooms →</a>
                    <a href="#" class="btn-learn">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    @php
                        $slides = collect();
                        if (!empty($featured) && $featured->isNotEmpty()) {
                            foreach ($featured as $item) {
                                $path = $item->image_path ?? null;
                                if (! $path) continue;
                                $publicCandidate = public_path($path);
                                if (file_exists($publicCandidate)) {
                                    $slides->push(asset($path));
                                } else {
                                    $slides->push(asset('storage/' . ltrim($path, '/')));
                                }
                            }
                        }
                    @endphp

                    @if($slides->isNotEmpty())
                        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="1500">
                            <div class="carousel-inner">
                                @foreach($slides as $i => $url)
                                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                        <img src="{{ $url }}" class="d-block w-100" alt="Slide {{ $i+1 }}" style="border-radius:0px; height:400px; object-fit:cover;">
                                    </div>
                                @endforeach
                            </div>

                            <div class="carousel-indicators">
                                @foreach($slides as $i => $url)
                                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i+1 }}"></button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-gray-400">No featured image</div>
                    @endif
                </div>
             </div>
         </div>
     </div>
 </section>

<!-- available rooms cards (keeps page black-gradient background) -->
<section class="rooms-section py-6">
     <div class="container">
        <h3 style="color:#FAEBD7; margin-bottom:1rem;">Available Rooms</h3>

        @php
            $roomChunks = ($rooms ?? collect())->chunk(3);
        @endphp

        @if(($rooms ?? collect())->isNotEmpty())
            <div id="roomsCarousel" class="carousel slide pb-4" data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-inner">
                    @foreach($roomChunks as $si => $chunk)
                        <div class="carousel-item {{ $si === 0 ? 'active' : '' }}">
                            <div class="row gy-4">
                                @foreach($chunk as $room)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <x-room-card :room="$room" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="carousel-indicators mt-3">
                    @foreach($roomChunks as $i => $c)
                        <button type="button" data-bs-target="#roomsCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i+1 }}"></button>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-muted" style="color:#cfc6bc;">No rooms available at the moment.</div>
        @endif
     </div>
 </section>

<!-- Room Modal -->
<div id="roomModal" class="room-modal">
    <div class="modal-backdrop" onclick="closeRoomModal()"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeRoomModal()">
            <i class="bi bi-arrow-left"></i> Back
        </button>
        
        <div class="modal-body">
            <div class="modal-images">
                <div id="roomCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner" id="carouselImages"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                
                <div class="room-3d-view">
                    <h4 style="color:#FAEBD7; margin-bottom:1rem;">3D Room View</h4>
                    <div class="view-placeholder">
                        <i class="bi bi-box" style="font-size:3rem; color:#666;"></i>
                        <p style="color:#999; margin-top:1rem;">Interactive 3D view coming soon</p>
                    </div>
                </div>
            </div>
            
            <div class="modal-info">
                <div class="info-header">
                    <div>
                        <h2 id="modalRoomTitle">Room A</h2>
                        <p id="modalRoomType">Single • 3x2.5m • Floor 1</p>
                    </div>
                </div>
                
                <div class="price-section">
                    <div class="price-badge">
                        <span class="monthly-label">Monthly Rate</span>
                        <span class="price" id="modalRoomPrice">Rp 1.850.000</span>
                    </div>
                    <span class="availability-tag" id="modalAvailability">Available</span>
                </div>
                
                <div class="facilities-section">
                    <h3>Facilities</h3>
                    <div class="facilities-grid" id="modalFacilities"></div>
                </div>
                
                <div class="booking-section">
                    <h3>Book This Room</h3>
                    <div class="date-input-group">
                        <label for="checkInDate">Check-in Date</label>
                        <input type="date" id="checkInDate" class="form-control" style="background:#2a2a2a; border:1px solid #666; color:#FAEBD7; padding:0.8rem; border-radius:8px;">
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn-cancel" onclick="closeRoomModal()">Cancel</button>
                        <button class="btn-book" id="bookNowBtn">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- Bootstrap bundle for carousel (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const roomsData = @json($rooms ?? collect());

function openRoomModal(roomId) {
    const room = roomsData.find(r => r.id === roomId);
    if (!room) return;
    
    document.getElementById('modalRoomTitle').textContent = `Room ${room.room_number}`;
    document.getElementById('modalRoomType').textContent = `${room.type} • ${room.length}x${room.width}m • Floor ${room.floor}`;
    document.getElementById('modalRoomPrice').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(room.price)}`;
    
    const availabilityTag = document.getElementById('modalAvailability');
    availabilityTag.textContent = room.status.charAt(0).toUpperCase() + room.status.slice(1);
    availabilityTag.className = `availability-tag ${room.status}`;
    
    const carouselImages = document.getElementById('carouselImages');
    carouselImages.innerHTML = '';
    
    if (room.images && room.images.length > 0) {
        room.images.forEach((image, index) => {
            const div = document.createElement('div');
            div.className = `carousel-item ${index === 0 ? 'active' : ''}`;
            div.innerHTML = `<img src="/storage/${image.image_path}" alt="Room ${room.room_number}">`;
            carouselImages.appendChild(div);
        });
    } else {
        carouselImages.innerHTML = '<div class="carousel-item active"><div class="no-image-modal">No Image Available</div></div>';
    }
    
    const facilitiesGrid = document.getElementById('modalFacilities');
    facilitiesGrid.innerHTML = '';
    
    const defaultFacilities = [
        { icon: 'wifi', name: 'WiFi' },
        { icon: 'droplet', name: 'Bathroom' },
        { icon: 'broom', name: 'Cleaning Service' },
        { icon: 'thermometer-half', name: 'Water Heater' },
        { icon: 'utensils', name: 'Premium Dinner' }
    ];
    
    defaultFacilities.forEach(facility => {
        const div = document.createElement('div');
        div.className = 'facility-item';
        div.innerHTML = `<i class="bi bi-${facility.icon}"></i><span>${facility.name}</span>`;
        facilitiesGrid.appendChild(div);
    });
    
    const bookBtn = document.getElementById('bookNowBtn');
    if (room.status === 'available') {
        bookBtn.disabled = false;
        bookBtn.textContent = 'Book Now';
        bookBtn.onclick = () => bookRoom(roomId);
    } else {
        bookBtn.disabled = true;
        bookBtn.textContent = 'Not Available';
    }
    
    const modal = document.getElementById('roomModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeRoomModal() {
    const modal = document.getElementById('roomModal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

function bookRoom(roomId) {
    const checkInDate = document.getElementById('checkInDate').value;
    if (!checkInDate) {
        alert('Please select a check-in date');
        return;
    }
    
    @auth
        window.location.href = `/bookings/create?room_id=${roomId}&check_in=${checkInDate}`;
    @else
        alert('Please login to book a room');
        window.location.href = '/login';
    @endauth
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeRoomModal();
});
</script>
@endpush


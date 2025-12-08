@extends('layouts.layout')
@section('title', 'Rooms')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/room.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@section('content')
<section class="rooms-section">
    <div class="container-fluid" style="max-width: 1600px;">
        <h1 class="page-title text-center">Building Floor Plan</h1>
        <p class="page-subtitle text-center">Interactive building layout - Click any room for details</p>
        
        <div class="legend" style="display: flex; gap: 2rem; margin-bottom: 3rem; justify-content: center;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #00ff00; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #FAEBD7; font-weight: 600;">Available</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #ff0000; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #FAEBD7; font-weight: 600;">Occupied</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #666; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #FAEBD7; font-weight: 600;">Unavailable</span>
            </div>
        </div>
        
        @php
            $roomsByFloor = $rooms->groupBy('floor')->sortKeysDesc();
        @endphp
        
        @foreach($roomsByFloor as $floor => $floorRooms)
            <div class="floor-plan-container" style="margin-bottom: 4rem;">
                <div class="floor-title" style="text-align: center; margin-bottom: 2rem;">
                    <h2 style="color: #FAEBD7; font-size: 2.5rem; font-weight: 700;">
                        <i class="bi bi-building"></i> {{ $floor }}F
                    </h2>
                </div>
                
                <div class="floor-map" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 4px solid #fff; border-radius: 20px; padding: 3rem; position: relative; min-height: 600px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);">
                    
                    @if($floor == 1)
                        <div style="position: absolute; top: 20px; left: 20px; background: #c0c0c0; padding: 1rem 1.5rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center; font-size: 0.9rem;">TANGGA NAIK</div>
                        </div>
                        
                        <div style="position: absolute; top: 20px; left: 50%; transform: translateX(-50%); background: #333; padding: 0.8rem 1.2rem; border-radius: 8px; border: 2px solid #fff;">
                            <div style="color: #fff; font-weight: 600; font-size: 0.8rem;">DAPUR</div>
                        </div>
                        
                        <div style="position: absolute; top: 20px; right: 20px; background: #333; padding: 0.8rem 1.2rem; border-radius: 8px; border: 2px solid #fff;">
                            <div style="color: #fff; font-weight: 600; font-size: 0.8rem; writing-mode: vertical-rl; text-orientation: mixed;">MESIN CUCI</div>
                        </div>
                        
                        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); background: #c0c0c0; padding: 0.8rem 2rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center;">PINTU MASUK</div>
                        </div>
                        
                        <div style="position: absolute; left: 60px; top: 140px; display: flex; flex-direction: column; gap: 20px;">
                            @foreach($floorRooms->whereIn('room_number', ['A', 'B', 'C'])->sortBy('room_number') as $room)
                                @php
                                    $bgColor = $room->status === 'available' ? '#00ff00' : ($room->status === 'booked' ? '#ff0000' : '#666');
                                @endphp
                                <div class="room-plan-box" data-room-id="{{ $room->id }}" onclick="openRoomModal({{ $room->id }})" style="width: 140px; height: 110px; background: {{ $bgColor }}; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">{{ $room->room_number }}</div>
                                        @if($room->status === 'booked')
                                            <div style="font-size: 0.65rem; color: #fff; font-weight: 700; background: rgba(0,0,0,0.7); padding: 2px 8px; border-radius: 4px; margin-top: 4px;">OCCUPIED</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="position: absolute; right: 60px; top: 140px; display: flex; flex-direction: column; gap: 20px;">
                            @foreach($floorRooms->whereIn('room_number', ['D', 'E', 'F', 'G'])->sortBy('room_number') as $room)
                                @php
                                    $bgColor = $room->status === 'available' ? '#00ff00' : ($room->status === 'booked' ? '#ff0000' : '#666');
                                @endphp
                                <div class="room-plan-box" data-room-id="{{ $room->id }}" onclick="openRoomModal({{ $room->id }})" style="width: 140px; height: 110px; background: {{ $bgColor }}; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">{{ $room->room_number }}</div>
                                        @if($room->status === 'booked')
                                            <div style="font-size: 0.65rem; color: #fff; font-weight: 700; background: rgba(0,0,0,0.7); padding: 2px 8px; border-radius: 4px; margin-top: 4px;">OCCUPIED</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    @elseif($floor == 2)
                        <div style="position: absolute; top: 20px; right: 20px; background: #333; padding: 1rem 1.5rem; border-radius: 8px; border: 2px solid #fff;">
                            <div style="color: #fff; font-weight: 600; font-size: 0.8rem; writing-mode: vertical-rl; text-orientation: mixed;">DISFENGER</div>
                        </div>
                        
                        <div style="position: absolute; bottom: 60px; left: 50%; transform: translateX(-50%); background: #c0c0c0; padding: 0.8rem 2rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center;">JEMURAN</div>
                        </div>
                        
                        <div style="position: absolute; top: 20px; left: 20px; background: #c0c0c0; padding: 1rem 1.5rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center; font-size: 0.9rem;">TANGGA</div>
                        </div>
                        
                        <div style="position: absolute; right: 60px; top: 140px; display: flex; flex-direction: column; gap: 30px;">
                            @foreach($floorRooms->sortBy('room_number') as $room)
                                @php
                                    $bgColor = $room->status === 'available' ? '#00ff00' : ($room->status === 'booked' ? '#ff0000' : '#666');
                                @endphp
                                <div class="room-plan-box" data-room-id="{{ $room->id }}" onclick="openRoomModal({{ $room->id }})" style="width: 140px; height: 110px; background: {{ $bgColor }}; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.3);">{{ $room->room_number }}</div>
                                        @if($room->status === 'booked')
                                            <div style="font-size: 0.65rem; color: #fff; font-weight: 700; background: rgba(0,0,0,0.7); padding: 2px 8px; border-radius: 4px; margin-top: 4px;">OCCUPIED</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 8rem; font-weight: 900; color: rgba(250, 235, 215, 0.08); pointer-events: none; z-index: 0;">{{ $floor }}F</div>
                </div>
            </div>
        @endforeach
        
        <div style="margin-top: 3rem; text-align: center; padding-bottom: 3rem;">
            <p style="color: #999; font-size: 1rem;">
                <i class="bi bi-info-circle"></i> Click on any room to view detailed information and book
            </p>
        </div>
    </div>
</section>

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
<script>
const roomsData = @json($rooms);

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
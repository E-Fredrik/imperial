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
        <p class="page-subtitle text-center">Interactive building layout - Click any room for details and booking</p>
        
        <div class="legend">
            <div class="legend-item">
                <div class="legend-color available"></div>
                <span>Available</span>
            </div>
            <div class="legend-item">
                <div class="legend-color booked"></div>
                <span>Booked</span>
            </div>
            <div class="legend-item">
                <div class="legend-color unavailable"></div>
                <span>Unavailable</span>
            </div>
        </div>

        @php
            $floor1Rooms = $rooms->where('floor', 1);
            $floor2Rooms = $rooms->where('floor', 2);
        @endphp

        {{-- FLOOR 1 --}}
        <div class="floor-plan-container">
            <div class="floor-title">
                <h2><i class="bi bi-building"></i> First Floor (1F)</h2>
            </div>
            
            <div class="floor-map-wrapper">
                <svg viewBox="0 0 1000 850" class="floor-svg">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="780" height="830" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    {{-- LEFT COLUMN - TOP TO BOTTOM --}}
                    <!-- Top left bathroom -->
                    <rect x="10" y="10" width="110" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="95" cy="55" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room A (left top) -->
                    @foreach($floor1Rooms->where('room_number', 'A') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="10" y="150" width="110" height="140" class="room-fill"/>
                        <rect x="10" y="150" width="110" height="140" class="room-outline"/>
                        <text x="65" y="225" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    <!-- Kitchen below A -->
                    <rect x="10" y="300" width="110" height="135" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="35" y="340" width="60" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="95" cy="360" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom below kitchen -->
                    <rect x="10" y="445" width="50" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="35" cy="492" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room C (left bottom large) -->
                    @foreach($floor1Rooms->where('room_number', 'C') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="10" y="550" width="110" height="240" class="room-fill"/>
                        <rect x="10" y="550" width="110" height="240" class="room-outline"/>
                        <text x="65" y="675" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    <!-- Bottom left bathroom -->
                    <rect x="10" y="800" width="110" height="40" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="95" cy="820" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    {{-- CENTER COLUMN - STAIRS & CORRIDOR --}}
                    <!-- Stairs at top -->
                    <g class="stair-block">
                        <rect x="130" y="10" width="130" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                        <line x1="130" y1="30" x2="260" y2="30" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="45" x2="260" y2="45" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="60" x2="260" y2="60" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="75" x2="260" y2="75" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="90" x2="260" y2="90" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="105" x2="260" y2="105" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="120" x2="260" y2="120" stroke="#fff" stroke-width="2"/>
                        <!-- Diagonal arrows -->
                        <line x1="220" y1="120" x2="250" y2="130" stroke="#fff" stroke-width="4"/>
                        <line x1="180" y1="120" x2="210" y2="130" stroke="#fff" stroke-width="4"/>
                    </g>
                    
                    <!-- Central corridor/hall -->
                    <rect x="130" y="150" width="130" height="690" fill="#000"/>
                    
                    <!-- Seating area furniture in corridor -->
                    <rect x="155" y="300" width="35" height="55" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="172.5" cy="380" rx="25" ry="35" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="172.5" cy="480" rx="25" ry="35" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room B (extends next to corridor) -->
                    @foreach($floor1Rooms->where('room_number', 'B') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="130" y="150" width="130" height="140" class="room-fill"/>
                        <rect x="130" y="150" width="130" height="140" class="room-outline"/>
                        <text x="195" y="225" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    <!-- Bathroom mid-corridor -->
                    <rect x="130" y="550" width="130" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="155" y="570" width="80" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Kitchen mid-corridor -->
                    <rect x="130" y="650" width="130" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="155" y="670" width="80" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom bottom corridor -->
                    <rect x="130" y="750" width="130" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="225" cy="795" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    {{-- RIGHT COLUMN - ROOMS D, E, F, G --}}
                    <!-- Small bathroom top right -->
                    <rect x="270" y="10" width="180" height="65" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="440" cy="42" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room D (top right) -->
                    @foreach($floor1Rooms->where('room_number', 'D') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="270" y="85" width="85" height="110" class="room-fill"/>
                        <rect x="270" y="85" width="85" height="110" class="room-outline"/>
                        <text x="312" y="145" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    <!-- Room E (right of D) -->
                    @foreach($floor1Rooms->where('room_number', 'E') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="365" y="85" width="85" height="110" class="room-fill"/>
                        <rect x="365" y="85" width="85" height="110" class="room-outline"/>
                        <text x="407" y="145" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    <!-- Small bathroom between rooms -->
                    <rect x="460" y="10" width="85" height="185" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="502" cy="102" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room F (right middle) -->
                    @foreach($floor1Rooms->where('room_number', 'F') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="270" y="205" width="180" height="95" class="room-fill"/>
                        <rect x="270" y="205" width="180" height="95" class="room-outline"/>
                        <text x="360" y="257" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    <!-- Small bathroom -->
                    <rect x="460" y="205" width="85" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="532" cy="252" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room G (right large section) -->
                    @foreach($floor1Rooms->where('room_number', 'G') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="270" y="310" width="275" height="190" class="room-fill"/>
                        <rect x="270" y="310" width="275" height="190" class="room-outline"/>
                        <text x="407" y="410" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    {{-- FAR RIGHT COLUMN - BATHROOMS & ROOMS --}}
                    <!-- Top bathroom -->
                    <rect x="555" y="10" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="57" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Small bedroom -->
                    <rect x="555" y="115" width="90" height="85" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    <!-- Bathroom -->
                    <rect x="555" y="210" width="90" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="255" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Another bedroom -->
                    <rect x="555" y="310" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    <!-- Bathroom -->
                    <rect x="555" y="415" width="90" height="85" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="457" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    {{-- BOTTOM RIGHT LARGE AREA --}}
                    <!-- Large empty area / dining -->
                    <rect x="270" y="510" width="275" height="180" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="295" y="570" width="60" height="80" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="400" cy="610" rx="50" ry="30" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathrooms bottom right -->
                    <rect x="555" y="510" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="557" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <rect x="555" y="615" width="90" height="75" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="652" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Kitchen/dining bottom -->
                    <rect x="270" y="700" width="185" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="295" y="730" width="60" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="365" y="730" width="70" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom bottom right corner -->
                    <rect x="465" y="700" width="180" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="770" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    {{-- RIGHTMOST COLUMN --}}
                    <rect x="655" y="10" width="135" height="830" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                </svg>
            </div>
        </div>

        {{-- FLOOR 2 --}}
        <div class="floor-plan-container">
            <div class="floor-title">
                <h2><i class="bi bi-building"></i> Second Floor (2F)</h2>
            </div>
            
            <div class="floor-map-wrapper">
                <svg viewBox="0 0 1000 290" class="floor-svg">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="980" height="270" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    {{-- LEFT SIDE - Large empty area --}}
                    <rect x="10" y="10" width="230" height="270" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    {{-- STAIRS SECTION --}}
                    <g class="stair-block-2f">
                        <rect x="250" y="10" width="90" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                        <line x1="250" y1="25" x2="340" y2="25" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="38" x2="340" y2="38" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="51" x2="340" y2="51" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="64" x2="340" y2="64" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="77" x2="340" y2="77" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="90" x2="340" y2="90" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="103" x2="340" y2="103" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="116" x2="340" y2="116" stroke="#fff" stroke-width="2"/>
                        <!-- Diagonal arrows -->
                        <line x1="310" y1="115" x2="330" y2="125" stroke="#fff" stroke-width="4"/>
                        <line x1="280" y1="115" x2="300" y2="125" stroke="#fff" stroke-width="4"/>
                    </g>
                    
                    {{-- CENTRAL CORRIDOR --}}
                    <rect x="250" y="140" width="290" height="140" fill="#000"/>
                    
                    {{-- RIGHT SIDE ROOMS - TOP ROW --}}
                    <!-- Bathroom top right -->
                    <rect x="550" y="10" width="90" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="618" cy="70" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room H (top right 1) -->
                    @foreach($floor2Rooms->where('room_number', 'H') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="650" y="10" width="90" height="120" class="room-fill"/>
                        <rect x="650" y="10" width="90" height="120" class="room-outline"/>
                        <text x="695" y="75" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    <!-- Bathroom -->
                    <rect x="750" y="10" width="85" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="818" cy="70" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room I (top right 2) -->
                    @foreach($floor2Rooms->where('room_number', 'I') as $room)
                    <g class="room-group clickable-room {{ $room->status }}" onclick="openRoomModal({{ $room->id }})">
                        <rect x="845" y="10" width="145" height="120" class="room-fill"/>
                        <rect x="845" y="10" width="145" height="120" class="room-outline"/>
                        <text x="917" y="75" class="room-label">{{ $room->room_number }}</text>
                    </g>
                    @endforeach
                    
                    {{-- RIGHT SIDE ROOMS - BOTTOM ROW --}}
                    <!-- Dining/seating area -->
                    <rect x="550" y="140" width="90" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <ellipse cx="595" cy="195" rx="25" ry="35" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="565" cy="245" width="50" height="25" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Large room bottom right -->
                    <rect x="650" y="140" width="185" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="675" y="170" width="60" height="35" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="765" cy="230" rx="35" ry="25" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom bottom -->
                    <rect x="845" y="140" width="70" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="903" cy="210" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room/storage bottom right -->
                    <rect x="925" y="140" width="65" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                </svg>
            </div>
        </div>

        <div class="floor-info-text">
            <p><i class="bi bi-info-circle"></i> Click on any room to view details and book</p>
        </div>
    </div>
</section>

{{-- Room Modal --}}
@foreach($rooms as $room)
<div id="room-modal-{{ $room->id }}" class="room-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeRoomModal({{ $room->id }})">
            <i class="bi bi-x-lg"></i> Close
        </button>
        
        <div class="modal-layout">
            {{-- Left Side: Images and 3D View --}}
            <div class="modal-visual">
                {{-- Image Gallery --}}
                <div class="room-gallery">
                    @if($room->images->count() > 0)
                        <div class="gallery-main">
                            <img src="{{ asset($room->images->first()->image_path) }}" alt="Room {{ $room->room_number }}" class="main-image">
                        </div>
                        @if($room->images->count() > 1)
                            <div class="gallery-thumbnails">
                                @foreach($room->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="Room {{ $room->room_number }}" class="thumbnail">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="no-images">
                            <i class="bi bi-image"></i>
                            <p>No images available</p>
                        </div>
                    @endif
                </div>
                
                {{-- 3D View Placeholder --}}
                <div class="room-3d-view">
                    <div class="view-placeholder">
                        <i class="bi bi-box"></i>
                        <p>3D View Coming Soon</p>
                    </div>
                </div>
            </div>
            
            {{-- Right Side: Information --}}
            <div class="modal-info">
                <div class="info-header">
                    <h2>Room {{ $room->room_number }}</h2>
                    <p>{{ $room->type }} • Floor {{ $room->floor }}</p>
                </div>
                
                <div class="info-details">
                    <div class="detail-row">
                        <i class="bi bi-rulers"></i>
                        <span>{{ $room->length }}m × {{ $room->width }}m</span>
                    </div>
                    
                    <div class="detail-row">
                        <i class="bi bi-cash-coin"></i>
                        <span class="price">Rp {{ number_format($room->price, 0, ',', '.') }}/month</span>
                    </div>
                    
                    <div class="detail-row">
                        <i class="bi bi-info-circle"></i>
                        <span class="status-badge status-{{ $room->status }}">{{ ucfirst($room->status) }}</span>
                    </div>
                </div>
                
                <div class="description-section">
                    <h3>Description</h3>
                    <p>{{ $room->description ?: 'This is a comfortable ' . $room->type . ' room located on floor ' . $room->floor . '.' }}</p>
                </div>
                
                <div class="facilities-section">
                    <h3>Facilities</h3>
                    <div class="facilities-list">
                        @forelse($room->rooms_facilities as $rf)
                            <div class="facility-item">
                                @if($rf->room_facility && $rf->room_facility->images->count() > 0)
                                    <img src="{{ asset($rf->room_facility->images->first()->image_path) }}" alt="{{ $rf->room_facility->name }}">
                                @else
                                    <i class="bi bi-check-circle-fill"></i>
                                @endif
                                <span>{{ optional($rf->room_facility)->name ?? 'N/A' }}</span>
                            </div>
                        @empty
                            <p>No facilities listed</p>
                        @endforelse
                    </div>
                </div>
                
                <div class="booking-section">
                    <h3>Book This Room</h3>
                    @auth
                        @if($room->status === 'available')
                            <form action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                
                                <div class="date-input-group">
                                    <label for="move_in_date_{{ $room->id }}">Move-in Date</label>
                                    <input type="date" id="move_in_date_{{ $room->id }}" name="move_in_date" min="{{ date('Y-m-d') }}" required>
                                </div>
                                
                                <div class="action-buttons">
                                    <button type="submit" class="btn-book">
                                        <i class="bi bi-calendar-check"></i> Book Now
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="unavailable-notice">
                                <i class="bi bi-exclamation-circle"></i>
                                <p>This room is currently {{ $room->status }}</p>
                            </div>
                        @endif
                    @else
                        <div class="login-notice">
                            <i class="bi bi-info-circle"></i>
                            <p>Please <a href="{{ route('login') }}">login</a> to book this room</p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script src="{{ asset('js/roomModal.js') }}"></script>
@endpush
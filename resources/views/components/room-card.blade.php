@props(['room'])

@php
    $imgPath = optional($room->images->first())->image_path ?? null;
    if ($imgPath) {
        $publicCandidate = public_path($imgPath);
        $imgUrl = file_exists($publicCandidate) ? asset($imgPath) : asset('storage/' . ltrim($imgPath, '/'));
    } else {
        $imgUrl = asset('images/rooms/default.jpg');
    }
    
    // Use gray/white border for all rooms
    $borderColor = '#d1d5db';
@endphp

<div class="room-card" data-room-id="{{ $room->id }}" onclick="openRoomModal({{ $room->id }})" style="background:#FAEBD7; color:#000; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.25); cursor:pointer; transition: all 0.3s ease; border: 3px solid {{ $borderColor }}; position: relative;">
    
    <div style="height:200px; overflow:hidden; position: relative;">
        <img src="{{ $imgUrl }}" alt="Room {{ $room->room_number }}" style="width:100%; height:100%; object-fit:cover; display:block; transition: transform 0.3s ease;">
        
        @if($room->status === 'booked')
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(239, 68, 68, 0.95); color: white; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 700; font-size: 1.2rem; z-index: 2;">
                OCCUPIED
            </div>
        @elseif($room->status === 'unavailable')
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(100, 116, 139, 0.95); color: white; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 700; font-size: 1.2rem; z-index: 2;">
                UNAVAILABLE
            </div>
        @endif
    </div>

    <div style="padding:1.2rem; position: relative; z-index: 1;">
        <h5 style="margin:0 0 .5rem 0; font-weight:700; font-size:1.3rem;">Room {{ $room->room_number }}</h5>
        <div style="font-size:.95rem; margin-bottom:.4rem; color:#666;">{{ $room->type }} • {{ $room->length }}x{{ $room->width }}m • Floor {{ $room->floor }}</div>
        <div style="font-size:1.1rem; margin-bottom:.8rem; font-weight:600;">Rp {{ number_format($room->price, 0, ',', '.') }}/month</div>

        <div style="display:flex; gap:.5rem; align-items:center;">
            @if($room->status === 'available')
                <span style="font-size:.9rem; color:#0a7a00; font-weight:600; background:#d4edda; padding:4px 12px; border-radius:12px;">Available</span>
            @elseif($room->status === 'booked')
                <span style="font-size:.9rem; color:#7a0000; font-weight:600; background:#f8d7da; padding:4px 12px; border-radius:12px;">Occupied</span>
            @else
                <span style="font-size:.9rem; color:#475569; font-weight:600; background:#e2e8f0; padding:4px 12px; border-radius:12px;">{{ ucfirst($room->status) }}</span>
            @endif
        </div>
    </div>
</div>

<style>
.room-card:hover {
    transform: translateY(-8px) scale(1.03);
    background-color: #2a2a2a !important;
    color: #FAEBD7 !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
}

.room-card:hover img {
    transform: scale(1.1);
}

.room-card:hover h5,
.room-card:hover div {
    color: #FAEBD7 !important;
}
</style>
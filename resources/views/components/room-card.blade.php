@props(['room'])

@php
    $imgPath = optional($room->images->first())->image_path ?? null;
    if ($imgPath) {
        $publicCandidate = public_path($imgPath);
        $imgUrl = file_exists($publicCandidate) ? asset($imgPath) : asset('storage/' . ltrim($imgPath, '/'));
    } else {
        $imgUrl = asset('images/rooms/default.jpg');
    }
@endphp

<div class="room-card" style="background:#FAEBD7; color:#000; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.25);">
    <div style="height:160px; overflow:hidden;">
        <img src="{{ $imgUrl }}" alt="Room {{ $room->room_number }}" style="width:100%; height:100%; object-fit:cover; display:block;">
    </div>

    <div style="padding:0.9rem;">
        <h5 style="margin:0 0 .35rem 0; font-weight:700;">Room {{ $room->room_number }}</h5>
        <div style="font-size:.9rem; margin-bottom:.4rem;">Type: <strong>{{ $room->type }}</strong></div>
        <div style="font-size:.9rem; margin-bottom:.6rem;">Price: <strong>{{ number_format($room->price) }}</strong></div>

        <div style="display:flex; gap:.5rem; align-items:center;">
            <a href="{{ url('/rooms/'.$room->id) }}" class="btn btn-sm" style="background:#000; color:#FAEBD7; border-radius:8px; padding:.35rem .7rem; text-transform:none;">View</a>
            @if($room->status === 'available')
                <span style="margin-left:auto; font-size:.85rem; color:#0a7a00; font-weight:600;">Available</span>
            @else
                <span style="margin-left:auto; font-size:.85rem; color:#7a0000; font-weight:600;">{{ ucfirst($room->status) }}</span>
            @endif
        </div>
    </div>
</div>
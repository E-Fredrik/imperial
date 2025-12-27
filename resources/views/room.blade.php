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
                <span style="color: #999;">Available</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #ff0000; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #999;">Booked</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #808080; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #999;">Unavailable</span>
            </div>
        </div>

        @php
            $roomsByFloor = $rooms->groupBy('floor')->sortKeys();
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
                        {{-- Floor 1 Layout --}}
                        <div style="position: absolute; top: 20px; left: 20px; background: #c0c0c0; padding: 1rem 1.5rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center; font-size: 0.9rem;">TANGGA</div>
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
                                    $bgColor = match($room->status) {
                                        'available' => '#00ff00',
                                        'booked' => '#ff0000',
                                        default => '#808080'
                                    };
                                @endphp
                                <div class="room-plan-box" data-room-id="{{ $room->id }}" onclick="openRoomModal({{ $room->id }})" style="width: 140px; height: 110px; background: {{ $bgColor }}; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.5);">{{ $room->room_number }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="position: absolute; right: 60px; top: 140px; display: flex; flex-direction: column; gap: 30px;">
                            @foreach($floorRooms->whereNotIn('room_number', ['A', 'B', 'C'])->sortBy('room_number') as $room)
                                @php
                                    $bgColor = match($room->status) {
                                        'available' => '#00ff00',
                                        'booked' => '#ff0000',
                                        default => '#808080'
                                    };
                                @endphp
                                <div class="room-plan-box" data-room-id="{{ $room->id }}" onclick="openRoomModal({{ $room->id }})" style="width: 140px; height: 110px; background: {{ $bgColor }}; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.5);">{{ $room->room_number }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Floor 2 Layout --}}
                        <div style="position: absolute; top: 20px; left: 20px; background: #c0c0c0; padding: 1rem 1.5rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center; font-size: 0.9rem;">TANGGA</div>
                        </div>
                        
                        <div style="position: absolute; right: 60px; top: 140px; display: flex; flex-direction: column; gap: 30px;">
                            @foreach($floorRooms->sortBy('room_number') as $room)
                                @php
                                    $bgColor = match($room->status) {
                                        'available' => '#00ff00',
                                        'booked' => '#ff0000',
                                        default => '#808080'
                                    };
                                @endphp
                                <div class="room-plan-box" data-room-id="{{ $room->id }}" onclick="openRoomModal({{ $room->id }})" style="width: 140px; height: 110px; background: {{ $bgColor }}; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.5);">{{ $room->room_number }}</div>
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

{{-- Render modal for each room --}}
@foreach($rooms as $room)
    <x-room-modal :room="$room" />
@endforeach
@endsection
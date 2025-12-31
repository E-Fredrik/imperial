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
                <svg viewBox="0 0 800 900" class="floor-svg" style="background: #000;">
                  
                </svg>
            </div>
        </div>

        {{-- FLOOR 2 --}}
        <div class="floor-plan-container">
            <div class="floor-title">
                <h2><i class="bi bi-building"></i> Second Floor (2F)</h2>
            </div>
            
            <div class="floor-map-wrapper">
                <svg viewBox="0 0 1000 300" class="floor-svg" style="background: #000;">
                    
                </svg>
            </div>
        </div>

        <div class="floor-info-text">
            <p><i class="bi bi-info-circle"></i> Click on any available room to view details and book</p>
        </div>
    </div>
</section>

{{-- Room Modal --}}
@foreach($rooms as $room)
    @include('components.room-modal', ['room' => $room])
@endforeach
@endsection

@push('scripts')
<script src="{{ asset('js/roomModal.js') }}"></script>
@endpush
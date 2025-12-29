@extends('layouts.layout')
@section('title', 'Home')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/room.css') }}">
@endpush
@section('content')
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-5 mb-lg-0">
                <h1 class="hero-title">Your Premium Boarding Experience</h1>
                <p class="hero-description">
                    Discover comfort and convenience with our modern boarding house. Interactive room 
                    selection, instant booking, and premium amenities await you.
                </p>
                <div class="mb-4">
                    <span class="badge-tag"><i class="bi bi-star-fill me-1"></i>Premium Rooms</span>
                    <span class="badge-tag"><i class="bi bi-clock-fill me-1"></i>24/7 Available</span>
                    <span class="badge-tag"><i class="bi bi-heart-fill me-1"></i>High Satisfaction</span>
                </div>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('rooms') }}" class="btn-explore btn-primary btn-lg">
                        <i class="bi bi-compass me-2"></i>Explore Rooms
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="btn-learn">
                            <i class="bi bi-calendar-check me-2"></i>Book Now
                        </a>
                    @else
                        <a href="{{ route('bookings.create') }}" class="btn-learn">
                            <i class="bi bi-calendar-check me-2"></i>Book Now
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
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
                        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                            <div class="carousel-inner">
                                @foreach($slides as $i => $url)
                                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                        <img src="{{ $url }}" class="d-block w-100" alt="Slide {{ $i+1 }}" style="border-radius:20px; height:100%; width:100%; object-fit:cover;">
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
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(250, 235, 215, 0.05); border-radius: 20px; height: 450px; border: 2px dashed rgba(250, 235, 215, 0.2);">
                            <div style="text-align: center;">
                                <i class="bi bi-image" style="font-size: 4rem; color: rgba(250, 235, 215, 0.3);"></i>
                                <p style="color: #666; margin-top: 1rem;">No featured image</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="rooms-section-home">
    <div class="container">
        <h2 class="section-title text-center">Available Rooms</h2>
        <p class="section-subtitle text-center">Browse through our carefully curated selection of premium boarding rooms</p>

        @php
            $roomChunks = ($rooms ?? collect())->chunk(3);
        @endphp

        @if(($rooms ?? collect())->isNotEmpty())
            {{-- Desktop carousel: 3 cards per slide --}}
            <div id="roomsCarouselDesktop" class="carousel slide d-none d-lg-block" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @foreach($roomChunks as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div>
                                @foreach($chunk as $room)
                                    <x-room-card :room="$room" />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($roomChunks->count() > 1)
                    <div class="carousel-indicators">
                        @foreach($roomChunks as $index => $chunk)
                            <button type="button" data-bs-target="#roomsCarouselDesktop" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Mobile carousel: 1 card per slide --}}
            <div id="roomsCarouselMobile" class="carousel slide d-lg-none" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @foreach($rooms as $index => $room)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="d-flex justify-content-center">
                                <x-room-card :room="$room" />
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($rooms->count() > 1)
                    <div class="carousel-indicators">
                        @foreach($rooms as $index => $room)
                            <button type="button" data-bs-target="#roomsCarouselMobile" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="rooms-empty-state">
                <i class="bi bi-inbox"></i>
                <p>No rooms available at the moment</p>
            </div>
        @endif
    </div>
</section>

{{-- Render modals directly in the page --}}
@if(($rooms ?? collect())->isNotEmpty())
    @foreach($rooms as $room)
        @include('components.room-modal', ['room' => $room])
    @endforeach
@endif

@endsection

@push('scripts')
<script src="{{ asset('js/roomModal.js') }}"></script>
@endpush


@extends('layouts.layout')
@section('title', 'Home')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
                    <span class="badge-tag">Premium Rooms</span>
                    <span class="badge-tag">24/7 Available</span>
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
                                        <img src="{{ $url }}" class="d-block w-100" alt="Slide {{ $i+1 }}" style="border-radius:5px; height:400px; object-fit:cover;">
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

<!-- available rooms cards (keeps page black background) -->
<section class="py-6" style="background:black;">
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
@endsection
@push('scripts')
<!-- Bootstrap bundle for carousel (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush


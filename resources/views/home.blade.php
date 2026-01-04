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
                    <h1 class="hero-title">
                        {!! optional($information->firstWhere('title', 'Title'))->content ??
                            (optional($information->first())->content ?? 'Imperial Kost') !!}
                    </h1>
                    <p class="hero-description">
                        {!! optional($information->firstWhere('title', 'Description'))->content ??
                            (optional($information->first())->content ??
                                'Discover comfort and convenience with our modern boarding house. Interactive room selection, instant booking, and premium amenities await you.') !!}
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
                                    if (!$path) {
                                        continue;
                                    }
                                    $publicCandidate = public_path($path);
                                    if (file_exists($publicCandidate)) {
                                        $slides->push(asset($path));
                                    } else {
                                        $slides->push(asset('storage/' . ltrim($path, '/')));
                                    }
                                }
                            }
                        @endphp

                        @if ($slides->isNotEmpty())
                            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel"
                                data-bs-interval="3000">
                                <div class="carousel-inner">
                                    @foreach ($slides as $i => $url)
                                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                            <img src="{{ $url }}" class="d-block w-100"
                                                alt="Slide {{ $i + 1 }}"
                                                style="border-radius:20px; height:100%; width:100%; object-fit:cover;">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="carousel-indicators">
                                    @foreach ($slides as $i => $url)
                                        <button type="button" data-bs-target="#heroCarousel"
                                            data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"
                                            aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $i + 1 }}"></button>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                style="background: rgba(250, 235, 215, 0.05); border-radius: 20px; height: 450px; border: 2px dashed rgba(250, 235, 215, 0.2);">
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
            <p class="section-subtitle text-center">Browse through our carefully curated selection of premium boarding rooms
            </p>

            @php
                $roomChunks = ($rooms ?? collect())->chunk(3);
            @endphp

            @if (($rooms ?? collect())->isNotEmpty())
                {{-- Desktop carousel: 3 cards per slide --}}
                <div id="roomsCarouselDesktop" class="carousel slide d-none d-lg-block" data-bs-ride="carousel"
                    data-bs-interval="5000">
                    <div class="carousel-inner">
                        @foreach ($roomChunks as $index => $chunk)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div>
                                    @foreach ($chunk as $room)
                                        <x-room-card :room="$room" />
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($roomChunks->count() > 1)
                        <div class="carousel-indicators">
                            @foreach ($roomChunks as $index => $chunk)
                                <button type="button" data-bs-target="#roomsCarouselDesktop"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Mobile carousel: 1 card per slide --}}
                <div id="roomsCarouselMobile" class="carousel slide d-lg-none" data-bs-ride="carousel"
                    data-bs-interval="5000">
                    <div class="carousel-inner">
                        @foreach ($rooms as $index => $room)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="d-flex justify-content-center">
                                    <x-room-card :room="$room" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($rooms->count() > 1)
                        <div class="carousel-indicators">
                            @foreach ($rooms as $index => $room)
                                <button type="button" data-bs-target="#roomsCarouselMobile"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
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

    {{-- Kost Facilities Section --}}
    <section class="facilities-section">
        <div class="container">
            <h2 class="section-title text-center">Kost Facilities</h2>
            <p class="section-subtitle text-center">Enjoy our premium amenities designed for your comfort</p>

            @if ($kostFacilities->isNotEmpty())
                @php
                    $kostChunks = $kostFacilities->chunk(3);
                @endphp

                <div id="kostFacilitiesCarouselDesktop" class="carousel slide d-none d-lg-block" data-bs-ride="carousel"
                    data-bs-interval="5000">
                    <div class="carousel-inner">
                        @foreach ($kostChunks as $index => $chunk)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row g-4">
                                    @foreach ($chunk as $facility)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="facility-card"
                                                style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px; overflow: hidden; transition: all 0.3s; height: 100%;">
                                                @php
                                                    $firstImage = $facility->facilities_images->first();
                                                    if ($firstImage && $firstImage->image) {
                                                        $path = $firstImage->image->image_path ?? '';
                                                        $publicCandidate = public_path($path);
                                                        if ($path !== '' && file_exists($publicCandidate)) {
                                                            $imgUrl = asset($path);
                                                        } else {
                                                            $imgUrl = asset('storage/' . ltrim($path, '/'));
                                                        }
                                                    } else {
                                                        $imgUrl = null;
                                                    }
                                                @endphp

                                                @if ($imgUrl)
                                                    <div style="height: 200px; overflow: hidden;">
                                                        <img src="{{ $imgUrl }}" alt="{{ $facility->name }}"
                                                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;"
                                                            onmouseover="this.style.transform='scale(1.06)'"
                                                            onmouseout="this.style.transform='scale(1)'">
                                                    </div>

                                                    <div style="padding: 1.5rem;">
                                                        <h3
                                                            style="color: #FAEBD7; font-size: 1.25rem; font-weight: 600; margin-bottom: 0.75rem;">
                                                            <i class="bi bi-check-circle-fill me-2"
                                                                style="color: #4ade80;"></i>{{ $facility->name }}
                                                        </h3>
                                                        <p
                                                            style="color: #999; font-size: 0.95rem; line-height: 1.6; margin: 0;">
                                                            {!! $facility->description ?? 'No description available' !!}
                                                        </p>
                                                    </div>
                                                @else
                                                    {{-- simplified compact view when no image --}}
                                                    <div
                                                        style="display:flex; align-items:center; gap:1rem; padding:1.25rem; min-height:120px;">
                                                        <div
                                                            style="width:72px; height:72px; border-radius:12px; background: rgba(250,235,215,0.03); display:flex; align-items:center; justify-content:center; border:1px solid rgba(250,235,215,0.04);">
                                                            <i class="bi bi-building"
                                                                style="font-size:1.5rem; color: rgba(250,235,215,0.25);"></i>
                                                        </div>
                                                        <div style="flex:1;">
                                                            <h3
                                                                style="color: #FAEBD7; font-size: 1.1rem; font-weight: 600; margin: 0 0 0.4rem;">
                                                                <i class="bi bi-check-circle-fill me-2"
                                                                    style="color: #4ade80;"></i>{{ $facility->name }}
                                                            </h3>
                                                            @if ($facility->description)
                                                                <p
                                                                    style="color: #999; font-size: 0.95rem; margin: 0; line-height: 1.4;">
                                                                    {!! $facility->description !!}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($kostChunks->count() > 1)
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#kostFacilitiesCarouselDesktop" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#kostFacilitiesCarouselDesktop" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($kostChunks as $i => $_chunk)
                                <button type="button" data-bs-target="#kostFacilitiesCarouselDesktop"
                                    data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"
                                    aria-label="Slide {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div id="kostFacilitiesCarouselMobile" class="carousel slide d-lg-none mt-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($kostFacilities as $i => $facility)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <div class="p-3">
                                    <div class="facility-card"
                                        style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); border: 2px solid rgba(250, 235, 215, 0.12); border-radius: 12px; overflow: hidden;">
                                        @php
                                            $firstImage = $facility->facilities_images->first();
                                            if ($firstImage && $firstImage->image) {
                                                $path = $firstImage->image->image_path ?? '';
                                                $publicCandidate = public_path($path);
                                                if ($path !== '' && file_exists($publicCandidate)) {
                                                    $imgUrl = asset($path);
                                                } else {
                                                    $imgUrl = asset('storage/' . ltrim($path, '/'));
                                                }
                                            } else {
                                                $imgUrl = null;
                                            }
                                        @endphp

                                        @if ($imgUrl)
                                            <div style="height:180px; overflow: hidden;">
                                                <img src="{{ $imgUrl }}" alt="{{ $facility->name }}"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            </div>
                                            <div style="padding:1rem;">
                                                <h3 style="color: #FAEBD7; font-size:1.15rem; margin:0 0 .5rem;">
                                                    <i class="bi bi-check-circle-fill me-2"
                                                        style="color: #4ade80;"></i>{{ $facility->name }}
                                                </h3>
                                                <p style="color:#999; margin:0;">{!! $facility->description ?? '' !!}</p>
                                            </div>
                                        @else
                                            <div style="display:flex; gap:1rem; align-items:center; padding:1rem;">
                                                <div
                                                    style="width:56px; height:56px; border-radius:10px; background: rgba(250,235,215,0.03); display:flex; align-items:center; justify-content:center;">
                                                    <i class="bi bi-building"
                                                        style="font-size:1.25rem; color: rgba(250,235,215,0.25);"></i>
                                                </div>
                                                <div>
                                                    <h3 style="color: #FAEBD7; font-size:1.05rem; margin:0;">
                                                        {{ $facility->name }}</h3>
                                                    @if ($facility->description)
                                                        <p style="color:#999; margin:0;">{!! $facility->description !!}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($kostFacilities->count() > 1)
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#kostFacilitiesCarouselMobile" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#kostFacilitiesCarouselMobile" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                        <div class="carousel-indicators">
                            @foreach ($kostFacilities as $i => $_f)
                                <button type="button" data-bs-target="#kostFacilitiesCarouselMobile"
                                    data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"
                                    aria-label="Slide {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center" style="padding: 3rem 0;">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: rgba(250, 235, 215, 0.2);"></i>
                    <p style="color: #666; margin-top: 1rem;">No facilities available at the moment</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Terms & Conditions and Rules Section --}}
    @php
        $termsInfo = $information->firstWhere('title', 'Terms');
        $rulesInfo = $information->firstWhere('title', 'Rules');
    @endphp

    @if($termsInfo || $rulesInfo)
    <section class="terms-rules-section" style="background: linear-gradient(180deg, #0a0a0a 0%, #000 50%, #030303 100%); padding: 5rem 0;">
        <div class="container">
            <h2 class="section-title text-center mb-2">Important Information</h2>
            <p class="section-subtitle text-center mb-5">Please read our terms and house rules carefully</p>

            <div class="row g-4">
                @if($termsInfo)
                <div class="col-lg-6">
                    <div class="info-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 20px; padding: 2.5rem; height: 100%; transition: all 0.3s ease;">
                        <div class="info-header mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width: 60px; height: 60px; background: rgba(59, 130, 246, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-file-text-fill" style="font-size: 1.75rem; color: #3b82f6;"></i>
                                </div>
                                <h3 style="color: #FAEBD7; font-size: 1.75rem; font-weight: 700; margin: 0;">Terms & Conditions</h3>
                            </div>
                        </div>
                        <div class="info-content" style="color: rgba(250, 235, 215, 0.9); line-height: 1.8; font-size: 1rem;">
                            {!! $termsInfo->content !!}
                        </div>
                    </div>
                </div>
                @endif

                @if($rulesInfo)
                <div class="col-lg-6">
                    <div class="info-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 20px; padding: 2.5rem; height: 100%; transition: all 0.3s ease;">
                        <div class="info-header mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width: 60px; height: 60px; background: rgba(251, 191, 36, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-shield-fill-check" style="font-size: 1.75rem; color: #fbbf24;"></i>
                                </div>
                                <h3 style="color: #FAEBD7; font-size: 1.75rem; font-weight: 700; margin: 0;">House Rules</h3>
                            </div>
                        </div>
                        <div class="info-content" style="color: rgba(250, 235, 215, 0.9); line-height: 1.8; font-size: 1rem;">
                            {!! $rulesInfo->content !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <section class="contact-location-section" style="background: #000; padding: 5rem 0;">
        <div class="container">
            <h2 class="section-title text-center">Visit Us</h2>
            <p class="section-subtitle text-center">Find us at our convenient location in Surabaya</p>

            <div class="row g-4 mt-4">
                {{-- Contact Information --}}
                <div class="col-lg-6">
                    <div
                        style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px; padding: 2.5rem; height: 100%;">
                        <h3 style="color: #FAEBD7; font-size: 1.75rem; font-weight: 600; margin-bottom: 2rem;">
                            <i class="bi bi-telephone-fill me-2"></i>Contact Information
                        </h3>

                        <div class="contact-info-grid" style="display: flex; flex-direction: column; gap: 2rem;">
                            {{-- Address --}}
                            <div>
                                <div style="display: flex; align-items: start; gap: 1rem;">
                                    <div
                                        style="background: rgba(250, 235, 215, 0.1); border-radius: 12px; padding: 1rem; display: inline-flex;">
                                        <i class="bi bi-geo-alt-fill" style="font-size: 1.5rem; color: #FAEBD7;"></i>
                                    </div>
                                    <div>
                                        <h4
                                            style="color: #FAEBD7; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                                            Address</h4>
                                        <p style="color: #999; margin: 0; line-height: 1.6;">
                                            Siwalankerto Permai II/F7<br>
                                            Surabaya, East Java<br>
                                            Indonesia
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Whatsapp --}}
                            <div>
                                <div style="display: flex; align-items: start; gap: 1rem;">
                                    <div
                                        style="background: rgba(250, 235, 215, 0.1); border-radius: 12px; padding: 1rem; display: inline-flex;">
                                        <i class="bi bi-whatsapp" style="font-size: 1.5rem; color: #FAEBD7;"></i>
                                    </div>
                                    <div>
                                        <h4
                                            style="color: #FAEBD7; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                                            Whatsapp</h4>
                                        <a href="http://wa.me/6283856705857"
                                            style="color: #FAEBD7; text-decoration: none; font-size: 1.1rem;">
                                            {{$information->firstWhere('title', 'Whatsapp')->content}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div style="display: flex; align-items: start; gap: 1rem;">
                                    <div
                                        style="background: rgba(250, 235, 215, 0.1); border-radius: 12px; padding: 1rem; display: inline-flex;">
                                        <i class="bi bi-phone-fill" style="font-size: 1.5rem; color: #FAEBD7;"></i>
                                    </div>
                                    <div>
                                        <h4
                                            style="color: #FAEBD7; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                                            Phone</h4>
                                        <a href="tel:+6282139721494"
                                            style="color: #FAEBD7; text-decoration: none; font-size: 1.1rem;">
                                            {{$information->firstWhere('title', 'Phone')->content}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <div style="display: flex; align-items: start; gap: 1rem;">
                                    <div
                                        style="background: rgba(250, 235, 215, 0.1); border-radius: 12px; padding: 1rem; display: inline-flex;">
                                        <i class="bi bi-envelope-fill" style="font-size: 1.5rem; color: #FAEBD7;"></i>
                                    </div>
                                    <div>
                                        <h4
                                            style="color: #FAEBD7; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                                            Email</h4>
                                        <a href="mailto:info@imperialkost.com"
                                            style="color: #FAEBD7; text-decoration: none; font-size: 1.1rem;">
                                            {{$information->firstWhere('title', 'Email')->content}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Map --}}
                <div class="col-lg-6">
                    <div
                        style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px; padding: 2.5rem; height: 100%;">
                        <h3 style="color: #FAEBD7; font-size: 1.75rem; font-weight: 600; margin-bottom: 1.5rem;">
                            <i class="bi bi-map-fill me-2"></i>Our Location
                        </h3>

                        <div
                            style="border-radius: 12px; overflow: hidden; height: 400px; border: 2px solid rgba(250, 235, 215, 0.1);">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d989.2764508128244!2d112.74090516962275!3d-7.342014369432406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb367b73692f%3A0x41afcdd4d710f9d7!2sJl.%20Siwalankerto%20Permai%20II%20No.F7%2C%20Siwalankerto%2C%20Kec.%20Wonocolo%2C%20Surabaya%2C%20Jawa%20Timur%2060236!5e0!3m2!1sen!2sid!4v1767336364604!5m2!1sen!2sid"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <div class="mt-3">
                            <a href="https://maps.google.com/?q=Siwalankerto+Permai+II/F7+Surabaya" target="_blank"
                                style="display: inline-flex; align-items: center; gap: 0.5rem; color: #60a5fa; text-decoration: none; font-weight: 600; padding: 0.75rem 1.5rem; background: rgba(96, 165, 250, 0.1); border-radius: 8px; transition: all 0.3s;"
                                onmouseover="this.style.background='rgba(96, 165, 250, 0.2)'"
                                onmouseout="this.style.background='rgba(96, 165, 250, 0.1)'">
                                <i class="bi bi-box-arrow-up-right"></i>
                                Open in Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Render modals directly in the page --}}
    @if (($rooms ?? collect())->isNotEmpty())
        @foreach ($rooms as $room)
            @include('components.room-modal', ['room' => $room])
        @endforeach
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/roomModal.js') }}"></script>
@endpush

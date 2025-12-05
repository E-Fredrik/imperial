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
                    <a href="" class="btn-explore">Explore Rooms →</a>
                    <a href="" class="btn-learn">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


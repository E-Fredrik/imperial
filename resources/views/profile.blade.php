@extends('layouts.layout')
@section('title', 'Profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush
@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="text-end mb-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:#FAEBD7; color:#000; border-radius:8px; padding:0.45rem 0.75rem; border:none; font-weight:600;">
                        Log out
                    </button>
                </form>
            </div>
                
            <div class="profile-card">
                <div class="profile-header" style="display:flex; align-items:center; gap:1rem;">
                    <div class="profile-info">
                        <div class="profile-avatar">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="profile-name">{{ $user->name ?? 'John Doe' }}</h2>
                            <p class="profile-email">{{ $user->email ?? 'johndoe@gmail.com' }}</p>
                        </div>
                    </div>

                    @if($user->currentBooking ?? null)
                    <div class="room-badge">
                        <h6><i class="bi bi-geo-alt-fill"></i>Current Room</h6>
                        <p class="room-name">Room {{ $user->currentBooking->room->room_number ?? 'A' }}</p>
                        <p class="room-details">{{ $user->currentBooking->room->type ?? 'Single' }} • Floor {{ $user->currentBooking->room->floor ?? '1' }}</p>
                    </div>
                    @else
                    <div class="room-badge">
                        <h6><i class="bi bi-geo-alt-fill"></i>Current Room</h6>
                        <p class="room-name">No Room</p>
                        <p class="room-details">Not currently renting</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="transaction-card">
                <h3>Transaction History</h3>
                @if(!empty($transactions) && $transactions->isNotEmpty())
                    @foreach($transactions as $payment)
                        @php
                            $date = $payment->paid_at ? $payment->paid_at->format('d - m - Y') : optional($payment->created_at)->format('d - m - Y');
                            $amount = 'Rp ' . number_format($payment->amount, 0, ',', '.');
                        @endphp
                        <div class="transaction-item">
                            <div>
                                <div class="transaction-date">{{ $date }}</div>
                                <div class="transaction-amount">
                                    <i class="bi bi-receipt"></i>
                                    {{ $amount }}
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    Booking: #{{ $payment->booking_id }}
                                    @if(optional($payment->booking)->room)
                                        — Room {{ optional($payment->booking->room)->room_number }}
                                    @endif
                                </div>
                            </div>
                            <button class="transaction-info-btn" type="button" onclick="window.location.href='{{ route('bookings.show', $payment->booking_id) }}'">
                                <i class="bi bi-info-lg"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <p>No transactions yet.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
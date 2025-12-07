@extends('layouts.layout')
@section('title', 'Profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush
@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-card">
                <div class="profile-header">
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
                @php
                    $transactions = [
                        ['date' => '02 - 10 - 2025', 'amount' => 'Rp 1.850.000'],
                        ['date' => '02 - 09 - 2025', 'amount' => 'Rp 1.850.000'],
                        ['date' => '02 - 08 - 2025', 'amount' => 'Rp 1.850.000'],
                    ];
                @endphp
                @forelse($transactions as $transaction)
                    <div class="transaction-item">
                        <div>
                            <div class="transaction-date">{{ $transaction['date'] }}</div>
                            <div class="transaction-amount">
                                <i class="bi bi-receipt"></i>
                                {{ $transaction['amount'] }}
                            </div>
                        </div>
                        <button class="transaction-info-btn">
                            <i class="bi bi-info-lg"></i>
                        </button>
                    </div>
                @empty
                    <p>No transactions yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="icon">bi-speedometer2</x-slot>

    <!-- Link to Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Link to external dashboard CSS -->
    <link href="{{ asset('css/admin-dashboard.css') }}" rel="stylesheet">

    <!-- Quick Actions Section -->
    <div class="mb-5 dashboard-quick-actions">
        <h2 class="h5 mb-4 fw-semibold dashboard-heading">
            <i class="bi bi-lightning-fill me-2"></i>Quick Actions
        </h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.rooms.create') }}" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-door-closed-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Add New Room</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.bookings.create') }}" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-calendar-check-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">New Booking</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.info.create') }}" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-info-circle-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Add Information</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.images.create') }}" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-image-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Upload Image</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.rooms.index') }}" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-building fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2">{{ \App\Models\Room::count() }}</h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Total Rooms</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.bookings.index') }}?status=booked" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-bookmark-check-fill fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2">{{ \App\Models\Booking::where('status', 'booked')->count() }}</h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Active Bookings</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.bookings.index') }}?status=pending" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-clock-history fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2">{{ \App\Models\Booking::where('status', 'pending')->count() }}</h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Pending Bookings</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.payments.index') }}?status=pending" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-wallet2 fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2">{{ \App\Models\Payment::where('status', 'pending')->count() }}</h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Pending Payments</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Bookings & Room Status Row -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100 p-4" style="background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
                <div class="card-header bg-transparent border-0 p-0 pb-3" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 class="h5 mb-0 fw-semibold dashboard-heading d-flex align-items-center">
                        <i class="bi bi-clock-history me-2"></i>Recent Bookings
                    </h3>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm admin-secondary-btn">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body px-4 pb-4">
                    @php
                        $recentBookings = \App\Models\Booking::with(['user', 'room'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @if($recentBookings->count() > 0)
                        <div class="d-flex flex-column gap-3">
                            @foreach($recentBookings as $booking)
                                <div class="booking-item rounded-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="fw-semibold mb-1 dashboard-heading">
                                                {{ optional($booking->user)->first_name }} {{ optional($booking->user)->last_name }}
                                            </div>
                                            <small class="dashboard-text-muted">
                                                {{ optional($booking->user)->email }}
                                            </small>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2 booking-badge-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                    <div class="d-flex gap-3 small dashboard-text-muted">
                                        <span><i class="bi bi-door-closed me-1"></i>Room {{ optional($booking->room)->room_number }}</span>
                                        <span><i class="bi bi-calendar me-1"></i>{{ $booking->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted opacity-25"></i>
                            <p class="dashboard-text-muted mt-3 mb-0">No bookings yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 p-4" style="background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
                <div class="card-header bg-transparent border-0 p-0 pb-3">
                    <h3 class="h5 mb-0 fw-semibold dashboard-heading d-flex align-items-center">
                        <i class="bi bi-pie-chart-fill me-2"></i>Room Status Overview
                    </h3>
                </div>
                <div class="card-body p-0">
                    @php
                        $roomStats = [
                            'available' => ['count' => \App\Models\Room::where('status', 'available')->count(), 'color' => '#ffffff', 'bg' => 'linear-gradient(135deg, #e5e5e5 0%, #ffffff 100%)', 'icon' => 'check-circle-fill', 'label' => 'Available'],
                            'booked' => ['count' => \App\Models\Room::where('status', 'booked')->count(), 'color' => '#ffffff', 'bg' => 'linear-gradient(135deg, #e5e5e5 0%, #ffffff 100%)', 'icon' => 'x-circle-fill', 'label' => 'Booked'],
                            'unavailable' => ['count' => \App\Models\Room::where('status', 'unavailable')->count(), 'color' => '#ffffff', 'bg' => 'linear-gradient(135deg, #e5e5e5 0%, #ffffff 100%)', 'icon' => 'exclamation-circle-fill', 'label' => 'Unavailable']
                        ];
                        $totalRooms = array_sum(array_column($roomStats, 'count'));
                    @endphp

                    @foreach($roomStats as $key => $data)
                        @php
                            $percentage = $totalRooms > 0 ? round(($data['count'] / $totalRooms) * 100) : 0;
                        @endphp
                        <div class="mb-4 room-status-item">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="status-icon-box d-flex align-items-center justify-content-center" style="background: rgba(255, 255, 255, 0.1); width: 56px; height: 56px; border-radius: 12px;">
                                        <i class="bi bi-{{ $data['icon'] }} fs-3" style="color: {{ $data['color'] }}"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold" style="color: #ffffff; font-size: 1.5rem;">{{ $data['count'] }}</h5>
                                        <small style="color: #999; font-size: 0.9rem;">{{ $data['label'] }} Rooms</small>
                                    </div>
                                </div>
                                <div class="percentage-circle" style="border: 3px solid {{ $data['color'] }}; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <span class="fw-bold" style="color: #ffffff; font-size: 1.1rem;">{{ $percentage }}%</span>
                                </div>
                            </div>
                            <div class="progress room-progress" style="height: 12px; border-radius: 10px; background: rgba(255,255,255,0.1);">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background: {{ $data['bg'] }}; border-radius: 10px;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
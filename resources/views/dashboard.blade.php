<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="icon">bi-speedometer2</x-slot>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-door-closed"></i>
            </div>
            <div class="stat-value">{{ \App\Models\Room::count() }}</div>
            <div class="stat-label">Total Rooms</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-value">{{ \App\Models\Booking::where('status', 'booked')->count() }}</div>
            <div class="stat-label">Active Bookings</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-value">{{ \App\Models\Booking::where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending Bookings</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-credit-card"></i>
            </div>
            <div class="stat-value">{{ \App\Models\Payment::where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending Payments</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-lightning"></i> Quick Actions</h3>
        </div>
        
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.rooms.create') }}" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add New Room</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.bookings.create') }}" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-calendar-plus"></i>
                    <span>New Booking</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.info.create') }}" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-file-plus"></i>
                    <span>Add Information</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.images.create') }}" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-upload"></i>
                    <span>Upload Image</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <h3><i class="bi bi-clock-history"></i> Recent Bookings</h3>
                    <a href="{{ route('admin.bookings.index') }}" class="btn-admin-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        View All
                    </a>
                </div>
                
                @php
                    $recentBookings = \App\Models\Booking::with(['user', 'room'])
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($recentBookings->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                    <tr>
                                        <td>
                                            {{ optional($booking->user)->first_name }} {{ optional($booking->user)->last_name }}<br>
                                            <small style="color: #999;">{{ optional($booking->user)->email }}</small>
                                        </td>
                                        <td><strong>Room {{ optional($booking->room)->room_number }}</strong></td>
                                        <td>
                                            <span class="badge-status badge-{{ $booking->status }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: #999; text-align: center; padding: 2rem;">No bookings yet.</p>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <h3><i class="bi bi-door-closed"></i> Room Status</h3>
                </div>
                
                @php
                    $roomStats = [
                        'available' => \App\Models\Room::where('status', 'available')->count(),
                        'booked' => \App\Models\Room::where('status', 'booked')->count(),
                        'unavailable' => \App\Models\Room::where('status', 'unavailable')->count(),
                    ];
                    $total = array_sum($roomStats);
                @endphp
                
                <div style="display: grid; gap: 1rem;">
                    @foreach($roomStats as $status => $count)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #2a2a2a; border-radius: 10px; border-left: 4px solid {{ $status === 'available' ? '#22c55e' : ($status === 'booked' ? '#ef4444' : '#6b7280') }};">
                            <div>
                                <div style="font-size: 0.875rem; color: #999; text-transform: uppercase; margin-bottom: 0.25rem;">{{ $status }}</div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #FAEBD7;">{{ $count }} <span style="font-size: 0.875rem; color: #999;">rooms</span></div>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 12px; background: {{ $status === 'available' ? '#22c55e' : ($status === 'booked' ? '#ef4444' : '#6b7280') }}; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #fff;">
                                {{ $total > 0 ? round(($count / $total) * 100) : 0 }}%
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


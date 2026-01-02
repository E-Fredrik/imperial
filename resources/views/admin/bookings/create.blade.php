<x-admin-layout>
    <x-slot name="title">Add New Booking</x-slot>
    <x-slot name="header">Add New Booking</x-slot>
    <x-slot name="icon">bi-calendar-check</x-slot>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-calendar-check me-2"></i>Create New Booking</h3>
            <a href="{{ route('admin.bookings.index') }}" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bookings
            </a>
        </div>

        @if ($errors->any())
            <div class="alert-danger">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.bookings.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateAdminBookingForm()">
            @csrf

            <!-- User Selection -->
            <div class="form-group">
                <label for="user_id">
                    <i class="bi bi-person me-1"></i>User
                </label>
                <select id="user_id" name="user_id" required>
                    <option value="">Select user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }} — {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Room Selection -->
            <div class="form-group">
                <label for="room_id">
                    <i class="bi bi-door-closed me-1"></i>Room
                </label>
                <select id="room_id" name="room_id" required>
                    <option value="">Choose a room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" data-price="{{ $room->price }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            Room {{ $room->room_number }} — {{ $room->type }} — Rp {{ number_format($room->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Move-in Date -->
            <div class="form-group">
                <label for="move_in_date">
                    <i class="bi bi-calendar-event me-1"></i>Move-in Date
                </label>
                <input 
                    type="date" 
                    name="move_in_date" 
                    id="move_in_date" 
                    value="{{ old('move_in_date') }}"
                    required
                    min="{{ date('Y-m-d') }}">
                <small>
                    <i class="bi bi-info-circle me-1"></i>Move-in date cannot be in the past. 5-day grace period before late fees apply.
                </small>
            </div>

            <!-- Proof of Payment -->
            <div class="form-group">
                <label for="proof">
                    <i class="bi bi-image me-1"></i>Proof of Payment (Optional)
                </label>
                <input 
                    type="file" 
                    name="proof" 
                    id="proof" 
                    accept="image/*">
                <small>
                    <i class="bi bi-info-circle me-1"></i>PNG/JPG up to 4MB. Admin can attach proof when creating a booking.
                </small>
            </div>

            <!-- ID Card -->
            <div class="form-group">
                <label for="id_card">
                    <i class="bi bi-card-image me-1"></i>ID Card (Photo)
                </label>
                <input 
                    type="file" 
                    name="id_card" 
                    id="id_card" 
                    accept="image/*">
                <small>
                    <i class="bi bi-info-circle me-1"></i>PNG/JPG up to 4MB. Attach the user's ID card photo (optional).
                </small>
            </div>

            <!-- Monthly Rent (Display Only) -->
            <div class="form-group">
                <label for="monthly_rent_display">
                    <i class="bi bi-cash-coin me-1"></i>Monthly Rent
                </label>
                <input 
                    type="text" 
                    id="monthly_rent_display" 
                    readonly 
                    placeholder="Select a room to see monthly rent"
                    style="background-color: rgba(250, 235, 215, 0.03); cursor: not-allowed;">
                <small>
                    <i class="bi bi-info-circle me-1"></i>Monthly rent follows the selected room price and is not editable here.
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="{{ route('admin.bookings.index') }}" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Create Booking
                </button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/booking.js') }}"></script>
    <script>
    function validateAdminBookingForm() {
        const moveInInput = document.getElementById('move_in_date');
        if (!moveInInput) return true;
        
        const selectedDate = new Date(moveInInput.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            alert('Move-in date cannot be in the past. Please select today or a future date.');
            moveInInput.focus();
            return false;
        }
        
        return true;
    }

    // Also prevent typing/pasting invalid dates
    document.addEventListener('DOMContentLoaded', function() {
        const moveInInput = document.getElementById('move_in_date');
        if (moveInInput) {
            moveInInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    alert('Move-in date cannot be in the past. Please select today or a future date.');
                    this.value = '{{ date("Y-m-d") }}';
                }
            });
        }
    });
    </script>
</x-admin-layout>
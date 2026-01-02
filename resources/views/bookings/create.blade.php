@extends('layouts.layout')
@section('title', 'Book a room')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">

@section('content')
<section class="py-6" style="background:black; min-height:60vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div style="background:#0a0a0a; color:#FAEBD7; border-radius:12px; padding:1.5rem; box-shadow:0 8px 30px rgba(0,0,0,0.6);">
                    <h3 style="margin-bottom:1rem;">Book a room</h3>

                    @if ($errors->any())
                        <div class="mb-4 text-sm text-rose-600">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" onsubmit="return validateBookingForm()">
                        @csrf

                        <div class="mb-3">
                            <label for="room_id" class="form-label" style="color:#cfc6bc;">Room</label>
                            <select id="room_id" name="room_id" required class="form-select" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;">
                                <option value="">{{ __('Choose a room') }}</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" data-price="{{ $room->price }}" {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                        Room {{ $room->room_number }} — {{ $room->type }} — Rp {{ number_format($room->price, 0, ',', '.') }}/month
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="move_in_date" class="form-label" style="color:#cfc6bc;">Move-in date</label>
                            <input id="move_in_date" name="move_in_date" type="date" required
                                   class="form-control" style="background:#111; color:#FAEBD7; border:1px solid #2b2b2b;"
                                   value="{{ old('move_in_date', request()->get('check_in') ?? now()->format('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('move_in_date')" class="mt-2" />
                            <div class="form-text" style="color:#999;">
                                <i class="bi bi-info-circle me-1"></i>You have a 5-day grace period from the 1st of each month before late fees apply.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_card" class="form-label" style="color:#cfc6bc;">ID Card (photo)</label>
                            <input id="id_card" name="id_card" type="file" accept="image/*"
                                   class="form-control"
                                   style="background:#000; color:#FAEBD7; border:1px solid #2b2b2b; border-radius:6px; padding:.375rem .75rem;" required/>
                            <x-input-error :messages="$errors->get('id_card')" class="mt-2" />
                            <div class="form-text" style="color:#999;">Please attach a clear photo of your ID (PNG/JPG up to 4MB).</div>
                        </div>

                        <div class="mb-3 p-3" style="background:#1a1a1a; border-radius:8px;">
                            <p style="color:#999; font-size:0.9rem; margin:0;">
                                <i class="bi bi-info-circle"></i> After submitting, you'll be redirected to complete payment via Midtrans secure payment gateway.
                            </p>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn" style="background:#FAEBD7; color:#000; font-weight:600; border-radius:8px; padding:.5rem 1rem;">
                                {{ __('Proceed to Payment') }}
                            </button>

                            <a href="{{ route('rooms') }}" class="btn btn-secondary" style="background:#333; color:#cfc6bc; border:none; padding:.45rem .9rem;">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function validateBookingForm() {
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
@endsection
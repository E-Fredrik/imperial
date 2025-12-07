<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Booking') }}
        </h2>
    </x-slot>
    <div class="p-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('admin.bookings.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-input-label for="user_id" :value="__('User')" />
                <select id="user_id" name="user_id" required class="mt-1 block w-full">
                    <option value="">{{ __('Select user') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }} — {{ $user->email }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="room_id" :value="__('Room')" />
                <select id="room_id" name="room_id" required class="mt-1 block w-full">
                    <option value="">{{ __('Choose a room') }}</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                            {{ $room->room_number }} — {{ $room->type }} — {{ $room->price }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="move_in_date" :value="__('Move-in date')" />
                <input id="move_in_date" name="move_in_date" type="date" required class="mt-1 block w-full" value="{{ old('move_in_date') }}" />
                <x-input-error :messages="$errors->get('move_in_date')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="proof" :value="__('Proof of Payment (optional)')" />
                <input id="proof" name="proof" type="file" accept="image/*" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('proof')" class="mt-2" />
                <p class="text-xs text-gray-500 mt-1">PNG/JPG up to 4MB. Admin can attach proof when creating a booking.</p>
            </div>

            <div class="mt-4">
                <x-input-label :value="__('Monthly Rent')" />
                <div class="mt-1">
                    <input id="monthly_rent_display" type="text" readonly class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2" value="" />
                </div>
                <p class="text-xs text-gray-500 mt-1">Monthly rent follows the selected room price and is not editable here.</p>
            </div>


            <div class="mt-6">
                <x-primary-button>{{ __('Book') }}</x-primary-button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/booking.js') }}"></script>
</x-app-layout>
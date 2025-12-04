<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.rooms.update', $room) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="room_number" :value="__('Room number')" />
                                <x-text-input id="room_number" name="room_number" type="text" class="mt-1 block w-full"
                                    value="{{ old('room_number', $room->room_number) }}" required />
                                <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="price" :value="__('Price')" />
                                    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
                                        value="{{ old('price', $room->price) }}" />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="type" :value="__('Type')" />
                                    <x-text-input id="type" name="type" type="text" class="mt-1 block w-full"
                                        value="{{ old('type', $room->type) }}" />
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="length" :value="__('Length')" />
                                    <x-text-input id="length" name="length" type="number" class="mt-1 block w-full"
                                        value="{{ old('length', $room->length) }}" />
                                    <x-input-error :messages="$errors->get('length')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="width" :value="__('Width')" />
                                    <x-text-input id="width" name="width" type="number" class="mt-1 block w-full"
                                        value="{{ old('width', $room->width) }}" />
                                    <x-input-error :messages="$errors->get('width')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="floor" :value="__('Floor')" />
                                    <x-text-input id="floor" name="floor" type="number" class="mt-1 block w-full"
                                        value="{{ old('floor', $room->floor) }}" />
                                    <x-input-error :messages="$errors->get('floor')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700">
                                    @php $s = old('status', $room->status ?? 'available'); @endphp
                                    <option value="available" {{ $s === 'available' ? 'selected' : '' }}>available</option>
                                    <option value="booked" {{ $s === 'booked' ? 'selected' : '' }}>booked</option>
                                    <option value="unavailable" {{ $s === 'unavailable' ? 'selected' : '' }}>unavailable</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <x-primary-button>{{ __('Update Room') }}</x-primary-button>

                            <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-md">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
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
                    <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
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

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700">{{ old('description', $room->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="images" :value="__('Add Images (optional)')" />
                                <input id="images" name="images[]" type="file" multiple accept="image/*" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Existing images are preserved. Uploading new files will add to the room.</p>

                                <!-- preview for newly selected images (client-side) -->
                                <div id="new-images-preview" class="mt-2 flex flex-wrap"></div>
                            </div>

                            @php
                                // Pre-select previously saved facilities or keep old input on validation errors
                                $selectedFacilities = old('facilities', $room->rooms_facilities->pluck('facility_id')->toArray());
                            @endphp

                            <div>
                                <x-input-label :value="__('Facilities')" />
                                <div class="mt-2 grid grid-cols-2 gap-2">
                                    @foreach($facilities as $facility)
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox"
                                                   name="facilities[]"
                                                   value="{{ $facility->id }}"
                                                   {{ in_array($facility->id, $selectedFacilities) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-sm text-gray-700 dark:text-white pl-4">{{ $facility->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('facilities')" class="mt-2" />
                                <x-input-error :messages="$errors->get('facilities.*')" class="mt-2" />
                            </div>

                        @foreach($room->rooms_images as $ri)
                            @php
                                // get the attached Image model via pivot model RoomsImage
                                $image = $ri->image;
                                $path = $image->image_path ?? '';
                                $publicCandidate = public_path($path);
                                if ($path !== '' && file_exists($publicCandidate)) {
                                    $imgUrl = asset($path);
                                } else {
                                    $imgUrl = asset('storage/' . ltrim($path, '/'));
                                }
                            @endphp

                            <div class="relative">
                                <img
                                    id="thumb-{{ $image->id }}"
                                    data-image-id="{{ $image->id }}"
                                    data-original-src="{{ $imgUrl }}"
                                    src="{{ $imgUrl }}"
                                    alt=""
                                    class="w-32 h-24 object-cover rounded border"
                                    title="Click Replace to choose a new file"
                                />

                                <!-- single file input (has id and name so label triggers it, no JS required) -->
                                <input
                                    id="replace-{{ $image->id }}"
                                    type="file"
                                    name="replace_images[{{ $image->id }}]"
                                    accept="image/*"
                                    class="sr-only"
                                    data-image-id="{{ $image->id }}"
                                />

                                <div class="mt-2 text-center space-x-2">
                                    <label for="replace-{{ $image->id }}"
                                           class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded cursor-pointer">
                                        Replace
                                    </label>
                                    <span id="status-{{ $image->id }}" class="text-xs text-gray-600 block mt-1"></span>
                                </div>
                            </div>
                        @endforeach
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <x-primary-button>{{ __('Update Room') }}</x-primary-button>

                            <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-md">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>

                    <script src="{{ asset('JS/editRoom.js') }}"></script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
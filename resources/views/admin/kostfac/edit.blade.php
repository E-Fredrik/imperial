<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kost Facility') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.kostfac.update', $kostfac) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    value="{{ old('name', $kostfac->name) }}" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <x-trix-input id="description" name="description" :value="old('description', $kostfac->description ?? '')" autocomplete="off" />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label :value="__('Existing Images (click Choose to replace)')" />
                                <div class="flex flex-wrap gap-4 mt-2">
                                    @foreach($kostfac->facilities_images ?? collect() as $fi)
                                        @php
                                            $image = $fi->image;
                                            $path = $image->image_path ?? '';
                                            $publicCandidate = public_path($path);
                                            if ($path !== '' && file_exists($publicCandidate)) {
                                                $imgUrl = asset($path);
                                            } else {
                                                $imgUrl = asset('storage/' . ltrim($path, '/'));
                                            }
                                        @endphp

                                        <div class="relative text-center">
                                            <img id="thumb-{{ $image->id }}" src="{{ $imgUrl }}" data-original-src="{{ $imgUrl }}" class="w-32 h-24 object-cover rounded border mb-2" alt="facility image" />

                                            <!-- moved file input into the outer form (no nested form) -->
                                            <div class="flex items-center justify-center gap-2">
                                                <label for="replace-{{ $image->id }}" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded cursor-pointer">
                                                    Choose
                                                </label>
                                                <input id="replace-{{ $image->id }}"
                                                       type="file"
                                                       name="replace_images[{{ $image->id }}]"
                                                       accept="image/*"
                                                       class="sr-only replace-input"
                                                       data-image-id="{{ $image->id }}" />
                                                <span id="status-{{ $image->id }}" class="text-xs text-gray-600 block mt-1"></span>
                                            </div>

                                            <x-input-error :messages="$errors->get('replace_images.'.$image->id)" class="mt-1" />
                                        </div>
                                    @endforeach

                                    @if(($kostfac->facilities_images ?? collect())->isEmpty())
                                        <div>
                                            <img src="{{ asset('images/roomFac/default.jpg') }}" class="w-32 h-24 object-cover rounded border" alt="default facility" />
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <x-input-label for="images" :value="__('Add Images (optional)')" />
                                <input id="images" name="images[]" type="file" multiple accept="image/*" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <div id="new-images-preview" class="mt-2 flex flex-wrap"></div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>

                            <a href="{{ route('admin.kostfac.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-sm rounded">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>

                    <script src="{{ asset('js/editRoom.js') }}"></script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
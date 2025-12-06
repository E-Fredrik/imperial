<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Kost Facility') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.kostfac.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <x-trix-input id="description" name="description" :value="old('description')" autocomplete="off" />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="images" :value="__('Images (optional)')" />
                                <input id="images" name="images[]" type="file" multiple accept="image/*" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <div id="new-images-preview" class="mt-2 flex flex-wrap"></div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <x-primary-button>{{ __('Create') }}</x-primary-button>

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
// ...existing code...
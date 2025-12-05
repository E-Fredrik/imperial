<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    {{-- Admin: Rooms CRUD button --}}
                    @if(auth()->check() && (auth()->user()->role ?? '') === 'admin')
                        <div class="mt-4">
                            <a href="{{ route('admin.rooms.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                                Manage Rooms
                            </a>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('admin.info.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                                Manage Information
                            </a>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.roomfac.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                                Manage Room Facilities
                            </a>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


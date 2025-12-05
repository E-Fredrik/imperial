<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Room Facilities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Room Facilities Table --}}
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table-auto w-full text-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-sm font-medium text-white">ID</th>
                                <th class="px-4 py-2 text-sm font-medium text-white">Facility Name</th>
                                <th class="px-4 py-2 text-sm font-medium text-white">Description</th>
                                <th class="px-4 py-2 text-sm font-medium text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facilities as $facility)
                                <tr>
                                    <td class="border px-4 py-2 text-white">{{ $facility->id }}</td>
                                    <td class="border px-4 py-2 text-white">{{ $facility->name }}</td>
                                    <td class="border px-4 py-2 text-white">
                                        <div class="prose max-w-none text-sm text-gray-800 dark:text-white" style="max-height:6rem; overflow:auto;">
                                            {!! $facility->description !!}
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.roomfac.edit', $facility) }}" class="inline-block px-2 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded text-sm me-2">Edit</a>
                                        <form action="{{ route('admin.roomfac.destroy', $facility) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block px-2 py-1 bg-red-600 hover:bg-red-500 text-white rounded text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
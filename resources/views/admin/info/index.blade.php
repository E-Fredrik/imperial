<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Information Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            @if (Route::has('admin.info.create'))
                                <a href="{{ route('admin.info.create') }}"
                                   class="inline-block px-4 py-2 rounded shadow-md border border-indigo-700 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold"
                                   style="background-color: #4f46e5; color: #ffffff;">
                                    Create New Information
                                </a>
                            @endif
                        </div>

                        {{-- optional search / controls placeholder --}}
                        <div class="text-sm text-gray-600">
                            {{-- controls can go here --}}
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="text-left">
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">ID</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">Title</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">Content</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($info as $information)
                                    <tr class="odd:bg-white even:bg-gray-50">
                                        <td class="py-2 px-4 border-b text-sm text-gray-800">{{ $information->id }}</td>
                                        <td class="py-2 px-4 border-b text-sm text-gray-800">{{ $information->title }}</td>
                                        <td class="py-2 px-4 border-b text-sm text-gray-800 align-top">
                                            <div class="prose max-w-none text-sm text-gray-800 dark:text-black" style="max-height:6rem; overflow:auto;">
                                                {!! $information->content !!}
                                            </div>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <div class="flex items-center gap-2">
                                                <!-- Edit button: force visible filled style -->
                                                <a href="{{ route('admin.info.edit', $information) }}"
                                                   class="inline-flex items-center px-3 py-1 rounded shadow-md text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                   style="background-color:#4f46e5; border:1px solid #4338ca; color:#ffffff;">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.info.destroy', $information) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block px-3 py-1 rounded bg-rose-600 hover:bg-rose-700 text-white text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 px-4 text-center text-gray-600">
                                            No information entries found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $info->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
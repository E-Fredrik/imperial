<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <a href="{{ route('admin.bookings.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                                Create Booking
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-transparent">
                            <thead>
                                <tr class="text-left">
                                    <th class="py-2 px-4 border-b text-sm font-medium">ID</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">User</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Room</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Move-in</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Rent</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Payments</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Status</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:even:bg-gray-700">
                                        <td class="py-2 px-4 border-b text-sm">{{ $booking->id }}</td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            {{ optional($booking->user)->first_name ?? '-' }}
                                            {{ optional($booking->user)->last_name ?? '' }}<br/>
                                            <span class="text-xs text-gray-500">{{ optional($booking->user)->email ?? '' }}</span>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            {{ optional($booking->room)->room_number ?? '-' }}
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">{{ optional($booking->move_in_date)->format('Y-m-d') ?? '-' }}</td>
                                        <td class="py-2 px-4 border-b text-sm">{{ $booking->monthly_rent }}</td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            @foreach($booking->payments as $p)
                                                <div class="mb-1">
                                                    <span class="text-sm font-medium">{{ $p->amount }}</span>
                                                    <span class="text-xs text-gray-500"> — {{ $p->status }}</span>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $booking->status === 'booked' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.bookings.show', $booking) }}" class="inline-flex px-2 py-1 bg-blue-600 text-white rounded text-sm">View</a>

                                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex px-2 py-1 bg-rose-600 text-white rounded text-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-6 px-4 text-center text-gray-600">No bookings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking Details') }} — #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->has('move_out_date'))
                        <div class="mb-4 text-sm text-rose-600">
                            {{ $errors->first('move_out_date') }}
                        </div>
                    @endif

                    <div class="mb-4 flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Booking ID</div>
                            <div class="text-lg font-medium">{{ $booking->id }}</div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                                Back to Bookings
                            </a>

                            @if($booking->status === 'pending')
                                <form action="{{ route('admin.bookings.decline', $booking) }}" method="POST" onsubmit="return confirm('Decline this booking and the latest payment?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded text-sm">Decline Booking</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="col-span-2">
                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">User</h3>
                            <div class="mt-2 text-sm">
                                <div class="font-medium">{{ optional($booking->user)->first_name ?? '-' }} {{ optional($booking->user)->last_name ?? '' }}</div>
                                <div class="text-xs text-gray-500 dark:text-white">{{ optional($booking->user)->email ?? '' }}</div>
                                @if(optional($booking->user)->phone_number)
                                    <div class="text-xs text-gray-500">{{ $booking->user->phone_number }}</div>
                                @endif
                            </div>

                            <hr class="my-4">

                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Room</h3>
                            <div class="mt-2 text-sm">
                                <div class="font-medium">{{ optional($booking->room)->room_number ?? '-' }} — {{ optional($booking->room)->type ?? '' }}</div>
                                <div class="text-xs text-gray-500 dark:text-white">Price: {{ number_format(optional($booking->room)->price ?? $booking->monthly_rent) }}</div>
                                <div class="text-xs text-gray-500 dark:text-white">Status: {{ optional($booking->room)->status ?? '-' }}</div>
                            </div>

                            <hr class="my-4">

                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Booking Info</h3>
                            <div class="mt-2 text-sm space-y-1">
                                <div>Move-in: <span class="font-medium">{{ optional($booking->move_in_date)->format('Y-m-d') ?? '-' }}</span></div>
                                <div>
                                    <span class="text-sm">Move-out:</span>
                                    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="inline-block ml-2">
                                        @csrf
                                        @method('PUT')
                                        <input
                                            id="move_out_date"
                                            name="move_out_date"
                                            type="date"
                                            value="{{ old('move_out_date', optional($booking->move_out_date)->format('Y-m-d')) }}"
                                            class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-1"
                                        />
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-indigo-600 hover:bg-indigo-500 text-white rounded text-sm ms-2">Save</button>
                                    </form>
                                </div>
                                <div>Monthly Rent: <span class="font-medium">{{ number_format($booking->monthly_rent) }}</span></div>
                                <div>Status: 
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $booking->status === 'booked' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Summary</h3>
                            <div class="mt-3 bg-gray-50 dark:bg-gray-700 p-4 rounded">
                                <div class="text-sm text-gray-500 dark:text-white">Total payments</div>
                                <div class="text-lg font-semibold mt-1">{{ number_format($booking->payments->sum('amount')) }}</div>

                                <div class="mt-4">
                                    <div class="text-sm text-gray-500 dark:text-white">Payments count</div>
                                    <div class="font-medium">{{ $booking->payments->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-3">Payments</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Month</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Proof</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-transparent divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($booking->payments as $payment)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:even:bg-gray-800">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $payment->id }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $payment->payment_for_month }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ number_format($payment->amount) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            @php
                                                $path = $payment->proof ?? '';
                                                if ($path !== '' && file_exists(public_path($path))) {
                                                    $url = asset($path);
                                                } elseif ($path) {
                                                    $url = asset('storage/' . ltrim($path, '/'));
                                                } else {
                                                    $url = null;
                                                }
                                            @endphp
                                            @if($url)
                                                <a href="{{ $url }}" target="_blank" class="text-blue-600 hover:underline text-sm">View</a>
                                            @else
                                                <span class="text-xs text-gray-500">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs
                                                @if($payment->status === 'accepted') bg-green-100 text-green-800
                                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($payment->status === 'declined') bg-rose-100 text-rose-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $payment->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center gap-2">
                                                @if($payment->status !== 'accepted')
                                                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="action" value="accept" />
                                                        <button type="submit" class="inline-flex px-3 py-1 bg-green-600 hover:bg-green-500 text-white rounded text-sm">Accept</button>
                                                    </form>
                                                @endif

                                                @if($payment->status !== 'declined')
                                                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}" onsubmit="return confirm('Decline this payment?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="action" value="decline" />
                                                        <button type="submit" class="inline-flex px-3 py-1 bg-rose-600 hover:bg-rose-500 text-white rounded text-sm">Decline</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-600 dark:text-gray-400">No payments recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-md">
                            Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
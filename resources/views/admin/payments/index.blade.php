<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payments') }}
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

                    <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            <strong>Note:</strong> Payments are now processed via Midtrans. Status updates automatically when customers complete payment.
                            You can still manually accept/decline payments for cash or offline transactions.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Booking</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">User</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Room</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Month</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Payment Type</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-transparent divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($payments as $payment)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:even:bg-gray-800">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $payment->id }}</td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="text-blue-600 hover:underline">
                                                #{{ $payment->booking_id }}
                                            </a>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ optional($payment->booking->user)->first_name ?? '-' }}
                                            {{ optional($payment->booking->user)->last_name ?? '' }}<br />
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($payment->booking->user)->email ?? '' }}</span>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ optional($payment->booking->room)->room_number ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $payment->payment_for_month }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ number_format($payment->amount) }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $payment->payment_type ?? 'N/A' }}
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
                                                <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="inline-flex px-3 py-1 bg-blue-600 text-white rounded text-sm">View Booking</a>

                                                @if($payment->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="action" value="accept" />
                                                        <button type="submit" class="inline-flex px-3 py-1 bg-green-600 hover:bg-green-500 text-white rounded text-sm" title="Manual accept (for cash payments)">Accept</button>
                                                    </form>

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
                                        <td colspan="9" class="px-4 py-6 text-center text-gray-600 dark:text-gray-400">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
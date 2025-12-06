<x-app-layout>
    <x-slot name="header"><h2>{{ __('Payments') }}</h2></x-slot>

    <div class="p-6 max-w-5xl mx-auto">
        @foreach($payments as $payment)
            <div class="p-4 mb-3 bg-white dark:bg-gray-800 rounded shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-sm"><strong>Booking #{{ $payment->booking_id }}</strong> — Room: {{ $payment->booking->room->room_number ?? '-' }}</div>
                        <div class="text-xs text-gray-500">User: {{ $payment->booking->user->first_name ?? '' }} {{ $payment->booking->user->last_name ?? '' }}</div>
                        <div class="mt-2">Amount: {{ $payment->amount }} — Status: <span class="font-medium">{{ $payment->status }}</span></div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
                            @csrf
                            <input type="hidden" name="action" value="accept" />
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Accept</button>
                        </form>

                        <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
                            @csrf
                            <input type="hidden" name="action" value="decline" />
                            <button type="submit" class="px-3 py-1 bg-rose-600 text-white rounded">Decline</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
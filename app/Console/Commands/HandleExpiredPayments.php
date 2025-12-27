<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class HandleExpiredPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:handle-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle expired payments and update room statuses';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for expired payments...');

        $expiredPayments = Payment::expired()->with('booking.room')->get();

        if ($expiredPayments->isEmpty()) {
            $this->info('No expired payments found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$expiredPayments->count()} expired payment(s).");

        foreach ($expiredPayments as $payment) {
            $this->info("Processing payment #{$payment->id}...");

            $payment->status = 'declined';
            $payment->save();

            $booking = $payment->booking;
            if (!$booking) {
                $this->warn("  Booking not found for payment #{$payment->id}");
                continue;
            }

            // Check if this is the first payment
            $acceptedPayments = Payment::where('booking_id', $booking->id)
                ->where('status', 'accepted')
                ->count();

            if ($acceptedPayments === 0) {
                // First payment expired, cancel booking
                $this->warn("  First payment expired for booking #{$booking->id}, canceling booking");
                
                $booking->update(['status' => 'declined']);
                
                if ($booking->room) {
                    $booking->room->update(['status' => 'available']);
                    $this->info("  Room #{$booking->room->room_number} is now available");
                }
            } else {
                $this->info("  Subsequent payment expired for booking #{$booking->id}");
            }

            Log::info('Expired payment processed by scheduler', [
                'payment_id' => $payment->id,
                'booking_id' => $booking->id,
            ]);
        }

        $this->info('Expired payments processed successfully.');
        return Command::SUCCESS;
    }
}
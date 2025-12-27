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
    protected $description = 'Handle expired payments (first payments with 24h window only)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for expired first payments (with 24h window)...');

        // Only get payments that have an expires_at set (first payments only)
        $expiredPayments = Payment::where('status', 'pending')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->with('booking.room')
            ->get();

        if ($expiredPayments->isEmpty()) {
            $this->info('No expired first payments found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$expiredPayments->count()} expired first payment(s).");

        foreach ($expiredPayments as $payment) {
            $this->info("Processing payment #{$payment->id}...");

            $payment->status = 'declined';
            $payment->save();

            $booking = $payment->booking;
            if (!$booking) {
                $this->warn("  Booking not found for payment #{$payment->id}");
                continue;
            }

            // Check if this is truly the first payment (should be, since it has expires_at)
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
                // This shouldn't happen (recurring payments don't have expires_at)
                $this->warn("  Unexpected: Payment with expires_at but has accepted payments");
            }

            Log::info('Expired first payment processed by scheduler', [
                'payment_id' => $payment->id,
                'booking_id' => $booking->id,
            ]);
        }

        $this->info('Expired payments processed successfully.');
        return Command::SUCCESS;
    }
}
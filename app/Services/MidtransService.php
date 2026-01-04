<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $snapUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->clientKey = config('services.midtrans.client_key');
        $this->isProduction = config('services.midtrans.is_production', false);
        
        $this->snapUrl = $this->isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        Log::info('Midtrans Service Initialized', [
            'serverKey_length' => strlen($this->serverKey ?? ''),
            'clientKey_length' => strlen($this->clientKey ?? ''),
            'isProduction' => $this->isProduction,
            'snapUrl' => $this->snapUrl,
        ]);

        if (empty($this->serverKey)) {
            Log::error('Midtrans server key is empty');
        }
        if (empty($this->clientKey)) {
            Log::error('Midtrans client key is empty');
        }
    }

    /**
     * Create snap token for payment using cURL
     */
    public function createSnapToken(Payment $payment): string
    {
        try {
            Log::info('=== Starting Snap Token Creation ===', [
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
            ]);

            if (empty($this->serverKey) || empty($this->clientKey)) {
                throw new \Exception('Midtrans API keys are not configured. Please check your .env file.');
            }

            $booking = $payment->booking;
            
            if (!$booking) {
                Log::error('Booking not found', ['payment_id' => $payment->id]);
                throw new \Exception('Booking not found for payment');
            }
            
            $user = $booking->user;
            $room = $booking->room;

            if (!$user) {
                Log::error('User not found', ['booking_id' => $booking->id]);
                throw new \Exception('User not found');
            }

            if (!$room) {
                Log::error('Room not found', ['booking_id' => $booking->id]);
                throw new \Exception('Room not found');
            }

            $amount = (int) abs($payment->amount);
            
            if ($amount <= 0) {
                Log::error('Invalid payment amount', ['amount' => $amount]);
                throw new \Exception('Invalid payment amount');
            }

            $orderId = 'PAY-' . $payment->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $amount,
                ],
                'customer_details' => [
                    'first_name' => $user->first_name ?? 'Guest',
                    'last_name' => $user->last_name ?? '',
                    'email' => $user->email ?? 'guest@example.com',
                    'phone' => $user->phone_number ?? '08123456789',
                ],
                'item_details' => [
                    [
                        'id' => 'ROOM-' . $room->id,
                        'price' => $amount,
                        'quantity' => 1,
                        'name' => 'Room ' . $room->room_number . ' - ' . $payment->payment_for_month,
                    ],
                ],
                'callbacks' => [
                    'finish' => url('/payment/finish/callback?order_id=' . $orderId),
                ],
            ];

            // Check if this is the first payment (no accepted payments yet)
            $isFirstPayment = Payment::where('booking_id', $booking->id)
                ->where('status', 'accepted')
                ->count() === 0;

            // Only set expiry for first payment
            if ($isFirstPayment) {
                $params['expiry'] = [
                    'unit' => 'hours',
                    'duration' => 24,
                ];
                
                // Set expires_at on payment record
                if (!$payment->expires_at) {
                    $payment->update(['expires_at' => now()->addHours(24)]);
                }
            } else {
                // Remove expires_at for recurring payments
                if ($payment->expires_at) {
                    $payment->update(['expires_at' => null]);
                }
            }

            Log::info('Snap Token Request Parameters', [
                'order_id' => $orderId,
                'amount' => $amount,
                'customer_email' => $user->email,
                'callback_url' => $params['callbacks']['finish'],
                'is_first_payment' => $isFirstPayment,
                'has_expiry' => isset($params['expiry']),
            ]);

            $ch = curl_init();
            
            $authHeader = 'Authorization: Basic ' . base64_encode($this->serverKey . ':');

            curl_setopt_array($ch, [
                CURLOPT_URL => $this->snapUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($params),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    $authHeader,
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            Log::info('Midtrans API Response', [
                'http_code' => $httpCode,
                'curl_error' => $curlError,
                'response_preview' => substr($response, 0, 500),
            ]);

            if ($curlError) {
                Log::error('cURL Error', ['error' => $curlError]);
                throw new \Exception('Failed to connect to Midtrans: ' . $curlError);
            }

            if ($httpCode === 0) {
                Log::error('No HTTP response received');
                throw new \Exception('Could not connect to Midtrans API. Please check your internet connection.');
            }

            $responseData = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error', [
                    'error' => json_last_error_msg(),
                    'response' => $response,
                ]);
                throw new \Exception('Invalid response from Midtrans API');
            }

            if ($httpCode !== 201) {
                $errorMsg = $responseData['error_messages'][0] ?? 
                           $responseData['status_message'] ?? 
                           'Unknown error from Midtrans';
                
                Log::error('Midtrans API Error', [
                    'http_code' => $httpCode,
                    'error_message' => $errorMsg,
                    'full_response' => $responseData,
                ]);
                
                throw new \Exception('Midtrans API Error: ' . $errorMsg);
            }

            if (empty($responseData['token'])) {
                Log::error('No token in response', ['response' => $responseData]);
                throw new \Exception('Midtrans did not return a payment token');
            }

            // Store order_id
            $payment->update(['midtrans_order_id' => $orderId]);

            Log::info('✓ Snap Token Created Successfully', [
                'order_id' => $orderId,
                'token_preview' => substr($responseData['token'], 0, 20) . '...',
                'is_first_payment' => $isFirstPayment,
                'expires_at' => $payment->expires_at ? $payment->expires_at->format('Y-m-d H:i:s') : 'No expiration',
            ]);

            return $responseData['token'];

        } catch (\Exception $e) {
            Log::error('=== Snap Token Creation Failed ===', [
                'payment_id' => $payment->id ?? null,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
            ]);

            throw new \Exception('Failed to create payment token: ' . $e->getMessage());
        }
    }

    /**
     * Get transaction status from Midtrans
     */
    public function getTransactionStatus(string $orderId): ?array
    {
        try {
            $statusUrl = $this->isProduction
                ? "https://api.midtrans.com/v2/{$orderId}/status"
                : "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

            Log::info('Getting transaction status', [
                'order_id' => $orderId,
                'url' => $statusUrl,
            ]);

            $ch = curl_init();
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $statusUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Authorization: Basic ' . base64_encode($this->serverKey . ':'),
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            Log::info('Transaction status response', [
                'http_code' => $httpCode,
                'response' => $response,
            ]);

            return json_decode($response, true);
        } catch (\Exception $e) {
            Log::error('Transaction Status Error', [
                'order_id' => $orderId,
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Verify webhook notification signature
     */
    public function verifySignature(array $notification): bool
    {
        $orderId = $notification['order_id'] ?? '';
        $statusCode = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';
        $signature = $notification['signature_key'] ?? '';

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        $isValid = $signature === $expectedSignature;

        Log::info('Signature verification', [
            'is_valid' => $isValid,
            'order_id' => $orderId,
        ]);

        return $isValid;
    }

    /**
     * Get client key for frontend
     */
    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * Get snap JS URL
     */
    public function getSnapJsUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }
}
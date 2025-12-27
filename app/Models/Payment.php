<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $id
 * @property int $booking_id
 * @property int $amount
 * @property string $payment_for_month
 * @property int $monthly_rent
 * @property int $late_fee
 * @property Carbon $paid_at
 * @property string $status
 * @property string|null $midtrans_order_id
 * @property string|null $payment_type
 * @property array|null $midtrans_response
 * @property Carbon|null $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking $booking
 *
 * @package App\Models
 */
class Payment extends Model
{
    protected $table = 'payments';

    protected $casts = [
        'booking_id' => 'int',
        'amount' => 'int',
        'monthly_rent' => 'int',
        'late_fee' => 'int',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'midtrans_response' => 'array',
    ];

    protected $fillable = [
        'booking_id',
        'amount',
        'payment_for_month',
        'monthly_rent',
        'late_fee',
        'paid_at',
        'proof',
        'status',
        'midtrans_order_id',
        'payment_type',
        'midtrans_response',
        'expires_at',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Check if payment has expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast() && $this->status === 'pending';
    }

    /**
     * Scope to get expired payments
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'pending')
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '<', now());
    }
}

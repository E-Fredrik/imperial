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
        'paid_at' => 'datetime'
    ];

    protected $fillable = [
        'booking_id',
        'amount',
        'payment_for_month',
        'monthly_rent',
        'late_fee',
        'paid_at',
		'proof',
        'status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

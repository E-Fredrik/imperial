<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 * 
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property Carbon $move_in_date
 * @property Carbon|null $move_out_date
 * @property int $monthly_rent
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Room $room
 * @property User $user
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Booking extends Model
{
	protected $table = 'bookings';

	protected $casts = [
		'user_id' => 'int',
		'room_id' => 'int',
		'move_in_date' => 'datetime',
		'move_out_date' => 'datetime',
		'monthly_rent' => 'int'
	];

	protected $fillable = [
		'user_id',
		'room_id',
		'move_in_date',
		'move_out_date',
		'monthly_rent',
		'status'
	];

	public function room()
	{
		return $this->belongsTo(Room::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}
}

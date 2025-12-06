<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 * 
 * @property int $id
 * @property string $room_number
 * @property int $price
 * @property int $length
 * @property int $width
 * @property string $type
 * @property int $floor
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Booking[] $bookings
 * @property Collection|RoomsFacility[] $rooms_facilities
 * @property Collection|Image[] $images
 *
 * @package App\Models
 */
class Room extends Model
{
	protected $table = 'rooms';

	protected $casts = [
		'price' => 'int',
		'length' => 'int',
		'width' => 'int',
		'floor' => 'int'
	];

	protected $fillable = [
		'room_number',
		'price',
		'length',
		'width',
		'type',
		'floor',
		'status'
	];

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	public function rooms_facilities()
	{
		return $this->hasMany(RoomsFacility::class);
	}

	public function rooms_images()
	{
		return $this->hasMany(RoomsImage::class, 'room_id');
	}
}

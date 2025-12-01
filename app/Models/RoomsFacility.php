<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomsFacility
 * 
 * @property int $id
 * @property int $facility_id
 * @property int $room_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property RoomFacility $room_facility
 * @property Room $room
 *
 * @package App\Models
 */
class RoomsFacility extends Model
{
	protected $table = 'rooms_facilities';

	protected $casts = [
		'facility_id' => 'int',
		'room_id' => 'int'
	];

	protected $fillable = [
		'facility_id',
		'room_id'
	];

	public function room_facility()
	{
		return $this->belongsTo(RoomFacility::class, 'facility_id');
	}

	public function room()
	{
		return $this->belongsTo(Room::class);
	}
}

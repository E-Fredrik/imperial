<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomsImage
 * 
 * @property int $id
 * @property int $room_id
 * @property int $image_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 * @property Room $room
 *
 * @package App\Models
 */
class RoomsImage extends Model
{
	protected $table = 'rooms_images';

	protected $casts = [
		'room_id' => 'int',
		'image_id' => 'int'
	];

	protected $fillable = [
		'room_id',
		'image_id'
	];

	public function image()
	{
		return $this->belongsTo(Image::class);
	}

	public function room()
	{
		return $this->belongsTo(Room::class);
	}
}

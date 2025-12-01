<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * 
 * @property int $id
 * @property string $image_path
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|FacilitiesImage[] $facilities_images
 * @property Collection|Room[] $rooms
 *
 * @package App\Models
 */
class Image extends Model
{
	protected $table = 'images';

	protected $fillable = [
		'image_path',
		'description'
	];

	public function facilities_images()
	{
		return $this->hasMany(FacilitiesImage::class);
	}

	public function rooms()
	{
		return $this->belongsToMany(Room::class, 'rooms_images')
					->withPivot('id')
					->withTimestamps();
	}
}

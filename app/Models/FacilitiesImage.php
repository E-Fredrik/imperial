<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FacilitiesImage
 * 
 * @property int $id
 * @property int $facility_id
 * @property int $image_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property KostFacility $kost_facility
 * @property Image $image
 *
 * @package App\Models
 */
class FacilitiesImage extends Model
{
	protected $table = 'facilities_images';

	protected $casts = [
		'facility_id' => 'int',
		'image_id' => 'int'
	];

	protected $fillable = [
		'facility_id',
		'image_id'
	];

	public function kost_facility()
	{
		return $this->belongsTo(KostFacility::class, 'facility_id');
	}

	public function image()
	{
		return $this->belongsTo(Image::class);
	}
}

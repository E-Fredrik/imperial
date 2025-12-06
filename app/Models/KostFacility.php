<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\FacilitiesImage;
use App\Models\Image;

/**
 * Class KostFacility
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|FacilitiesImage[] $facilities_images
 *
 * @package App\Models
 */
class KostFacility extends Model
{
	protected $table = 'kost_facilities';

	protected $fillable = [
		'name',
		'description'
	];

	public function facilities_images()
	{
		return $this->hasMany(FacilitiesImage::class, 'facility_id');
	}

}

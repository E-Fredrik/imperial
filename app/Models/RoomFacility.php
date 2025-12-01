<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomFacility
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|RoomsFacility[] $rooms_facilities
 *
 * @package App\Models
 */
class RoomFacility extends Model
{
	protected $table = 'room_facilities';

	protected $fillable = [
		'name',
		'description'
	];

	public function rooms_facilities()
	{
		return $this->hasMany(RoomsFacility::class, 'facility_id');
	}
}

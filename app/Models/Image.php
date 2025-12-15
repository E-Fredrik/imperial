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
 * @property bool $is_featured
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
        'description',
        'is_featured',
    ];

    // append computed public URL so it's included in JSON/arrays
    protected $appends = ['public_url'];

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

    // returns an absolute URL to use in views/JS
    public function getPublicUrlAttribute()
    {
        $path = $this->image_path ?? '';

        if ($path === '') {
            return '';
        }

        $publicCandidate = public_path($path);

        if (file_exists($publicCandidate)) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}

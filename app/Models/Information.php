<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

/**
 * Class Information
 * 
 * @property int $id
 * @property string $title
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Information extends Model
{
	use HasRichText;
	protected $table = 'informations';

	protected $richTextAttributes = [
        'content',
    ];

	protected $fillable = [
		'title',
		'content'
	];
}

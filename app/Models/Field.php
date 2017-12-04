<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Field
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $variable_name
 * @property string|null $aspect_ratio
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $video_id
 * @property-read \App\Models\Video|null $video
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereAspectRatio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereVariableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Field whereVideoId($value)
 * @mixin \Eloquent
 */
class Field extends Model
{
    protected $fillable = [
        'video_id',
        'name',
        'variable_name',
        'aspect_ratio',
        'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

}

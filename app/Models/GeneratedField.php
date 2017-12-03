<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeneratedField
 *
 * @property int $id
 * @property int|null $generated_id
 * @property string $name
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\VideoGenerated|null $videoGenerated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeneratedField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeneratedField whereGeneratedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeneratedField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeneratedField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeneratedField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GeneratedField whereValue($value)
 * @mixin \Eloquent
 */
class GeneratedField extends Model
{
    public function videoGenerated()
    {
        return $this->belongsTo(VideoGenerated::class, 'generated_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * App\Models\VideoGenerated
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $video_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $impossible_id
 * @property string|null $slug
 * @property string|null $hash
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GeneratedField[] $generatedFields
 * @property-read string $video_url
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Video|null $video
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereImpossibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoGenerated whereVideoId($value)
 * @mixin \Eloquent
 */
class VideoGenerated extends Model
{
    use Sluggable;

    protected $table = 'videos_generated';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['user.first_name', 'video.name']
            ]
        ];
    }

    protected $fillable = [
        'user_id',
        'video_id',
        'impossible_id',
        'hash'
    ];

    protected $dates = [
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function generatedFields()
    {
        return $this->hasMany(GeneratedField::class, 'generated_id');
    }

    /**
     * @return string
     */
    public function getVideoUrlAttribute()
    {
        return "https://render-eu-west-1.impossible.io/v2/render/".$this->impossible_id.".mp4";
    }
}

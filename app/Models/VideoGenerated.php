<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

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
        return "http://api.impossible.io/v2/render/".$this->impossible_id.".mp4";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGenerated extends Model
{
    protected $table = 'videos_generated';

    protected $fillable = [
        'user_id',
        'video_id',
        'impossible_id'
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
}

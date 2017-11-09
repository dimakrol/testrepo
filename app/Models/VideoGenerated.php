<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGenerated extends Model
{
    protected $table = 'videos_generated';

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}

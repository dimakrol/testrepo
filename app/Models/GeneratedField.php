<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedField extends Model
{
    public function videoGenerated()
    {
        return $this->belongsTo(VideoGenerated::class, 'generated_id');
    }
}

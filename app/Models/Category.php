<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'seo_title',
        'seo_description'
    ];
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function videos()
//    {
//        return $this->hasMany(Video::class);
//    }
}

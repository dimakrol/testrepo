<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name',
        'premium',
        'category_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function upload(Video $video, $videoFile, $categoryName)
    {
        $filename = time().str_random(10).'.'.$videoFile->extension();
        $filePath = 'public'. DIRECTORY_SEPARATOR .'videos' . DIRECTORY_SEPARATOR . $categoryName;
        $storagePath = $videoFile->storeAs($filePath, $filename);

        $video->preview_url = $storagePath;
        $video->thumbnail_url = $storagePath;
        $video->local_url = $storagePath;
        $video->impossible_video_id = 1;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Upload video to server, set url parameters to fields
     * @param $videoFile
     * @param $categoryName
     */
    public function upload($videoFile, $categoryName)
    {
        $filename = time().str_random(10).'.'.$videoFile->extension();
        $filePath = 'public'. DIRECTORY_SEPARATOR .'videos' . DIRECTORY_SEPARATOR . $categoryName;
        $videoFile->storeAs($filePath, $filename);

        $storagePath = 'videos' . DIRECTORY_SEPARATOR . $categoryName . DIRECTORY_SEPARATOR . $filename;
        $this->preview_url = $storagePath;
        $this->thumbnail_url = $storagePath;
        $this->local_url = $storagePath;
        $this->impossible_video_id = 1;
    }

    /**
     * Destroy video file from storage
     */
    public function destroyFile()
    {
        return Storage::delete('public/'.$this->local_url);
    }
}

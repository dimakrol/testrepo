<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    protected $fillable = [
        'name',
        'premium',
        'category_id',
        'impossible_video_id'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    /**
     * Upload video to server, set url parameters to fields
     * @param $videoFile
     */
    public function upload($videoFile)
    {
        $filename = time().str_random(10).'.'.$videoFile->extension();
        $filePath = 'public'. DIRECTORY_SEPARATOR .'videos';
        $videoFile->storeAs($filePath, $filename);

        $storagePath = 'videos' . DIRECTORY_SEPARATOR . $filename;
        $this->preview_url = $storagePath;
        $this->thumbnail_url = $storagePath;
        $this->local_url = $storagePath;
    }

    /**
     * Destroy video file from storage
     */
    public function destroyFile()
    {
        return Storage::delete('public/'.$this->local_url);
    }

    public function uploadImage()
    {
        //todo
    }

    /**
     * Return local url
     * @return string
     */
    public function getLocalUrl()
    {
        return asset('storage/'.$this->local_url);
    }
}

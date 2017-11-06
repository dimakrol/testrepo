<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'premium',
        'impossible_video_id'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * return creator of video
     *
     * @return Model|null|static
     */
    public function creator()
    {
        return $this->user()->first();
    }

    /**
     * Upload video to server, set url parameters to fields
     * @param $videoFile
     */
    public function upload($videoFile)
    {
        $filename = 'videos'.DIRECTORY_SEPARATOR.time().str_random(10).'.'.$videoFile->extension();
        $s3 = Storage::disk('s3');
        $s3->put($filename, file_get_contents($videoFile), 'public');

        $storagePath = $s3->url($filename);
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

    /**
     * Upload image and return video url
     *
     * @param $data
     * @return string
     */
    public static function uploadImage($data)
    {
        list($type, $data) = explode(';', $data);

        list(, $data)      = explode(',', $data);
        list(,$extension) = explode('/', $type);

        $imageName = time().str_random(10).'.'.$extension;

        $imageContent = base64_decode($data);
        $path = 'images'.DIRECTORY_SEPARATOR.$imageName;
        $s3 = Storage::disk('s3');
        $s3->put($path, $imageContent, 'public');

        return $s3->url($path);
    }

    /**
     * Return local url
     * @return string
     */
    public function getLocalUrl()
    {
        return asset('storage'.DIRECTORY_SEPARATOR.$this->local_url);
    }
}

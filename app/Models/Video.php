<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class Video extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'premium',
        'impossible_video_id',
        'user_id'
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

    public function videosGenerated()
    {
        return $this->hasMany(VideoGenerated::class, 'video_id');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
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

        $this->preview_url = $filename;
        $this->local_url = $filename;
    }

    public function getVideoUrl()
    {
        return Storage::disk('s3')->url($this->local_url);
    }
    /**
     * Destroy video file from storage
     */
    public function destroyFile()
    {
        return Storage::disk('s3')->delete($this->local_url);
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



    public function uploadThumbnail($imageFile)
    {
        $imageName = time().str_random(10).'.'.$imageFile->extension();

        $imageContent = Image::make($imageFile->getRealPath())
            ->resize(720, 405, function ($constraint) {
                $constraint->aspectRatio();
            })->stream()
            ->__toString();

        $path = 'thumbnails'.DIRECTORY_SEPARATOR.$imageName;
        $s3 = Storage::disk('s3');
        $s3->put($path, $imageContent, 'public');

        $this->thumbnail_url = $path;
    }

    public function getThumbnail()
    {
        return Storage::disk('s3')->url($this->thumbnail_url);
    }
    
    public function getThumbnailPathAttribute()
    {
        if ($this->thumbnail_url) {
            return Storage::disk('s3')->url("{$this->thumbnail_url}");
        }
        return '';
    }

    public function destroyThumbnail()
    {
        return Storage::disk('s3')->delete($this->thumbnail_url);
    }

}

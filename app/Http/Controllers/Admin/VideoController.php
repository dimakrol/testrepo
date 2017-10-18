<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoRequest;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.video.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.video.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVideoRequest $request
     * @return FurnitureImage
     */
    public function store(StoreVideoRequest $request)
    {
        dd($request->all());
//        try {
            $file =  $request->file('video');

//            $video = new Video
//
//            ]);
//
//            Video::upload($file, $request->name, $request->category_id);
//        } catch (Exception $e) {
//            Log::
//        }

        $path = $request->file('video')->storeAs(
            'avatars', $request->user()->id.'.'.$file->extension()
        );
        dd($path);
        // dd($request->video->extension());
        dd($request->video);
        $contents = File::get($request->video);
        $contents = file_get_contents($request->video);
        //Storage::put('video/1', $contents);
//        $path = $request->photo->store('public/photos');
//        $ext = $request->photo->extension();
//        $image = Image::make(Storage::get($path))->resize(100, 100);
//        $trumb_path = DIRECTORY_SEPARATOR .'trumbnails'.DIRECTORY_SEPARATOR.time().str_random(10).'.'.$ext;
//        $image->save(storage_path('app/public') .$trumb_path);
//
//        $furniture_image = new FurnitureImage();
//        $furniture_image->file_path = str_replace('public', DIRECTORY_SEPARATOR .'storage', $path);
//        $furniture_image->trumbnail_path = DIRECTORY_SEPARATOR .'storage'.$trumb_path;
//        if ($item_id) {
//            $furniture_image->furniture_item_id = $item_id;
//        }
//        if ($furniture_image->save()) {
//            return $furniture_image;
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

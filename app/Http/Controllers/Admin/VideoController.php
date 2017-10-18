<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVideoRequest $request
     * @return FurnitureImage
     */
    public function store(StoreVideoRequest $request)
    {

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

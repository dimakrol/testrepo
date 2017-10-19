<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoRequest;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::paginate(20);
        return view('admin.video.index', compact('videos'));
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
        $category = Category::findOrFail($request->input('category_id'));

        $video = new Video([
            'name' => $request->input('name'),
            'premium' => $request->input('premium') ? true : false,
            'category_id' => $category->id,
        ]);

        try {
            $video->upload($request->file('video'), $category->name);
            Auth::user()->videos()->save($video);
        } catch (\PDOException $e) {
            Log::error('Error while creating video: '. $e->getMessage());
            flash('Error while creating video!')->error();
            return back();
        } catch (\Exception $e) {
            Log::error('Error while uploading video file: '. $e->getMessage());
            flash('Error while creating uploading video!')->error();
            return back();
        }

        flash('Video created successful!')->success();
        return redirect()->route('admin.video.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $categories = Category::pluck('name', 'id');

        return view('admin.video.edit', compact('video', 'categories'));
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
        $video = Video::findOrFail($id);

        if (!$video->destroyFile()) {
            Log::error('Error while deletion video: ');
            flash('Error while deletion video!')->error();
            return back();
        }
        try {
            $video->delete();
        } catch (\PDOException $e) {
            Log::error('Error while deletion video with id: '. $video->id.' '. $e->getMessage());
            flash('Error while deletion video!')->error();
            return back();
        }

        flash('File deleted successful!')->success();
        return redirect()->route('admin.video.index');
    }
}

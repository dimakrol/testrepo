<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoRequest;

use App\Http\Requests\Admin\UpdateVideoRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Video;
use foo\bar;
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
        $videos = Video::with('fields')->paginate(20);
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
        $tags = Tag::pluck('name', 'id');
        return view('admin.video.create', compact('categories', 'tags'));
    }

    /**
     * @param StoreVideoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVideoRequest $request)
    {
        $video = new Video([
            'name' => $request->input('name'),
            'impossible_video_id' => $request->input('impossible_video_id'),
            'premium' => $request->input('premium') ? true : false,
            'category_id' => $request->input('category_id'),
        ]);

        try {
            $video->upload($request->file('video'));
            Auth::user()->videos()->save($video);
            $video->tags()->sync($request->tags);
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
     * @param UpdateVideoRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVideoRequest $request, $id)
    {
        $video = Video::findOrFail($id);
            $data =  $request->except('premium');
        $data['premium'] = $request->input('premium') ? true : false;
        $video->fill($data);
        if ($request->file('video')) {
            if (!$video->destroyFile()) {
                Log::error('Video file was not delete, path: '. '"public/'.$video->local_url.'"');
            }
            try {
                $video->upload($data['video']);
            } catch (\Exception $e) {
                Log::error('Error while uploading video file: '. $e->getMessage());
                flash('Error while uploading video!')->error();
                return back();
            }
        }
        try {
            $video->save();
        } catch (\PDOException $e) {
            Log::error('Error while updating video with id: ' .$video->id.' error:'. $e->getMessage());
            flash('Error while updating video!')->error();
            return back();
        }
        flash('Video updated successful!')->success();
        return redirect()->route('admin.video.index');
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

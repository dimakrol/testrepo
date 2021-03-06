<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoRequest;

use App\Http\Requests\Admin\UpdateVideoRequest;
use App\Models\Category;
use App\Models\Playlist;
use App\Models\Tag;
use App\Models\User;
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
        $videos = Video::with(['fields','user'])->latest()->paginate(20);
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
        $creators = User::whereIn('role', ['creator', 'admin'])->pluck('first_name', 'id');
        $tags = Tag::pluck('name', 'id');
        $playlists = Playlist::pluck('name', 'id');
        return view('admin.video.create', compact('categories', 'tags', 'creators', 'playlists'));
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
            'user_id' => $request->input('user_id'),
            'premium' => $request->input('premium') ? true : false,
        ]);

        try {
            $video->upload($request->file('video'));
            $video->uploadThumbnail($request->file('image'));
            $video->save();
            $video->tags()->sync($request->tags);
            $video->categories()->sync($request->categories);
            $video->playlists()->sync($request->playlists);
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
        $creators = User::whereIn('role', ['creator', 'admin'])->pluck('first_name', 'id');
        $playlists = Playlist::pluck('name', 'id');

        $tags = Tag::pluck('name', 'id');

        return view('admin.video.edit', compact('video', 'categories', 'tags', 'creators', 'playlists'));
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
                Log::error('Video file was not delete, path: '. $video->local_url.'"');
            }
            try {
                $video->upload($data['video']);
            } catch (\Exception $e) {
                Log::error('Error while uploading video file: '. $e->getMessage());
                flash('Error while uploading video!')->error();
                return back();
            }
        }

        if ($request->file('image')) {
            if (!$video->destroyThumbnail()) {
                Log::error('Thumbnail has not been deleted, path: '. $video->thumbnail_url.'"');
            }
            try {
                $video->uploadThumbnail($data['image']);
            } catch (\Exception $e) {
                Log::error('Error while uploading thumbnail file: '. $e->getMessage());
                flash('Error while uploading thumbnail!')->error();
                return back();
            }
        }
        try {
            $video->save();
            if (isset($request->tags)) {
                $video->tags()->sync($request->tags);
            } else {
                $video->tags()->sync([]);
            }
            if (isset($request->categories)) {
                $video->categories()->sync($request->categories);
            } else {
                $video->categories()->sync([]);
            }
            if (isset($request->playlists)) {
                $video->playlists()->sync($request->playlists);
            } else {
                $video->playlists()->sync([]);
            }
        } catch (\PDOException $e) {
            Log::error('Error while updating video with id: ' .$video->id.' error:'. $e->getMessage());
            flash('Error while updating video!')->error();
            return back();
        }
        flash('Video updated successful!')->success();
        return redirect()->route('admin.video.index');
    }

//    /**
//     * @param $id
//     * @return \Illuminate\Http\RedirectResponse
//     * @throws \Exception
//     */
//    public function destroy($id)
//    {
//        $video = Video::findOrFail($id);
//
//        try {
//            $video->destroyFile();
//            $video->destroyThumbnail();
//            $video->delete();
//        } catch (\PDOException $e) {
//            Log::error('Error while deletion video with id: '. $video->id.' '. $e->getMessage());
//            flash('Error while deletion video!')->error();
//            return back();
//        }
//
//        flash('File deleted successful!')->success();
//        return redirect()->route('admin.video.index');
//    }
}

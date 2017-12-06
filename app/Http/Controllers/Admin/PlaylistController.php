<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PlaylistController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $playlists = Playlist::ordered()->get();
        return view('admin.playlist.create', compact('playlists'));
    }


    public function changeOrder(Request $request)
    {
        Playlist::setNewOrder($request->item);
        return response()->json('success');
    }

    public function changeOrderOfVideos($id)
    {
        $categories = Category::pluck('name', 'id');
        $playlist = Playlist::findOrFail($id);
        $videos = $playlist->videos()->orderBy('playlist_video.order', 'asc')->get();
        return view('admin.playlist.video-order', compact('playlist', 'videos', 'categories'));
    }

    public function changeDisplay($id, Request $request)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->update(['display' => (int)$request->display]);
        return response()->json('success');
    }

    public function changeLink($id, Request $request)
    {
        $playlist = Playlist::find($id);
        $playlist->update(['link'=> $request->link_id]);
        return response()->json('success');
    }

    public function updateOrderOfVideos(Request $request, $id)
    {

        $playlist = Playlist::findOrFail($id);
        $countOfVideos = $playlist->videos()->count();
        $playlist->videos()->detach();

        for ($i = 1; $i < $countOfVideos+1; $i++) {
            $playlist->videos()->attach($request->item[$i-1], ['order' => $i]);
        }
        return response()->json('success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:playlists'
        ]);

        try {
            Playlist::create($request->all());
        } catch (\PDOException $e) {
            flash('Error while creating playlist!')->error();
            return back();
        }
        flash('Playlist created successfully!')->success();
        return redirect()->route('admin.playlist.create');
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

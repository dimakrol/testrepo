<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = Playlist::with(['videos' => function($q) {
            $q->with('categories:id,name')->orderBy('playlist_video.order', 'asc')->get();
        }])->where('display', true)->orderBy('playlists.order', 'asc')->get();
        return view('index', compact('playlists'));
    }

    public function ampIndex()
    {
        $playlists = Playlist::with(['videos' => function($q) {
            $q->orderBy('playlist_video.order', 'asc')->get();
        }])->where('display', true)->orderBy('playlists.order', 'asc')->get();

        $videos = Video::with('user')->latest()->take(9)->get();
        return view('amp.index', compact('videos', 'playlists'));
    }
}

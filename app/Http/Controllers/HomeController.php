<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = Playlist::with(['videos' => function($q) {
            $q->orderBy('playlist_video.order', 'asc')->get();
        }])->orderBy('playlists.order', 'asc')->get();
       // dd($playlists);
        $videos = Video::with('user')->latest()->take(9)->get();
        return view('index', compact('videos', 'playlists'));
    }

    public function play()
    {
        $PROJECT_ID = "b8533acd-23ac-487d-9d46-cbc143ee06f9";

        $MOVIE_NAME = 'HappyBirthdayLegend';

        $params = array('image_1' => 'http://wwdv2-dimakrol.c9users.io/storage/images/bog.jpg');


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, 'http://api.impossible.io/v2/render/'.$PROJECT_ID);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $data = array(
            'movie' => $MOVIE_NAME,
            'params' => $params
        );

        Log::debug('Movie name: '. $MOVIE_NAME);
        Log::debug('Params: '. 'http://wwdv2-dimakrol.c9users.io/storage/images/bog.jpg');

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result=curl_exec($ch);
        Log::debug('Result: '. $result);

        $token = json_decode($result)->{'token'};
        Log::debug('Tokenok: '. $token);
        $name = "http://api.impossible.io/v2/render/".$token.".mp4";
        Log::debug('Url video: '. $name);


        // WORKING!

        // open the file in a binary mode if it's not iOS.
        $fp = fopen($name, 'rb');

        // send the right headers
        header("Content-Type: video/mp4");
//        header("Content-Length: " . filesize($name));

        // dump the picture and stop the script
        fpassthru($fp);
        exit;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoGenerated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Auth;

class VideoController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $video = Video::with(['fields', 'user'])->whereSlug($slug)->firstOrFail();
        return view('frontend.video.show', compact('video'));
    }

    public function channel($slug)
    {
        // Get post for slug.
        $user = User::with(['videos' => function($q) {
            $q->latest();
        }])->whereSlug($slug)->firstOrFail();
        return view('frontend.video.channel', compact('user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        //todo check if user has subscription
        if (!Auth::user()) {
            return 'not work';
        }

        $video = Video::with('fields')->findOrFail($request->id);

        $params = [];

        foreach ($video->fields as $field) {
            if ($request->input($field->variable_name)) {
                //Log::debug('input name:'.$field->variable_name);
                $fileUrl = '';
                try {
                    $fileUrl = Video::uploadImage($request->input($field->variable_name));
                    //Log::debug('File input path: '.$fileUrl);
                } catch (\Exception $e) {
                    Log::error('Error while uploading image file: '. $e->getMessage());
                }
                $params[$field->variable_name] = $fileUrl;
            }
        }

        $PROJECT_ID = getenv('IMPOSSIBLE_PROJECT_ID');
        $movieName = $video->impossible_video_id;

        //Log::debug('Impossible video id: '. $movieName);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, 'http://api.impossible.io/v2/render/'.$PROJECT_ID);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $data = [
            'movie' => $movieName,
            'params' => $params
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);

        //Log::debug('Result: '. $result);

        $token = json_decode($result)->{'token'};

        try {
            $video->videosGenerated()->create([
                'user_id' => Auth::user()->id,
                'impossible_id' => $token
            ]);
        } catch (\Exception $e) {
            Log::error('Error while generation video: '.$video->id.'for user: '.Auth::user()->id);
        }

        //Log::debug('Token: '. $token);

        $videoUrl = "http://api.impossible.io/v2/render/".$token.".mp4";

        //Log::debug('Video Url: '. $videoUrl);

        return response()->json(['videoUrl' => $videoUrl, 'videoId' => $video->id]);
    }
}

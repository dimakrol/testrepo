<?php

namespace App\Http\Controllers;

use App\Models\Plan;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generatedVideos()
    {
        if (!Auth::user()->subscribed(['yearly', 'yearlyuk'])) {
            return redirect(route('home'));
        }
        $gVideos = Auth::user()->videosGenerated()->latest()->with('video')->paginate(20);
        return view('video.my-videos', compact('gVideos'));
    }


    public function generatedVideoByHash($hash)
    {
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $gVideo = VideoGenerated::with(['video'])->whereHash($hash)->firstOrFail();
        $videos = Video::inRandomOrder()->whereNotIn('id', [$gVideo->video_id])->limit(4)->get();
        return view('video.view', compact('gVideo', 'videos', 'iPhone', 'iPod'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $video = Video::with(['fields', 'user'])->whereSlug($slug)->firstOrFail();
        $videos = Video::inRandomOrder()->whereNotIn('id', [$video->id])->limit(4)->get();

        return view('video.show', compact('video', 'videos'));
    }

    public function makePreview()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($generatedUrl = session()->get('lust-generated-url')) {
            $originalVideo = Video::findOrFail(session()->get('original-video-id'));
            return view('video.preview', compact('generatedUrl', 'originalVideo'));
        }
        return redirect()->route('home');
    }

    public function channel($slug)
    {
        $user = User::with(['videos' => function($q) {
            $q->latest();
        }])->whereSlug($slug)->firstOrFail();
        return view('video.channel', compact('user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        if (!Auth::check()) {
            return response()->json('error');
        }

        $video = Video::with('fields')->findOrFail($request->id);

        $params = [];

        foreach ($video->fields as $field) {
            if ($request->input($field->variable_name)) {
                $fileUrl = '';
                try {
                    $fileUrl = Video::uploadImage($request->input($field->variable_name));
                } catch (\Exception $e) {
                    Log::error('Error while uploading image file: '. $e->getMessage());
                }
                $params[$field->variable_name] = $fileUrl;
            }
        }

        $PROJECT_ID = getenv('IMPOSSIBLE_PROJECT_ID');
        $movieName = $video->impossible_video_id;

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

        $token = json_decode($result)->{'token'};

        $gVideo = null;

        $videoUrl = "https://render-eu-west-1.impossible.io/v2/render/".$token.".mp4";

        $response = [
            'videoUrl' => $videoUrl,
            'videoId' => $video->id,
        ];

        session()->put('lust-generated-url', $videoUrl);
        session()->put('original-video-id', $video->id);
        flash('Video created successfully!')->success();

        if (!Auth::user()->subscribed(['yearly', 'yearlyuk'])) {
            $response['redirectUrl'] = route('view.make-preview');
        } else {

            try {
                $hash = str_random(40);
                while (VideoGenerated::where('hash', $hash)->first()) {
                    $hash = str_random(40);
                }

                $gVideo = $video->videosGenerated()->create([
                    'user_id' => Auth::user()->id,
                    'impossible_id' => $token,
                    'hash' => $hash
                ]);
            } catch (\Exception $e) {
                Log::error('Error while creation generated video: '.$video->id.' for user: '.Auth::user()->id);
            }
            $response['redirectUrl'] = route('view', $gVideo->hash);
        }

        return response()->json($response);
    }

    public function download($id)
    {
        if (!$video = VideoGenerated::find($id)){
            return back();
        }

        $filename = time().str_random(10).'.mp4';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        @copy($video->video_url, $tempImage);

        $headers = [
            'Content-Type' => "video/mp4"
        ];

        return response()->download($tempImage, $filename, $headers);
    }
}

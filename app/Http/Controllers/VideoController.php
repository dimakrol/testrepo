<?php

namespace App\Http\Controllers;

use App\Mail\ShareVideoEmail;
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
        //todo add protection if owner subscribed.
        list($iPhone, $iPod)  = $this->checkIos();

        $gVideo = VideoGenerated::with(['video'])->whereHash($hash)->firstOrFail();
        $videos = Video::inRandomOrder()->whereNotIn('id', [$gVideo->video_id])->limit(3)->get();
        return view('video.view', compact('gVideo', 'videos', 'iPhone', 'iPod'));
    }

    public function show($slug)
    {
        $video = Video::with(['fields', 'user'])->whereSlug($slug)->firstOrFail();
        $videos = Video::inRandomOrder()->whereNotIn('id', [$video->id])->limit(3)->get();

        return view('video.show', compact('video', 'videos'));
    }

    public function makePreview()
    {
        if ($generatedUrl = session()->get('lust-generated-url')) {
            list($iPhone, $iPod)  = $this->checkIos();

            $originalVideo = Video::findOrFail(session()->get('original-video-id'));
            return view('video.preview', compact(
                'generatedUrl', 'originalVideo', 'iPhone', 'iPod'));
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

    public function generate(Request $request)
    {
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

        //
        session()->put('lust-generated-url', $videoUrl);
        session()->put('original-video-id', $video->id);
        flash('Video created successfully!')->success();

        try {
            $hash = str_random(40);
            while (VideoGenerated::where('hash', $hash)->first()) {
                $hash = str_random(40);
            }

            $gVideoData = [
                'impossible_id' => $token,
                'hash' => $hash
            ];

            if (Auth::check()) {
                $gVideoData['user_id'] = Auth::user()->id;
            }

            $gVideo = $video->videosGenerated()->create($gVideoData);
        } catch (\Exception $e) {
            Log::error('Error while creation generated video: '.$video->id.' for user: '.Auth::user()->id);
        }

//todo push to session generated videos for not logged in user
        if (!Auth::check()) {
            session()->push('new-user.generated-videos', $gVideo->id);
        }

        //if user not logged in or not subscribed redirect to make-preview page
        //save to session redirect-after-subscribe route
        if (!Auth::check() || !Auth::user()->subscribed(['yearly', 'yearlyuk'])) {
            $response['redirectUrl'] = route('view.make-preview');
            session()->put('redirect-after-subscribe', route('view', $gVideo->hash));
        } else {
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

        Auth::user()->increment('number_of_shares');
        return response()->download($tempImage, $filename, $headers);
    }

    private function checkIos()
    {
        return [
            stripos($_SERVER['HTTP_USER_AGENT'],"iPhone"),
            stripos($_SERVER['HTTP_USER_AGENT'],"iPod")
        ];
    }
}

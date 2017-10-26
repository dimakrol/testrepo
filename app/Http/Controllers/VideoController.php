<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $video = Video::with('fields')->findOrFail($request->id);

        $params = [];

        foreach ($video->fields as $field) {
            if ($request->input($field->variable_name)) {
                Log::debug('input name:'.$field->variable_name);
                $fileUrl = '';
                try {
                    $data = $request->input($field->variable_name);
                    list($type, $data) = explode(';', $data);
                    Log::debug($type);
                    Log::debug('Type: '.$type);
                    list(, $data)      = explode(',', $data);
                    list(,$extension) = explode('/', $type);
                    Log::debug('Extention: '.$extension);
                    $imageName = time().str_random(10).'.'.$extension;
                    Log::debug('Image Name: '.$imageName);
                    $imageContent = base64_decode($data);
                    $path = 'images'.DIRECTORY_SEPARATOR.$imageName;
                    Storage::put('public'.DIRECTORY_SEPARATOR.$path, $imageContent);
                } catch (\Exception $e) {
                    Log::error('Error while uploading image file: '. $e->getMessage());
                }

                Log::debug('Asset: '.asset('storage'.DIRECTORY_SEPARATOR.$path));

                $params[$field->variable_name] = asset('storage'.DIRECTORY_SEPARATOR.$path);
            }
        }


        $PROJECT_ID = "b8533acd-23ac-487d-9d46-cbc143ee06f9";

        $movieName = $video->impossible_video_id;

        Log::debug('Impossible video id: '. $movieName);

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
        Log::debug('Result: '. $result);

        $token = json_decode($result)->{'token'};

        Log::debug('Token: '. $token);

        $videoUrl = "http://api.impossible.io/v2/render/".$token.".mp4";

        Log::debug('Video Url: '. $videoUrl);

        return response()->json(['videoUrl' => $videoUrl, 'videoId' => $video->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::with('fields')->findOrFail($id);
//        dd($video);
        return view('frontend.video.show', compact('video'));
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

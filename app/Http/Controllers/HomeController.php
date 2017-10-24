<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home');
//        $PROJECT_ID = "b8533acd-23ac-487d-9d46-cbc143ee06f9";
//
//        // Generate a unique video id.
//        $u_id = str_random(10);
//        syslog( LOG_INFO, 'UID:' . $u_id );
//        // Insert into video_uploads table.
//        $params = [
//            "image_1" => "https://www.google.com.ua/imgres?imgurl=https%3A%2F%2Fstatic.pexels.com%2Fphotos%2F34950%2Fpexels-photo.jpg&imgrefurl=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fnature%2F&docid=ShwNVOdFBcmkxM&tbnid=GGfksdPIlmy4cM%3A&vet=10ahUKEwjH17jb54jXAhVpIpoKHfrxDKgQMwjgASgBMAE..i&w=5184&h=3456&bih=966&biw=1855&q=images&ved=0ahUKEwjH17jb54jXAhVpIpoKHfrxDKgQMwjgASgBMAE&iact=mrc&uact=8"
//        ];
//
//
//
//        $fields = array( 'u_id' => $u_id );
//
//        //$options = ['gs_bucket_name' => $bucket_videos];
//        //$upload_url = CloudStorageTools::createUploadUrl($base_url . '/video_upload?u_id=' . $u_id, $options);
//
//        $upload_url =  '/video_upload';
//
//        syslog( LOG_INFO, 'Upload URL: ' . $upload_url );
//
//        $data = array(
//            'movie'  => 'HappyBirthdayLegend',
//            'params' => $params,
//            'upload' => array(
//                'extension'   => 'mp4',
//            )
//        );
//
//        $ch = curl_init();
//        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//        curl_setopt( $ch, CURLOPT_POST, true );
//        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
//        curl_setopt( $ch, CURLOPT_URL, 'https://render-eu-west-1.impossible.io/v2/render/b8533acd-23ac-487d-9d46-cbc143ee06f9' );
//        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
//        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $data ) );
//        $result = curl_exec( $ch );
//        return $result;
    }

    public function play()
    {
        $PROJECT_ID = "b8533acd-23ac-487d-9d46-cbc143ee06f9";

        $MOVIE_NAME = 'HappyBirthdayLegend';

        $params = array('image_1' => 'https://images.pexels.com/photos/452782/pexels-photo-452782.jpeg?w=1260&h=750&auto=compress&cs=tinysrgb');


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
        Log::debug('Params: '. 'http://localhost:8000/storage/images/bog.jpg');

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result=curl_exec($ch);
        Log::debug('Result: '. $result);

        $token = json_decode($result)->{'token'};
        Log::debug('Tokenok: '. $token);
        $name = "http://api.impossible.io/v2/render/".$token.".mp4";


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

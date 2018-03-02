<?php

namespace App\Http\Controllers;

use App\Mail\ShareVideoEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class ShareController extends Controller
{

    public function email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required'
        ]);
        
        Mail::to($request->get('email'))
            ->send(new ShareVideoEmail([
                'recipient_name' => $request->get('name'),
                'sender_name' => Auth::user()->first_name,
                'message' => $request->get('message'),
                'video_url' => $request->get('shareLink')
            ]));

        Auth::user()->increment('number_of_shares');
        return response()->json('success');
    }

    public function iterateShare()
    {
        Auth::user()->increment('number_of_shares');
    }
}

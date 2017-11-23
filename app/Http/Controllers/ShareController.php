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

        Mail::to($request->input('email'))
            ->send(new ShareVideoEmail([
                'recipient_name' => $request->input('name'),
                'sender_name' => Auth::user()->first_name,
                'video_url' => $request->input('shareLink')
            ]));
        return response()->json('success');
    }
}

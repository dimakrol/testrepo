<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareController extends Controller
{

    public function email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        return $request->all();
    }
}

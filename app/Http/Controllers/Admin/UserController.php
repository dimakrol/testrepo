<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function videos($id)
    {
        $user = User::with('videos')->findOrFail($id);
        return view('admin.user.videos', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $creators = User::whereNotIn('id', [Auth::user()->id])->whereIn('role', ['admin', 'creator'])->latest()->get();
        return view('admin.user.create', compact('creators'));
    }

    public function login($id)
    {
        $creator = User::findOrFail($id);
        if (in_array($creator->role, ['admin', 'creator'])) {
            Auth::login($creator);
            flash('You success login as '.$creator->first_name)->success();
            return redirect(route('admin.index'));
        }
        flash('Error while login as: '.$creator->first_name)->error();
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5'
        ]);

        if (User::create([
            'first_name' => $request->input('name'),
            'description' => $request->input('description'),
            'role' => 'creator'
        ])) {
            flash('User created successfully!')->success();
            return redirect(route('admin.user.create'));
        }
        flash('Error while creating user!!!')->error();
        return redirect(route('admin.user.create'));
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

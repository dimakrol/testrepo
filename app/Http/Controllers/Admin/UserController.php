<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.user.index',compact('users'));
    }

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
        return view('admin.user.create');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->file('image')) {
            $user->deleteThumbnail();
            $user->uploadThumbnail($request->file('image'));
        }
        $user->fill([
            'first_name' => $request->input('name'),
            'description' => $request->input('description'),
            ]);

        if(!$user->save()) {
            flash('Error while updating user!!!')->error();
            return back();
        }

        flash('User updated successfully!')->success();
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
        $user = User::find($id);

        if ($user->videos()->count()) {
            flash('You can\'t delete user with video!')->warning();
            return back();
        }

        if ($user->delete()) {
            flash('User deleted successfully!')->success();
            return redirect(route('admin.user.index'));
        }
        flash('Error while deleting video!')->error();
        return back();
    }
}

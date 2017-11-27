<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('user-email')) {
            $users = User::whereIn('id',[$request->input('user-email')])->paginate(1);
        } else {
            $users = User::latest()->paginate(20);
        }

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

    public function search(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = User::select("id","email")
                ->where('email','LIKE',"%$search%")
                ->limit(10)
                ->get();
        }

        return response()->json($data);
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

        Auth::login($creator);
        flash('You success login as '.$creator->first_name)->success();
        return redirect(route('admin.index'));
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
            'role' => $request->input('role')
        ])) {
            flash('User created successfully!')->success();
            return redirect(route('admin.user.index'));
        }
        flash('Error while creating user!!!')->error();
        return back();
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
            'role' => $request->input('role')
            ]);

        if(!$user->save()) {
            flash('Error while updating user!!!')->error();
            return back();
        }

        flash('User updated successfully!')->success();
        return redirect(route('admin.user.index'));
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

        if (Auth::user()->id == $id) {
            flash('You can\'t delete yourself!')->error();
            return back();
        }

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

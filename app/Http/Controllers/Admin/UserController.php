<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Form;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $plan = Plan::default();
        if ($request->input('user-email')) {
            $users = User::whereIn('id',[$request->input('user-email')])->paginate(1);
        } else {
            $users = User::latest()->paginate(20);
        }

        return view('admin.user.index',compact('users', 'plan'));
    }

    public function data()
    {
        $query = User::with('subscriptions')->select('users.*');

        return Datatables::of($query)
            ->addColumn('login', function ($user) {
                return '<a href="'.route('admin.user.login', $user->id).'"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>';
            })
            ->addColumn('edit', function ($user) {
                return '<a href="'.route('admin.user.edit', $user->id).'"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> Edit</a>';
            })
            ->addColumn('delete', function ($user) {
                return '<button class="btn btn-danger delete-user" data-user-id="'.$user->id.'">Delete</button>';
//                return Form::open([ 'method'  => 'delete', 'route' => [ 'admin.user.destroy', $user->id ] ]) .
//                     Form::submit('Delete', ['class' => 'btn btn-danger']) .
//                 Form::close();
            })
            ->addColumn('sub_name', function (User $user) {
                return $user->subscriptions->first()['name'];
            })
            ->rawColumns(['edit', 'login', 'delete'])
            ->make(true);

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

        if (Auth::user()->role == 'admin') {
            Auth::login($creator);
            flash('You success login as '.$creator->first_name)->success();
            return redirect(route('admin.index'));
        }

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if (User::create([
            'first_name' => $request->input('name'),
            'email' => $request->input('email'),
            'description' => $request->input('description'),
            'country_code' => $request->input('country_code'),
            'role' => $request->input('role'),
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

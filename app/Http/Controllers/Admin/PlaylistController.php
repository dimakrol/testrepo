<?php

namespace App\Http\Controllers\Admin;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $playlists = Playlist::all();
        return view('admin.playlist.create', compact('playlists'));
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
            'name' => 'required|unique:playlists'
        ]);

        try {
            Playlist::create($request->all());
        } catch (\PDOException $e) {
            flash('Error while creating playlist!')->error();
            return back();
        }
        flash('Playlist created successfully!')->success();
        return redirect()->route('admin.playlist.create');
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

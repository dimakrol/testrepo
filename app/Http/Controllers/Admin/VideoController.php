<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreVideoRequest;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.video.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.video.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVideoRequest $request
     * @return FurnitureImage
     */
    public function store(StoreVideoRequest $request)
    {
        $category = Category::findOrFail($request->input('category_id'));

        $video = new Video([
            'name' => $request->input('name'),
            'premium' => $request->input('premium') ? true : false,
            'category_id' => $category->id,
        ]);

        try {
            $video->upload($video, $request->file('video'), $category->name);
            Auth::user()->videos()->save($video);
        } catch (\PDOException $e) {
            Log::error('Error while creating video: '. $e->getMessage());
            return back()->with('');
        } catch (\Exception $e) {
            Log::error('Error while uploading video file: '. $e->getMessage());
            return back()->with('');
        }

        return redirect(route('admin.video.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

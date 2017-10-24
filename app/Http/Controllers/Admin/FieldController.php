<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateFieldRequest;
use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FieldController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $videos = Video::pluck('name', 'id');
        return view('admin.field.create', compact('videos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFieldRequest $request)
    {
        try {
            Field::create($request->all());
        } catch (\PDOException $e) {
            flash('Error while creating field!')->error();
            return back();
        }
        flash('Field created successful!')->success();
        return redirect()->route('admin.video.index');
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

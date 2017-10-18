@extends('layouts.admin.app')
@section('content')
    <h2>Upload new video</h2>
    <form>
        <div class="form-group">
            <label for="inputName" class="col-form-label">Name:</label>
            <input type="text" class="form-control" id="inputName" placeholder="Name">
        </div>
        <div class="form-group">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox"> Premium
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Select video file</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" accept="video/*">
        </div>
        <div class="form-group" style="display: none">
            <video width="400"
                   poster="https://thumb9.shutterstock.com/display_pic_with_logo/826804/222220798/stock-vector-hand-pushing-virtual-search-bar-on-turquoise-background-internet-concept-222220798.jpg"
                   controls>
                <source width="320" height="240" id="video_here">
                Your browser does not support HTML5 video.
            </video>
            {{--<input type="file" name="file[]" class="file_multi_video" accept="video/*">--}}
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
@endsection
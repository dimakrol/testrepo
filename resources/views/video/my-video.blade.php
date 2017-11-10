@extends('layouts.frontend.app')
@section('content')
    <div class="container">
        <div class="row my-4">
            <div class="offset-lg-2 col-lg-8 col-sm-12 col-xs-12 video-container">
                <h2 class="" align="center"><span class="text-danger">{{$gVideo->video->name}}</span></h2>
                <video poster="{{ $gVideo->video->getThumbnail() }}" preload="auto" class="center" width="100%" controls="">
                    <source src="{{ $gVideo->video_url }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="row">
                    <a href="{{ route('video.download', $gVideo->id) }}" class="btn btn-danger">Download</a>
                </div>
                {{--<div class="row">--}}
                    {{--<div class="col-2">--}}
                        {{--<a href="{{ route('video.show', $video->slug) }}"><img src="{{ $video->user->thumbnail_path }}" class="rounded-circle"></a>--}}
                    {{--</div>--}}
                    {{--<div class="col-10">--}}
                        {{--<h2>{{ $video->name }}</h2>--}}
                        {{--<p>Created by: <a href="{{ route('channel.index', $video->user->slug) }}">{{ $video->creator()->fullName() }}</a></p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            {{--<div class="col-lg-4">--}}
                {{--<div>--}}
                    {{--@if(!Auth::user() || !Auth::user()->subscribed('yearly'))--}}
                        {{--<div class="form-group">--}}
                            {{--<a class="btn btn-success btn-block" href="{{ route('register') }}">Create Video</a>--}}
                        {{--</div>--}}
                    {{--@else--}}
                        {{--@foreach($video->fields as $field)--}}
                            {{--@if('image' == $field->type)--}}
                                {{--<div class="form-group hide-block">--}}
                                    {{--{!! Form::file($field->variable_name, ['class' => 'form-control-file', 'accept' => 'image/*', 'required' => 'required']) !!}--}}
                                {{--</div>--}}
                            {{--@elseif('text' == $field->type)--}}
                            {{--@elseif('text_area' == $field->type)--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                        {{--@foreach($video->fields as $field)--}}
                            {{--@if('image' == $field->type)--}}
                                {{--<div class="form-group">--}}
                                    {{--<button class="btn btn-success btn-block add-photo" data-variable-name="{{$field->variable_name}}">Add Your Photo</button>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                        {{--<div class="form-group">--}}
                            {{--<button class="btn btn-success update-preview btn-block" disabled="true">Update Preview</button>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<button class="btn btn-danger btn-block crop-button hide-block">Crop</button>--}}
                        {{--</div>--}}
                        {{--@foreach($video->fields as $field)--}}
                            {{--@if('image' == $field->type)--}}
                                {{--<div class="text-center preview-image {{$field->variable_name}} hide-block">--}}
                                    {{--<img src="" class="img-fluid" alt="Responsive image">--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}

                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection

@section('script')
@endsection
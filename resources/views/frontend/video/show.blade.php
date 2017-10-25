@extends('layouts.frontend.app')
@section('content')
    <!-- Page Content -->
    <div class="container">
        <!-- Heading Row -->
        <div class="row my-4">
            <div class="col-lg-8 video-container">
                <video data-id="{{ $video->id }}" poster="{{ asset('images/loading_anim.gif') }}" autoplay preload="auto" class="center" width="100%" controls="">
                    <source src="{{ $video->getLocalUrl() }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                {{--<img class="img-fluid rounded" src="http://placehold.it/900x400" alt="">--}}
            </div>
            <!-- /.col-lg-8 -->
            <div class="col-lg-4">
                <h2>{{ $video->name }}</h2>
                {!! Form::token() !!}
                @foreach($video->fields as $field)
                    @if('image' ==$field->type)
                        <div class="form-group">
                            {!! Form::label($field->variable_name, 'Select photo or image') !!}
                            {!! Form::file($field->variable_name, ['class' => 'form-control-file', 'accept' => 'image/*', 'required' => 'required']) !!}
                        </div>
                    @elseif('text' == $field->type)
                    @elseif('text_area' == $field->type)
                    @endif
                @endforeach
                {{--<p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>--}}
                <div class="btn btn-warning update-preview" href="#">Update Preview</div>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

        {{--<!-- Call to Action Well -->--}}
        {{--<div class="card text-white bg-secondary my-4 text-center">--}}
            {{--<div class="card-body">--}}
                {{--<p class="text-white m-0">This call to action card is a great place to showcase some important information or display a clever tagline!</p>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<!-- Content Row -->--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-4 mb-4">--}}
                {{--<div class="card h-100">--}}
                    {{--<div class="card-body">--}}
                        {{--<h2 class="card-title">Card One</h2>--}}
                        {{--<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer">--}}
                        {{--<a href="#" class="btn btn-primary">More Info</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /.col-md-4 -->--}}
            {{--<div class="col-md-4 mb-4">--}}
                {{--<div class="card h-100">--}}
                    {{--<div class="card-body">--}}
                        {{--<h2 class="card-title">Card Two</h2>--}}
                        {{--<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore voluptates quos eligendi labore.</p>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer">--}}
                        {{--<a href="#" class="btn btn-primary">More Info</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /.col-md-4 -->--}}
            {{--<div class="col-md-4 mb-4">--}}
                {{--<div class="card h-100">--}}
                    {{--<div class="card-body">--}}
                        {{--<h2 class="card-title">Card Three</h2>--}}
                        {{--<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer">--}}
                        {{--<a href="#" class="btn btn-primary">More Info</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /.col-md-4 -->--}}

        {{--</div>--}}
        {{--<!-- /.row -->--}}

    </div>
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-6">--}}
                {{--<div class="c-product-gallery">--}}
                    {{--<div id="sticky-anchor" style="height: 0px;"></div>--}}
                    {{--<div id="video_holder" class="c-product-gallery-content">--}}
                        {{--<div id="sticky">--}}
                            {{--<video data-id="1" poster="{{ asset('storage/images/bog.jpg') }}" preload="auto" class="center" width="100%" controls="">--}}
                                {{--<source src="api_video_play" type="video/mp4">--}}
                                {{--Your browser does not support the video tag.--}}
                            {{--</video>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-6">--}}
                {{--<h3 class="c-font-uppercase c-font-bold">Happy Birthday Legend</h3>--}}
                {{--<h4 class="">By Words Wont Do</h4>--}}
                {{--<div id="video-fields">--}}
                    {{--<div class="ip-modal shown" id="image_1">--}}
                        {{--<div class="ip-modal-dialog">--}}
                            {{--<div class="ip-modal-content">--}}
                                {{--<div class="ip-modal-header">--}}
                                    {{--<a class="ip-close" title="Close">×</a>--}}
                                    {{--<h4 class="ip-modal-title">Change Your Photo</h4>--}}
                                {{--</div>--}}
                                {{--<div class="ip-modal-body">--}}

                                    {{--<div class="alert ip-alert"></div>--}}
                                    {{--<div class="ip-preview"></div>--}}
                                    {{--<div class="ip-rotate">--}}
                                        {{--<button type="button" class="btn btn-default ip-rotate-ccw" title="Rotate counter-clockwise"><i class="icon-ccw"></i></button>--}}
                                        {{--<button type="button" class="btn btn-default ip-rotate-cw" title="Rotate clockwise"><i class="icon-cw"></i></button>--}}
                                    {{--</div>--}}
                                    {{--<div class="ip-progress">--}}
                                        {{--<div class="text">Uploading</div>--}}
                                        {{--<div class="progress progress-striped active"><div class="progress-bar"></div></div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="ip-modal-footer">--}}
                                    {{--<button type="button" class="btn btn-success c-font-bold c-btn-square ip-save">Next</button>--}}
                                    {{--<div class="button_crop btn c-btn btn-lg c-btn-square ip-upload" style="position: inherit;width: 100%;margin-top: 5px !important;border: 0;color: #3f444a;font-weight: inherit;text-transform: lowercase;">--}}
                                        {{--<img style="display: none" class="image_cropped" src="https://www.gravatar.com/avatar/0?d=mm&amp;s=200" id="img_image_1" width="200px">--}}
                                        {{--<span>Add Photo 1</span> <input name="file" class="ip-file" type="file">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<br>--}}

                {{--<button onclick="GenerateVideo()" style="display: none" id="share_now" class="btn c-btn btn-lg c-font-bold c-font-white c-theme-btn c-btn-square c-font-uppercase">--}}
                    {{--Share Now--}}

                {{--</button>--}}
                {{--<button id="edit_creative" style="display: none" class="btn c-btn btn-lg c-font-bold c-font-white c-theme-btn c-btn-square c-font-uppercase">Edit Creative--}}
                {{--</button>--}}
                {{--<button id="continue_creation_video" style="display:none" class="btn c-btn btn-lg c-font-bold c-font-white c-theme-btn c-btn-square c-font-uppercase">Continue To Share--}}
                {{--</button>--}}
                {{--<button id="update_preview_button" class="disabled btn c-btn btn-lg c-font-bold c-font-white c-theme-btn c-btn-square c-font-uppercase" onclick="UpdateVideoPreview()">Update Preview--}}
                {{--</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection
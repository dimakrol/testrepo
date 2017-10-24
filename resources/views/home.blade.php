@extends('layouts.frontend.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="c-product-gallery">
                    <div id="sticky-anchor" style="height: 0px;"></div>
                    <div id="video_holder" class="c-product-gallery-content">
                        <div id="sticky">
                            <video data-id="1" poster="{{ asset('storage/images/bog.jpg') }}" preload="auto" class="center" width="100%" controls="">
                                <source src="api_video_play" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
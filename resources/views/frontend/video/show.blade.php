@extends('layouts.frontend.app')
@section('content')
    <!-- Page Content -->
    <div class="container">
        <!-- Heading Row -->
        <div class="row my-4">
            <div class="col-lg-8 video-container">
                {{--<h2>{{ $video->name }}</h2>--}}
                <video data-id="{{ $video->id }}" poster="{{ asset('images/default_for_video.png') }}" preload="auto" class="center" width="100%" controls="">
                    <source src="{{ $video->getLocalUrl() }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                {{--<img class="img-fluid rounded" src="http://placehold.it/900x400" alt="">--}}
            </div>
            <!-- /.col-lg-8 -->
            <div class="col-lg-4">
                <div>
                    @if(!Auth::user() || !Auth::user()->subscribed('yearly'))
                        <div class="form-group">
                            <a class="btn btn-success btn-block" href="{{ route('subscription.index') }}">Create Video</a>
                        </div>
                    @else
                        @foreach($video->fields as $field)
                            @if('image' == $field->type)
                                <div class="form-group">
                                    {!! Form::label($field->variable_name, 'Select photo or image') !!}
                                    {!! Form::file($field->variable_name, ['class' => 'form-control-file', 'accept' => 'image/*', 'required' => 'required']) !!}
                                </div>
                            @elseif('text' == $field->type)
                            @elseif('text_area' == $field->type)
                            @endif
                        @endforeach
                        <div class="form-group">
                            <button class="btn btn-success update-preview btn-block" href="#">Add Your Photo</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success update-preview btn-block" href="#" disabled="true">Update Preview</button>
                        </div>
                    @endif
                </div>
                <div id="croppie"></div>

                {!! Form::token() !!}

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let croppie = null;
        let fileName = null;
        let updatePreview = $('button.update-preview');
        let videoId = $('video').data('id');

        updatePreview.on('click', function () {
            uploadFile()
        });

        @foreach($video->fields as $field)
            $('input[name={{$field->variable_name}}]').on('change', function (e) {

                fileName = $(this)[0].name;

                let files = e.target.files || e.dataTransfer.files;

                console.log(files);
                if (!files.length) {
                    return;
                }
                createImage(files[0]);
            });
        @endforeach

        function createImage(file) {
            var image = new Image()
            var reader = new FileReader()

            reader.onload = (e) => {
                image = e.target.result;
                setUpCroppie(image)
            };
            reader.readAsDataURL(file)
        }

        function setUpCroppie(imageData) {
            let el = document.getElementById('croppie');
            if (croppie) {
                croppie.destroy();
            }

            updatePreview.prop('disabled', false);

            croppie = new Croppie(el, {
                viewport: { width: 140, height: 200 },
                boundary: { width: 300, height: 300 },
//            showZoomer: true,
//            enableResize: true,
                enableOrientation: true
            });
            croppie.bind({
                url: imageData
            });
        }

        function uploadFile (){
            croppie.result({
                type: 'canvas',
                size: 'viewport'
            }).then((response) => {

                let data = new FormData();
                data.append(fileName, response);
                data.append('_token', $('input[name=_token]').val());
                data.append('id', videoId);
                $.ajax({
                    url: '/video/generate',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data) {
                        $('.video-container').html(`
                        <video data-id="${data.videoId}" poster="http://localhost:8000/images/loading_anim.gif" autoplay preload="auto" class="center" width="100%" controls="">
                            <source src="${data.videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>`);
                    },
                    error: function(jqXHR, textStatus) {
                        console.log(textStatus);
                    }
                });
            })
        };
    </script>
@endsection
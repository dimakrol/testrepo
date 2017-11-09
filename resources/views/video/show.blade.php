@extends('layouts.frontend.app')
@section('content')
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-8 video-container">
                <video data-id="{{ $video->id }}" poster="{{ $video->getThumbnail() }}" preload="auto" class="center" width="100%" controls="">
                    <source src="{{ $video->getVideoUrl() }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="row">
                    <div class="col-2">
                        <a href="{{ route('video.show', $video->slug) }}"><img src="{{ $video->user->thumbnail_path }}" class="rounded-circle"></a>
                    </div>
                    <div class="col-10">
                        <h2>{{ $video->name }}</h2>
                        <p>Created by: <a href="{{ route('channel.index', $video->user->slug) }}">{{ $video->creator()->fullName() }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div>
                    @if(!Auth::user() || !Auth::user()->subscribed('yearly'))
                        <div class="form-group">
                            <a class="btn btn-success btn-block" href="{{ route('subscription.index') }}">Create Video</a>
                        </div>
                    @else
                        @foreach($video->fields as $field)
                            @if('image' == $field->type)
                                <div class="form-group hide-block">
                                    {!! Form::file($field->variable_name, ['class' => 'form-control-file', 'accept' => 'image/*', 'required' => 'required']) !!}
                                </div>
                            @elseif('text' == $field->type)
                            @elseif('text_area' == $field->type)
                            @endif
                        @endforeach
                        @foreach($video->fields as $field)
                            @if('image' == $field->type)
                                <div class="form-group">
                                    <button class="btn btn-success btn-block add-photo" data-variable-name="{{$field->variable_name}}">Add Your Photo</button>
                                </div>
                            @endif
                        @endforeach
                        <div class="form-group">
                            <button class="btn btn-success update-preview btn-block" disabled="true">Update Preview</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger btn-block crop-button hide-block">Crop</button>
                        </div>
                        @foreach($video->fields as $field)
                            @if('image' == $field->type)
                                <div class="text-center preview-image {{$field->variable_name}} hide-block">
                                    <img src="" class="img-fluid" alt="Responsive image">
                                </div>
                            @endif
                        @endforeach

                    @endif
                </div>
                <div id="croppie"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let croppie = null;
        let fileName = null;
        let croppedImage = null;
        let updatePreviewButton = $('button.update-preview');
        let videoId = $('video').data('id');
        let cropButton = $('.crop-button');
        let addPhotoButton = $('.add-photo');
        let previewImage = null;

        updatePreviewButton.on('click', function () {
            uploadFile();
        });

        cropButton.on('click', function () {
            cropImage();
        });

        addPhotoButton.on('click', function () {
            let varName = $(this).data('variable-name');
            $('input[name='+varName+']').click();
        });

        @foreach($video->fields as $field)
            $('input[name={{$field->variable_name}}]').on('change', function (e) {
                fileName = $(this)[0].name;
                previewImage = $('.preview-image.'+'{{$field->variable_name}}');
                console.log(previewImage.children());
                previewImage.hide();

                let files = e.target.files || e.dataTransfer.files;

                if (!files.length) {
                    return;
                }
                createImage(files[0]);
            });
        @endforeach

        function createImage(file) {
            var image = new Image();
            var reader = new FileReader();

            reader.onload = (e) => {

                image = e.target.result;

                setUpCroppie(image);

            };
            reader.readAsDataURL(file)
        }

        function setUpCroppie(imageData) {
            let el = document.getElementById('croppie');
            if (croppie) {
                croppie.destroy();
            }

            cropButton.show();

            croppie = new Croppie(el, {
                viewport: { width: 140, height: 200 },
                boundary: { width: 300, height: 300 },
                enableOrientation: true
            });

            croppie.bind({
                url: imageData
            });
        }


        function cropImage() {
            croppie.result({
                type: 'canvas',
                size: 'viewport'
            }).then((response) => {
                previewImage.show().children().attr('src', response);
                updatePreviewButton.prop('disabled', false);
                cropButton.hide();
                croppedImage = response;
                croppie.destroy();
                croppie = null;
                addPhotoButton.text('Change Photo');
            })
        }

        function uploadFile () {
            let data = new FormData();
            data.append(fileName, croppedImage);
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
                    previewImage.hide();
                },
                error: function(jqXHR, textStatus) {
                    console.log(textStatus);
                }
            });
        };
    </script>
@endsection
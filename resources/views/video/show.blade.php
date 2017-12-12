@extends('layouts.frontend.app')
@section('content')
    <div class="container bg-white">
        <div class="row justify-content-center video">
            <div class="col-md-10 col-lg-6 col-lg-offset-1">
                <div class="video-container" data-category="{{ $video->categoryName }}">
                    <video data-id="{{ $video->id }}" poster="{{ $video->getThumbnail() }}" autoplay preload="auto" class="center" width="100%" controls="">
                        <source src="{{ $video->getVideoUrl() }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="video__description-container">
                    <a class="d-inline-block" href="{{ route('video.show', $video->slug) }}">
                        <img src="{{ $video->user->thumbnail_path }}" class="rounded-circle avatar">
                    </a>
                    <div>
                        <h2 class="video__title">{{ $video->name }}</h2>
                        <p class="video__author">by: <a href="{{ route('channel.index', $video->user->slug) }}">{{ $video->creator()->fullName() }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-lg-5 pt-lg-3">
                @if(!Auth::user())
                    <div class="form-group">
                        <a class="custom-button custom-button--primary create-video" href="{{ route('register') }}">Create Video</a>
                    </div>
                @elseif(!Auth::user()->subscribed(['yearly', 'yearlyuk']))
                    <div class="form-group text-center">
                        <a class="custom-button custom-button--primary" href="{{ route('subscription.index') }}">Create Video</a>
                    </div>
                @else
                    @foreach($video->fields as $field)
                        @if('image' == $field->type)
                            <div class="form-group hide-block">
                                <form class="form-file">
                                    {!! Form::file($field->variable_name, ['class' => 'form-control-file', 'data-ratio' => $field->aspect_ratio, 'accept' => 'image/*', 'required' => 'required']) !!}
                                </form>
                            </div>
                        @elseif('text' == $field->type)
                        @elseif('text_area' == $field->type)
                        @endif
                    @endforeach
                    @foreach($video->fields as $field)
                        @if('image' == $field->type)
                            <div class="form-group">
                                <button class="custom-button custom-button--primary add-photo"
                                        data-variable-name="{{$field->variable_name}}"
                                >Add Your Photo</button>
                            </div>
                        @endif
                    @endforeach
                    <div class="form-group">
                        <button class="custom-button custom-button--primary update-preview" disabled="true">Update Preview</button>
                    </div>
                    <div class="form-group">
                        <a href="#" class="custom-button custom-button--primary download-video" disabled="true" style="display: none">
                            <i class="fa fa-download" aria-hidden="true"></i> Download
                        </a>
                    </div>
                    <div class="form-group">
                        <a href="#" class="custom-button custom-button--primary go-share" disabled="true" style="display: none">
                            {{--<i class="fa fa-share" aria-hidden="true"></i> --}}Go Share
                        </a>
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
        </div>
        {{--<div class="row">--}}
            {{--<h3 class="your-own">See also:</h3>--}}
            {{--<div class="row">--}}
                {{--@foreach($videos as $video)--}}
                    {{--<div class="col-lg-6 col-sm-6 portfolio-item">--}}
                        {{--<div class="card h-100">--}}
                            {{--<a href="{{ route('video.show', $video->slug) }}" data-category="{{$video->name}}">--}}
                                {{--<img class="card-img-top" src="{{ $video->getThumbnail() }}" alt="">--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

    <div class="modal" id="crop-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div id="croppie"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button class="custom-button custom-button--croppie rot-left" type="button">
                            <i class="fa fa-undo" aria-hidden="true"></i>
                        </button>
                        <button class="custom-button custom-button--croppie rot-right" type="button">
                            <i class="fa fa-repeat" aria-hidden="true"></i>
                        </button>
                        <button class="custom-button custom-button--croppie mr-0 trash-file" type="button" data-dismiss="modal">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="align-self-stretch">
                        <button class="custom-button custom-button--primary crop-button mb-2">Save</button>
                        <button type="button" class="custom-button custom-button--hollow trash-file" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            fbq('track', 'ViewContent', {
                content_name: "{{$video->slug}}"
            });

            let form = $('form.form-file');
            let trushButton = $('button.trash-file');
            let cropModal = $('#crop-modal');
            let croppie = null;
            let fileName = null;
            let croppedImage = null;
            let updatePreviewButton = $('button.update-preview');
            let videoId = $('video').data('id');
            let buttons = {
                crop: $('.crop-button'),
                addPhoto: $('.add-photo'),
                create: $('.create-video'),
                download: $('.download-video'),
                goShare: $('.go-share'),
                rotLeft: $('.rot-left'),
                rotRight: $('.rot-right'),
            };
            let previewImage = null;
            let ratio = null;

            trushButton.on('click', function () {
                form[0].reset();
            });

            buttons.create.on('click', function() {
                fbq('track', 'Lead', {
                    content_name: "{{$video->slug}}"
                });
            });

            updatePreviewButton.on('click', function () {
                uploadFile();
            });

            buttons.crop.on('click', function () {
                cropImage();
            });

            buttons.addPhoto.on('click', function () {
                let varName = $(this).data('variable-name');
                $('input[name='+varName+']').click();
            });

            buttons.rotLeft.on('click', function () {
                croppie.rotate(-90);
            });

            buttons.rotRight.on('click', function () {
                croppie.rotate(90);
            });

            @foreach($video->fields as $field)
                $('input[name={{$field->variable_name}}]').on('change', function (e) {
                fileName = $(this)[0].name;
                ratio = $(this).data('ratio');
                previewImage = $('.preview-image.'+'{{$field->variable_name}}');
                previewImage.hide();

                let files = e.target.files || e.dataTransfer.files;

                if (!files.length) {
                    return;
                }
                createImage(files[0]);
                cropModal.modal('show');
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

                // buttons.crop.show();
                // buttons.rotLeft.show();
                // buttons.rotRight.show();

                croppie = new Croppie(el, {
                    viewport: { width: ratio * 200, height: 200 },
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
                    // buttons.crop.hide();
                    // buttons.rotLeft.hide();
                    // buttons.rotRight.hide();
                    croppedImage = response;
                    cropModal.modal('hide');
                    croppie.destroy();
                    croppie = null;
                    buttons.addPhoto.text('Change Photo');
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
                        <video data-id="${data.videoId}" poster="https://localhost:8000/images/loading_anim.gif" autoplay preload="auto" class="center" width="100%" controls="">
                            <source src="${data.videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>`);
                        updatePreviewButton.prop('disabled', true);
                        if (data.downloadUrl) {
                            buttons.download.attr("href", data.downloadUrl).prop('disabled', false).show();
                        }
                        if (data.generatedUrl) {
                            buttons.goShare.attr("href", data.generatedUrl).prop('disabled', false).show();
                        }
                        previewImage.hide();
                    },
                    error: function(jqXHR, textStatus) {
                        console.log(textStatus);
                    }
                });
            };
        })
    </script>
@endsection
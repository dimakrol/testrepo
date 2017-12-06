@extends('layouts.admin.app')
@section('admin-content')
    <div class="alert alert-success col-md-6 admin__playlist_alert" role="alert" style="display: none">
        <span class="message"></span><span><i class="fa fa-times float-right" aria-hidden="true"></i></span>
    </div>
    <div class="form-group col-md-6">
        <h2><span class="text-danger">{{$playlist->name}}</span> edit order of videos:</h2>
    </div>
    @if($videos->count() > 0)
        <ul class="list-group col-md-6 admin__playlist">
            @foreach($videos as $video)
                <li id="item-{{$video->id}}" class="list-group-item" style="cursor: pointer">{{$video->name}}</li>
            @endforeach
        </ul>
    @else
        <div class="form-group">
            <h4>No tags added.</h4>
        </div>
    @endif
    <div style="padding: 15px">
        <div class="form-check">
            <label class="form-check-label">
                {!! Form::checkbox('display', null, $playlist->display, ['class' => 'form-check-input']); !!}
                Display
            </label>
        </div>
        <div class="form-group col-md-6 col-xs-12">
            {!! Form::label('link_id', 'Category link:') !!}
            {!! Form::select('link_id', $categories, $playlist->link, ['class' => 'form-control', 'placeholder' => 'Select Category Link']) !!}
        </div>
    </div>



@endsection

@section('script')
    <script>
        $(function () {
            let alert = $('.admin__playlist_alert');

            let display = $('input[name=display]');
            let category = $('select[name=link_id]');

            display.on('change', function () {
                let checked = 0;
                if ($(this).is(":checked")) {
                    checked = 1;
                }

                $.ajax({
                    data: {display: checked},
                    type: 'POST',
                    url: '{{route('admin.playlist.display', $playlist->id)}}',
                    success: function (data) {
                        alert.find('span.message').text('Display status updated!!!');
                        alert.show();
                    }
                });
            });

            category.on('change', function (e) {
                let id = $(this).val();

                if (id) {
                    $.ajax({
                        data: {link_id: id},
                        type: 'POST',
                        url: '{{route('admin.playlist.link', $playlist->id)}}',
                        success: function (data) {
                            alert.find('span.message').text('Category link updated!!!');
                            alert.show();
                        }
                    });
                }
            });

            alert.on('click', 'span', function () {
                $(this).parent().hide();
            });

            $('.admin__playlist').sortable({
                axis: 'y',
                update: function (event, ui) {
                    alert.hide();
                    var data = $(this).sortable('serialize');

                    $.ajax({
                        data: data,
                        type: 'POST',
                        url: '{{route('admin.playlist.update-video-order', $playlist->id)}}',
                        success: function (data) {
                            alert.find('span.message').text('Order changed success!!!');
                            alert.show();
                        }
                    });
                }
            });
        });

    </script>
@endsection
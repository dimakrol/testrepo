@extends('layouts.admin.app')
@section('admin-content')
    <div class="alert alert-success col-md-6 admin__playlist_alert" role="alert" style="display: none">
        Order changed success!!!<span><i class="fa fa-times float-right" aria-hidden="true"></i></span>
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

@endsection

@section('script')
    <script>
        $(function () {
            let alert = $('.admin__playlist_alert');

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
                            alert.show();
                        }
                    });
                }
            });
        });

    </script>
@endsection
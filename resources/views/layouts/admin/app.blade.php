@extends('layouts.frontend.app')

@section('content')
    <div id="wrapper" class="toggled">
        @include('layouts.admin.sidebar')
        <div id="page-content-wrapper">
            <div class="container-fluid">
                {{--todo add alert system--}}
                {{--<div class="alert alert-primary" role="alert">--}}
                    {{--This is a primary alert—check it out!--}}
                {{--</div>--}}
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection
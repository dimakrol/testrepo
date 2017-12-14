@extends('layouts.frontend.app')

@section('content')
    <div id="wrapper" class="toggled flex-grow-1">
        @include('layouts.admin.sidebar')
        <div id="page-content-wrapper">
            <div class="container-fluid">
                {{--todo add alert system--}}
                {{--<div class="alert alert-primary" role="alert">--}}
                    {{--This is a primary alert—check it out!--}}
                {{--</div>--}}
                {{-- todo add normal flash messages --}}
                @include('flash::message')
                @foreach($errors->all() as $message)
                    {{$message}}
                @endforeach
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection
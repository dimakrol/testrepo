@extends('layouts.admin.app')
@section('admin-content')
    <h2>All users:</h2>
    <table class="table">
        <thead class="thead-default">
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Created</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->first_name}}</th>
                <th>{{ $user->role or 'customer'}}</th>
                <td>{{$user->created_at}}</td>
                <td><a href="{{ route('admin.user.edit', $user->id) }}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> Edit</a></td>
                <td><a href="{{ route('admin.user.login', $user->id) }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
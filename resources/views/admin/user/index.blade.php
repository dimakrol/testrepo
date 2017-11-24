@extends('layouts.admin.app')
@section('admin-content')
    <h2>All users:</h2>
    <table class="table">
        <thead class="thead-default">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Role</th>
            <th>Created</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <th>{{$user->first_name}}</th>
                <th>{{ $user->role}}</th>
                <td>{{$user->created_at}}</td>
                <td><a href="{{ route('admin.user.edit', $user->id) }}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> Edit</a></td>
                <td><a href="{{ route('admin.user.login', $user->id) }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></td>
                <td>{!! Form::open([ 'method'  => 'delete', 'route' => [ 'admin.user.destroy', $user->id ] ]) !!}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
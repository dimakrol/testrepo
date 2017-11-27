@extends('layouts.admin.app')
@section('admin-content')
    <h2>All users:</h2>
    {!! Form::open(['route' => 'admin.user.store', 'method'  => 'get']) !!}
        <div class="form-group col-md-6">
            <label for="user-email">Search: </label>
            <select class="user-email form-control col-md-6" name="user-email"></select>
        </div>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    {!! Form::close() !!}
    <table class="table">
        <thead class="thead-default">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subscription</th>
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
                <th>{{$user->email}}</th>
                <th>{{$user->subscribed($plan->stripe_id) ? $plan->name : ''}}</th>
                <th>{{ $user->role}}</th>
                <td>{{$user->created_at}}</td>
                <td><a href="{{ route('admin.user.edit', $user->id) }}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> Edit</a></td>
                <td><a href="{{ route('admin.user.login', $user->id) }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></td>
                <td>
                @if (Auth::user()->id != $user->id)
                    {!! Form::open([ 'method'  => 'delete', 'route' => [ 'admin.user.destroy', $user->id ] ]) !!}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    {!! Form::close() !!}
                @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection

@section('script')
    <script>
        $('.user-email').select2({
            placeholder: 'Select an user by email',
            ajax: {
                url: '{{route('admin.user.search')}}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.email,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
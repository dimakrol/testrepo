@extends('layouts.admin.app')
@section('admin-content')
    <h2>All users:</h2>
    <table class="table" id="users-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Subscription</th>
            <th>Created</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
    </table>
@endsection

@section('script')
    <script>
        $('#users-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('admin.user.data')}}',
            columns: [
                { data: 'id', name: 'users.id'},
                { data: 'first_name', name: 'users.first_name'},
                { data: 'email', name: 'users.email'},
                { data: 'role', name: 'users.role'},
                { data: 'sub_name', name: 'subscriptions.name'},
                { data: 'created_at', name: 'users.created_at'},
                { data: 'login', name: 'login', orderable: false, searchable: false},
                { data: 'edit', name: 'edit', orderable: false, searchable: false},
                { data: 'delete', name: 'delete', orderable: false, searchable: false},
            ],
            scrollY: "600px",
            dom: "frtip",
            deferRender: true,
            iDisplayLength: 20,
            responsive:true,
        });
    </script>
@endsection
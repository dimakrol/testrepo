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
    <div class="modal fade" id="share-via-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm delete user?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger delete-user-modal" data-user-id="">Delete</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            let deleteUserModal = $('.delete-user-modal');

            $('#users-table_wrapper').on('click', '.delete-user', function () {
                deleteUserModal.data('user-id', $(this).data('user-id'));

                $('#share-via-email').modal('show');
            });

            deleteUserModal.on('click', function () {
                let userId = $(this).data('user-id');

                $.ajax({
                    data: {_method: 'delete'},
                    type: 'POST',
                    url: 'user/'+userId,
                    success: function () {
                        $('#share-via-email').modal('hide');
                        datatable.api().ajax.reload();
                    }
                });
            })

        });
        let datatable = $('#users-table').dataTable({
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
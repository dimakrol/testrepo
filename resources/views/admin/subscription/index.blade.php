@extends('layouts.admin.app')
@section('admin-content')
    <div class="alert alert-success col-md-6 admin__user_alert" role="alert" style="display: none">
        <span class="message"></span><span><i class="fa fa-times float-right" aria-hidden="true"></i></span>
    </div>
    <h2>All users:</h2>
    <table class="table" id="subscription-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Users Email</th>
            <th>Users Id</th>
            <th>Name</th>
            <th>Billing Type</th>
            <th>Billing Id</th>
            <th>Plan</th>
            <th>Next Payment</th>
            <th>Created At</th>
            <th></th>
        </tr>
        </thead>
    </table>
    <div class="modal fade" id="subscription-delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm delete subscription?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger delete-subscription-modal" data-user-id="">Delete</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            let deleteSubscriptionModal = $('.delete-subscription-modal');
            let alert = $('.admin__user_alert');


            $('#subscription-table').on('click', '.delete-subscription', function () {
                console.log('works');
                deleteSubscriptionModal.data('subscription-id', $(this).data('subscription-id'));
                $('#subscription-delete-modal').modal('show');
            });

            deleteSubscriptionModal.on('click', function () {
                let subscriptionId = $(this).data('subscription-id');

                $.ajax({
                    data: {_method: 'delete'},
                    type: 'POST',
                    url: 'subscription/'+subscriptionId,
                    success: function () {
                        $('#subscription-delete-modal').modal('hide');
                        datatable.api().ajax.reload();
                        alert.find('span.message').text('Subscription deleted!!!');
                        alert.show();
                    }
                });
            });

            alert.on('click', 'span', function () {
                $(this).parent().hide();
            });

            let datatable = $('#subscription-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('admin.subscription.data')}}',
                columns: [
                    { data: 'id', name: 'subscriptions.id'},
                    { data: 'user.email', name: 'user.email'},
                    { data: 'user.id', name: 'user.id'},
                    { data: 'name', name: 'subscriptions.name'},
                    { data: 'billing_type', name: 'subscriptions.billing_type'},
                    { data: 'stripe_id', name: 'subscriptions.stripe_id'},
                    { data: 'stripe_plan', name: 'subscriptions.stripe_plan'},
                    { data: 'next_payment', name: 'subscriptions.next_payment'},
                    { data: 'created_at', name: 'subscriptions.created_at'},
                    { data: 'delete', name: 'delete', orderable: false, searchable: false},
                ],
                scrollY: "600px",
                dom: "frtip",
                deferRender: true,
                iDisplayLength: 20,
                responsive:true,
            });
        });






    </script>
@endsection
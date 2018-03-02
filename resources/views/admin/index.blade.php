@extends('layouts.admin.app')

@section('admin-content')
<h2>Welcome to Admin</h2>
<h3><span class="text-success">Global:</span></h3>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Users total:</th>
        <th scope="col">Paying Users:</th>
        <th scope="col">Total Number of shares:</th>
        <th scope="col">Videos Created:</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">{{$allUsers}}</th>
        <td>{{$payingUsers}}</td>
        <td>{{$totalShares}}</td>
        <td>{{$videosCreated}}</td>
    </tr>
    </tbody>
</table>
{{--<h1>Simple Sidebar</h1>--}}
{{--<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>--}}
{{--<p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>--}}
{{--<a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a>--}}

@endsection

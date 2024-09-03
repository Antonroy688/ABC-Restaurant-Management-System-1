@extends('layouts.app')
@section('title', 'Employees')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Employees</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Employees</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <input id="search" value="" name="search" placeholder="Search" type="text" style="
        width: 100%;
        padding: 10px 20px;
        margin-top:27px;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px; 
        box-sizing: border-box;">
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Country Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       @include('users.filter')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function fetch_data(page, query) {
        $.ajax({
            url: 'users?page=' + page,
            data: {
                'query': query,
            },

        }).done(function(activityLogs) {
            $('tbody').html(activityLogs);
        }).fail(function() {
            console.log("Failed to load data!");

        });
    }

    $('#search').on('keyup',function() {
        var query = $('#search').val();
        var page = $('#hidden_page').val();
        fetch_data(page, query);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var query = $('#search').val();
        fetch_data(page, query);

    });
</script>
@endsection
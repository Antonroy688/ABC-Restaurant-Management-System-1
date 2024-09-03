@extends('layouts.app')
@section('title', 'Activity Log')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Activity Log</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
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
        <div class="col-md-8">
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
                    <div class="pull-right">
                        <button class="btn btn-danger delete" style="
        width: 100%;
        padding: 10px 20px;
        margin-top:27px;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px; 
        box-sizing: border-box;">Clear ActivityLogs</button>
                    </div>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Activity Made By</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody class="activitylogs">
                        @include('filterActivitylog')
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
            url: 'activityLog?page=' + page,
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
    $('.delete').on('click', function() {
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            type: 'POST',
            url: '{{route('activityLog.delete')}}',
            success: function(response) {
            if (response.status == 200) {
                toastr.success('Activity Logs Deleted Successfully');
                $('.activitylogs').load(' .activitylogs');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            toastr.error('Failed to delete activity logs');
        }
        });
    });
</script>
@endsection
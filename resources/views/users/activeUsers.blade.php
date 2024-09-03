@extends('layouts.app')
@section('title', 'Active Users')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Active Users</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Active Users</li>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 30%;">Last Login</th>
                            <th style="width: 30%;">Last Activity on</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeUsers as $key=> $user)
                        <tr>
                            <th  style="width: 10%;">{{++$key}}</th>
                            <td style="width: 30%;">{{$user->name}}</td>
                            <td style="width: 30%;">{{Carbon\Carbon::parse($user->last_login)->diffForHumans()}}</td>
                            <td style="width: 30%;">{{Carbon\Carbon::parse($user->last_activity)->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

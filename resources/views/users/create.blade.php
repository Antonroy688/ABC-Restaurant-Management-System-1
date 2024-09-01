@extends('layouts.app')
@section('title', 'Employee Create')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Employee Create</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Employee Create</li>
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
                <form class="form-horizontal" action="{{route('users.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                    <label>E-mail</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter Phone" required>

                                    <!-- <input type="number" name="phone" class="form-control" placeholder="Enter Phone" id="phone-code" required>
                                    <input type="text" name="country_code" value=""> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                <label>Role</label>
                                        <select class="select2 form-control custom-select" name="role" style="width: 100%; height:36px;" required>
                                            <option disabled>Select Role</option>
                                            @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                    <label>Date of Birth <small class="text-muted">mm/dd/yyyy</small></label>
                                    <input type="date" name="dob" class="form-control date-inputmask" id="date-mask">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group m-t-20">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Enter Last Name" required>
                                </div>
                            </div>
                        </div>


                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection




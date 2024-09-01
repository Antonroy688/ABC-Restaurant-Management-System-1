@extends('layouts.app')
@section('title', 'City Permission')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">{{$user->name}} City Permissions</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">City Permission</li>
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
                <form class="form-horizontal" action="{{route('usersCity.update',$user->id)}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            @foreach($countries as $country)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <h4>
                                        <input class="form-check-input group-checkbox" type="checkbox" data-country-name="{{ $country->name }}">
                                        {{ $country->name }}
                                    </h4>
                                    @foreach($country->cities as $city)
                                    <input class="form-check-input permission-checkbox" name="city_ids[]" data-country-name="{{ $country->name }}" type="checkbox" value="{{ $city->id }}"  @if($user->cityPermissions->pluck('city_id')->contains($city->id)) checked @endif>
                                    <label class="form-check-label">
                                        {{ $city->name }}
                                    </label><br>                                   
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.group-checkbox').change(function() {
            var groupId = $(this).data('group-id');
            var isChecked = $(this).prop('checked');
            $('.permission-checkbox').each(function() {
                console.log('per', $(this).data('group-id'));
                if ($(this).data('group-id') == groupId) {
                    $(this).prop('checked', isChecked);
                }
            });
        });
    });
</script>
@endsection
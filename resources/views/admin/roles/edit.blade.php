@extends('layouts.app')
@section('title', 'Roles Edit')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Roles Edit</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles Edit</li>
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
                <form class="form-horizontal" action="{{route('roles.update',$role->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-left control-label col-form-label">Role Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="rolename" class="form-control" id="" placeholder="Role Name Here" value="{{$role->name}}" required>
                            </div>
                        </div>
                        @if($permissionGroups->count()>0)
                        <div class="row">
                            @foreach($permissionGroups as $permissionGroup)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <h4>
                                        <input class="form-check-input group-checkbox" type="checkbox" data-group-id="{{$permissionGroup->id}}">
                                        {{$permissionGroup->name}}
                                    </h4>
                                    @if($permissionGroup->permissions->count() > 0)
                                    @foreach($permissionGroup->permissions as $permission)
                                    <input class="form-check-input permission-checkbox" name="permission_id[]" data-group-id="{{$permission->permission_group_id}}" type="checkbox" value="{{$permission->name}}"  {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{$permission->name}}
                                    </label><br>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endif
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.group-checkbox').change(function() {
            var groupId = $(this).data('group-id');
            var isChecked = $(this).prop('checked');
            $('.permission-checkbox').each(function() {
                console.log('per',$(this).data('group-id'));
                if ($(this).data('group-id') == groupId) {
                    $(this).prop('checked', isChecked);
                }
            });
        });
    });
</script>
@extends('layouts.app')
@section('title', 'Roles')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Roles</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@can('Roles Create')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" action="{{route('roles.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-left control-label col-form-label">Role Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="rolename" class="form-control" id="fname" placeholder="Role Name Here" required>
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
                                    <input class="form-check-input permission-checkbox" name="permission_id[]" data-group-id="{{$permission->permission_group_id}}" type="checkbox" value="{{$permission->name}}">
                                    <label class="form-check-label">
                                        {{$permission->name}}
                                    </label><br>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
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
@endcan
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $key=> $role)
                        <tr>
                            <th  style="width: 5%;">{{++$key}}</th>
                            <td style="width: 15%;">{{$role->name}}</td>
                            <td style="width: 60%;">
                                @foreach($role->permissions as $permission)
                                {{$permission->name}} |
                                @endforeach
                            </td>

                            <td style="width: 20%;">
                                @if($role->name!='Super Admin')
                                <a href="{{route('roles.edit',$role->id)}}"><button type="button" class="btn btn-warning">Edit</button></a>
                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
@section('scripts')
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
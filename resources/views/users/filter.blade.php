@foreach($users as $key=> $user)
<tr>
    <th style="width: 5%;">{{++$key}}</th>
    <td style="width: 10%;">{{$user->name}}</td>
    <td style="width: 10%;">{{$user->email}}</td>
    <td style="width: 15%;">{{$user->roles->first()->name}}</td>
    <td style="width: 30%;">
        @foreach($user->CityPermissions as $city)
        {{$city->city->name}} |
        @endforeach
    </td>

    <td style="width: 25%;">
        <a href="{{route('users.edit',$user->id)}}"><button type="button" class="btn btn-warning">Edit</button></a>
        <a href="{{route('users.citypermission',$user->id)}}"><button type="button" class="btn btn-secondary">Country</button></a>
        <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </td>
</tr>
@endforeach
<tr>
        <td colspan="10">
                <span style="float: left;margin-top:10px;">showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} Entries</span>

                <span style="float: right;">{{$users->links('paginationStyle')}}</span>
        </td>
</tr>
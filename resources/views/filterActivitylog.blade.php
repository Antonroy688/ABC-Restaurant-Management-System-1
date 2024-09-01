@foreach($activityLogs as $key=> $activity)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$activity->subject->name?$activity->subject->name:''}}</td>
                            <td>{{$activity->subject->roles->first()->name}}</td>
                            <td>{{$activity->description}}</td>
                            <?php $data = json_decode($activity->properties, true);
                            ?>
                            <td>{{$data['attributes']['ip_address']}}</td>
                            <td>{{$activity->causer?$activity->causer->name:''}}</td>
                            <td>{{$activity->created_at->format('Y-m-d H:i:s')}}</td>
                        </tr>
                            @endforeach

                        <tr>
        <td colspan="10">
                <span style="float: left;margin-top:10px;">showing {{ $activityLogs->firstItem() }} to {{ $activityLogs->lastItem() }} of {{ $activityLogs->total() }} Entries</span>

                <span style="float: right;">{{$activityLogs->links('paginationStyle')}}</span>
        </td>
</tr>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Size Details</h3>
    </div>
    @include('common.show_messages')
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>Id</th>
                <th>Value</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Actions</th>
            </tr>
            @if(!empty($sizeObjs))
            @foreach($sizeObjs as $size)
            <tr>
                <td>{{$size->size_id}}</td>
                <td>{{$size->value}}</td>
                <td>{{$size->created_at}}</td>
                <td>{{$size->updated_at}}</td>
                <td>
                    <i class="fa fa-trash text-danger" data-id="{{$size->size_id}}" title="Delete" data-toggle="modal" data-target="#modal-default" onclick="updateDeleteIdVal(this)"></i>
                    <a href="{{url("/admin/size/edit/$size->size_id")}}" title="{{$size->value}}">&nbsp;
                        <i class="fa fa-edit text-success" title="View Size"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="8" class="text-info text-center">Sorry! No data found</td>
            </tr>
            @endif
        </table>
    </div>
    @include('common.paginations')

</div>

<script>

    function updateDeleteIdVal(obj) {
        $('#delete_id').val($(obj).data('id'));
    }

    function getDeleteAction(){
        window.location = base_url + '/admin/size/delete/' + $('#delete_id').val();
    }
</script>

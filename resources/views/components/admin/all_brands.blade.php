<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Brand Details</h3>
    </div>
    @include('common.show_messages')
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Breadcrumb</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Actions</th>
            </tr>
            @if(!empty($brandObjs))
            @foreach($brandObjs as $brand)
            <tr>
                <td>{{$brand->brand_id}}</td>
                <td>{{$brand->title}}</td>
                <td>{{$brand->breadcrumb}}</td>
                <td>{{$brand->created_at}}</td>
                <td>{{$brand->updated_at}}</td>
                <td>
                    <i class="fa fa-trash text-red" data-id="{{$brand->brand_id}}" title="Delete" data-toggle="modal" data-target="#modal-default" onclick="updateDeleteIdVal(this)"></i>
                    <a href="{{url("/admin/brand/edit/$brand->brand_id")}}" title="{{$brand->title}}">&nbsp;
                        <i class="fa fa-edit text-orange" title="View Brand"></i>
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
        window.location = base_url + '/admin/brand/delete/' + $('#delete_id').val();
    }
</script>
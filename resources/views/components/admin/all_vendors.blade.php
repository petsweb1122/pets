<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Vendors Details</h3>
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
            @if(!empty($vendorObjs))
            @foreach($vendorObjs as $vendor)
            <tr>
                <td>{{$vendor->vendor_id}}</td>
                <td>{{$vendor->title}}</td>
                <td>{{$vendor->breadcrumb}}</td>
                <td>{{$vendor->created_at}}</td>
                <td>{{$vendor->updated_at}}</td>
                <td>
                    <i class="fa fa-trash text-red" data-id="{{$vendor->vendor_id}}" title="Delete" data-toggle="modal" data-target="#modal-default" onclick="updateDeleteIdVal(this)"></i>
                    <a href="{{url("/admin/vendor/edit/$vendor->vendor_id")}}" title="{{$vendor->title}}">&nbsp;
                        <i class="fa fa-edit text-orange" title="Update Vendor"></i>
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
        window.location = base_url + '/admin/vendor/delete/' + $('#delete_id').val();
    }
</script>

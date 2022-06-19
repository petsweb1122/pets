<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Categories Details</h3>
    </div>
    @include('common.show_messages')
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Breadcrumb</th>
                <th>Parent Id</th>
                <th>Parent Title</th>
                <th>Parent Breadcrumb</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Actions</th>
            </tr>
            @if(!empty($catObjs))
            @foreach($catObjs as $category)
            <tr>
                <td>{{$category->category_id}}</td>
                <td>{{$category->title}}</td>
                <td>{{$category->breadcrumb}}</td>
                <td>{{$category->parent_id}}</td>
                <td>{{$category->parent_title}}</td>
                <td>{{$category->parent_breadcrumb}}</td>
                <td>{{$category->created_at}}</td>
                <td>{{$category->updated_at}}</td>
                <td>
                    <i class="fa fa-trash text-red" data-id="{{$category->category_id}}" title="Delete" data-toggle="modal" data-target="#modal-default" onclick="updateDeleteIdVal(this)"></i>
                    <a href="{{url("/admin/category/edit/$category->category_id")}}" title="{{$category->title}}">&nbsp;
                        <i class="fa fa-edit text-orange" title="View Category"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="8" class="text-orange text-center">Sorry! No data found</td>
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
        window.location = base_url + '/admin/category/delete/' + $('#delete_id').val();
    }
</script>
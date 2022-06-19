<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Categories Details - ({{ $vendor_obj->title }})</h3>
    </div>
    @include('common.show_messages')
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Breadcrumb</th>
                <th>Mapped With</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Actions</th>
            </tr>
            @if (!empty($catObjs))
                @foreach ($catObjs as $category)
                    @php
                        // dd($category);
                    @endphp
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->category_breadcrumb }}</td>
                        <td>{{ $category->map_with }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>
                            <i class="fa fa-trash text-red" data-id="{{ $category->id }}" title="Delete"
                                data-toggle="modal" data-target="#modal-default" onclick="updateDeleteIdVal(this)"></i>
                            &nbsp;&nbsp;
                            <a href="{{ url("/admin/category-validation/add-vendor-category-$vendor_obj->vendor_id/$category->id/") }}"><i class="fa fa-solid fa-plus  text-green"></i></a> &nbsp;&nbsp;
                            <a href="{{ url("/admin/category-validation/sync-vendor-category-$vendor_obj->vendor_id/$category->id/") }}"><i class="fa fa-refresh  text-blue" aria-hidden="true"></i></a>&nbsp;&nbsp;
                            <a href="{{ url("/admin/category-validation/all-vendor-category-$vendor_obj->vendor_id/$category->id/") }}"
                                title="{{ $category->category_name }}">
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

    function getDeleteAction() {
        window.location = base_url + '/admin/category/delete/' + $('#delete_id').val();
    }
</script>

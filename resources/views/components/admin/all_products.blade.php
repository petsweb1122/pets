<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Product Details</h3>
    </div>
    @include('common.show_messages')
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Vendor</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Actions</th>
            </tr>
            @if (!empty($products))
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product_id }}</td>
                        @php
                            $title_link = $product->title_breadcrumb . '_' . $product->product_id . '.html';
                        @endphp
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->vendor_title }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->updated_at }}</td>
                        <td>
                            @if ($user_data->role == 'super-admin' || $user_data->role == 'developer')
                                <i class="fa fa-trash text-red" data-id="{{ $product->product_id }}" title="Delete"
                                    data-toggle="modal" data-target="#modal-default"
                                    onclick="updateDeleteIdVal(this)"></i>
                                <a href="{{ url("/admin/products/edit/$product->product_id") }}"
                                    title="{{ $product->title }}">&nbsp;
                                    <i class="fa fa-edit text-orange" title="Edit Product"></i>
                                </a>
                                <a href="{{ url("/admin/products/$product->product_id/upload-image") }}"
                                    target="_blank" title="{{ $product->title }}">&nbsp;
                                    <i class="fa fa-image text-aqua" title="Upload Product Images"></i>
                                </a>
                            @endif

                            <a href="{{ url("/$title_link") }}" target="_blank" title="{{ $product->title }}">&nbsp;
                                <i class="fa fa-eye text-green" title="View Product"></i>
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

    function getDeleteAction() {
        window.location = base_url + '/admin/products/delete/' + $('#delete_id').val();
    }
</script>

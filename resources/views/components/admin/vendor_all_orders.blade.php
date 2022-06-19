<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Vendor Orders Details</h3>
    </div>
    @include('common.show_messages')
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>Order Id</th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Total Items</th>
                <th>Total Quantites</th>
                <th>Amount</th>
                {{-- <th>Status</th> --}}
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
            @if(!empty($orderObjs))
            @foreach($orderObjs as $order)
            <tr>
                <td>{{$order->ref_patch_order_id}}</td>
                <td>Saima Khan</td>
                <td>0000-000000</td>
                <td>{{$order->total_items}}</td>
                <td>{{$order->total_qty}}</td>
                <td>{{number_format($order->final_amount, 2)}}</td>
                {{-- <td>{{$order->order_status}}</td> --}}
                <td>{{$order->created_at}}</td>
                <td>
                    <a href="{{url("admin/vendor-orders/vendor/$order->vendor_id/order/$order->vendor_order_id")}}" title="{{$order->vendor_order_id}}">&nbsp;
                        <i class="fa fa-search text-green" title="View Order"></i>
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


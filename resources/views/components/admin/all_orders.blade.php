<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">All Orders Details</h3>
    </div>
    @include('common.show_messages')
    <div class="box-body  table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>Order Id</th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Total Items</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
            @if(!empty($orderObjs))
            @foreach($orderObjs as $order)
            <tr>
                <td>{{$order->order_id}}</td>
                <td>{{$order->name . ' ' . $order->last_name}}</td>
                <td>{{$order->contact_number}}</td>
                <td>{{$order->total_items}}</td>
                <td>{{$order->total_price}}</td>
                <td>{{$order->order_status}}</td>
                <td>{{$order->created_at}}</td>
                <td>
                    <a href="{{url("/admin/customer-orders/order-view/$order->order_id")}}" title="{{$order->order_id}}">&nbsp;
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


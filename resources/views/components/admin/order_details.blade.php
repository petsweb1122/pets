@php
$user_data = json_decode(Session::get('user_data'));
@endphp
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <img alt="Logo" width="300" src="{{ url('front/img/logo.png') }}">
                <small
                    class="pull-right">{{ Carbon\Carbon::parse(!empty($order_details[0]->creation_date) ? $order_details[0]->creation_date : '')->format('d M Y') }}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Ship To:
            <address>
                <strong>{{ !empty($order_details[0]->customer_first_name) || !empty($order_details[0]->customer_last_name) ? $order_details[0]->customer_first_name . ' ' . $order_details[0]->customer_last_name : '' }}</strong><br>

                <b>Address:</b>
                {{ !empty($order_details[0]->customer_address) ? $order_details[0]->customer_address : '' }}<br>
                <b>Phone:</b>
                {{ !empty($order_details[0]->customer_contact_number) ? $order_details[0]->customer_contact_number : '' }}<br>
                <b>City:</b>
                {{ !empty($order_details[0]->customer_city) ? $order_details[0]->customer_city : '' }}<br>
                <b>Email:</b>
                {{ !empty($order_details[0]->customer_email) ? $order_details[0]->customer_email : '' }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col pull-right">
            <b>Order ID:</b> {{ !empty($order_details[0]->order_id) ? $order_details[0]->order_id : '' }}<br>
            <b>Order Total Items</b>
            {{ !empty($order_details[0]->total_products) ? $order_details[0]->total_products : '' }}<br>
            <b>Order Total Quantites</b>
            {{ !empty($order_details[0]->total_quantities) ? $order_details[0]->total_quantities : '' }}<br>
            <b>Shipping Company</b>
            {{ !empty($order_obj->shipping_method) ? $order_obj->shipping_method : '' }}<br>
            <b>Tracking Number</b>
            {{ !empty($order_obj->tracking_number) ? $order_obj->tracking_number: '' }}<br>
            <b>Order Status:</b>
            {{ !empty($order_details[0]->order_status) ? ucwords(str_replace('-', ' ', $order_details[0]->order_status)) : '' }}<br>
            <b>Status Message:</b>
            {{ !empty($order_details[0]->s_message) ? ucwords($order_details[0]->s_message) : '' }}<br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>UPC #</th>
                        <th>Product</th>
                        <th>Vendor</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_details as $item)
                        <tr>
                                @php
                                    $title_link =$item->product_bread. '_' . $item->product_id . '.html';
                                @endphp
                            <td>{{ $item->upc }}</td>
                            <td><a href="{{url("/$title_link")}}" target="_blank" title="{{$item->product_title}}">{{ $item->product_title }}</a> * <strong>{{ $item->order_product_qty }}(Qty)</strong></td>
                            <td>{{ $item->vendor_name }}</td>
                            <td>{{ number_format($item->order_product_price,2) }}</td>
                            <td>-{{number_format(env('PETS_DISC') * $item->order_product_price, 2) }}  ({{env('PETS_DISC')*100 }}%)</td>
                            <td>US: {{ number_format($item->order_product_price , 2) - number_format(env('PETS_DISC') * $item->order_product_price, 2) }}$</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-7">
            <p class="lead">Payment Methods:</p>
            <h3>Paypal</h3>
        </div>
        <!-- /.col -->
        <div class="col-xs-5">

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Discount:</th>
                        <td>US: -{{ number_format($order_obj->discount_amount, 2) }}$ ({{$order_obj->discount_percent}}%)</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>US: {{ ( number_format($order_obj->total_price , 2) + number_format($order_obj->discount_amount, 2) ) }}$</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Tax:</th>
                        <td>US: {{ number_format($order_obj->tax, 2) }}$</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Shipping Price:</th>
                        <td>US: {{ number_format($order_obj->shipping_price, 2) }}$</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <th>US: {{ number_format($order_obj->final_amount, 2) }}$</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @if ($user_data->role == 'super-admin')
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['url' => 'admin/orders/update-order']) !!}
                @php
                    $errors = session()->get('errors');
                    $message = !empty(session()->get('message')) ? session()->get('message') : '';
                    $message_class = !empty(session()->get('error')) ? 'label-danger' : 'label-success';
                @endphp
                <div class="{{ $message_class }} text-center">
                    {{ !empty(session()->get('message')) ? session()->get('message') : '' }}</div>
                @if (!empty($errors))
                    <ul class="">
                        @foreach ($errors as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <input type="hidden" name="order_id"
                    value="{{ !empty($order_details[0]->order_id) ? $order_details[0]->order_id : '' }}">
                <div class="box-body">
                    <div class="form-field">
                        {!! Form::label('update_order', 'Update Order:') !!}
                        {!! Form::select('update_order', ['pending' => 'Pending', 'payment-verfication' => 'Payment Verified' , 'in-progress' => 'In Progress', 'in-warehouse' => 'In Warehouse' ,  'dispached' => 'Dispached','rejected' => 'Rejected', 'completed' => 'Completed'], !empty($order_obj->order_status) ? $order_obj->order_status : 'pending', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-field">
                        {!! Form::label('message', 'Message:') !!}
                        {!! Form::text('message', !empty($order_obj->order_message) ? $order_obj->order_message : '', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-field">
                        {!! Form::label('shipping_company', 'Shipping Company:') !!}
                        {!! Form::text('shipping_company', !empty($order_obj->shipping_method) ? $order_obj->shipping_method : '', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-field">
                        {!! Form::label('tracking_number', 'Tracking Number:') !!}
                        {!! Form::text('tracking_number', !empty($order_obj->tracking_number) ? $order_obj->tracking_number : '', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="box-footer">
                    {!! Form::submit('Update Order', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endif
</section>

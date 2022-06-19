<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard" title="Home"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
@if (!empty(session()->get('success')))
    <h2>{{session()->get('success')}}</h2>
@endif
@if (!empty(session()->get('error')))
    <h2>{{session()->get('error')}}</h2>
@endif
<div></div>
<section class="content">
    <div class="row">
        @foreach ($order_stats as $stat)
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $stat->title }} Orders Break Down</h3>
                    </div>
                    <div class="box-body">
                        <div class="progress-group">
                            <span class="progress-text">{{ $stat->title }} Vendor Orders Price:</span>
                            <span class="progress-number"><b>{{ number_format($stat->total_vendor_price, 2) }}$</b></span><br>
                            <span class="progress-text">{{ $stat->title }} Total Orders:</span>
                            <span class="progress-number"><b>{{ $stat->total_v_orders}}</b></span><br>
                        </div>
                    </div>
                    {{-- {!! Form::open(['url' => 'admin/vendors/invoice-to-vendors']) !!}
                        <input type="hidden" name="vendor_name" value="{{$stat->title}}">
                        <div class="info-box">
                            <input type="submit" class="btn btn-info btn send-to-vendor" value="Send again notification To Vendor All Orders">
                        </div>
                    {!! Form::close() !!} --}}
                    <hr>
                    <a class="btn btn-success pull-right" href="{{url("/admin/vendor-orders/all-vendor-orders/$stat->vendor_id")}}" title="View All Orders"> View All {{ $stat->title }} Orders </a>
                </div>
            </div>
        @endforeach


    </div>
</section>

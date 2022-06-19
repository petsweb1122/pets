<section class="content-header">
    <h1>
        Dashboard Orders
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}" title="Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
@if (!empty(session()->get('success')))
    <h2>{{ session()->get('success') }}</h2>
@endif
@if (!empty(session()->get('error')))
    <h2>{{ session()->get('error') }}</h2>
@endif
<div></div>
<section class="content">
    <div class="row">
        @if (!empty($order_stats))
            @foreach ($order_stats as $stat)
                <div class="col-md-6">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ $stat->title }} Orders Break Down</h3>
                        </div>
                        <div class="box-body">
                            <div class="progress-group">
                                <span class="progress-text">{{ $stat->title }} Customer Order - Vendor Price</span>
                                <span class="progress-number"><b>{{ $stat->total_vendor_price }}</b>/1000$</span>
                                @php
                                    $percen = ($stat->total_vendor_price / 1000) * 100;
                                @endphp
                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua" style="width: {{ $percen }}%">
                                    </div>
                                </div>
                                <span class="progress-text">{{ $stat->title }} Customer Order - Price</span>
                                <span
                                    class="progress-number"><b>{{ number_format($stat->total_price, 2) }}</b>/2350$</span>
                                @php
                                    $percen_p = ($stat->total_price / 2350) * 100;
                                @endphp
                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua" style="width: {{ $percen_p }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::open(['url' => 'admin/vendors/send-to-vendors']) !!}
                        <input type="hidden" name="vendor_name" value="{{ $stat->title }}">
                        <div class="info-box">
                            <input type="submit" class="btn btn-info btn send-to-vendor" value="Send To Vendor">
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        @else
                <h4>Orders Already sent to vendors</h4>
        @endif

    </div>
</section>

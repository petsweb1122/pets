<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}" title="Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Products Breakdown</h3>
                </div>
                <div class="box-body">
                    <canvas id="pieChart" style="height:250px"></canvas>
                </div>

                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                    @foreach ($vendor_product_count as $key => $object)
                        <div class="info-box-content pull-left">
                            <span class="info-box-text">{{ $object->title }}</span>
                            <span class="info-box-number">{{ $object->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Vendors Breakdown</h3>
                </div>
                <div class="box-body">
                    <canvas id="pieChart2" style="height:250px"></canvas>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                    <div class="info-box-content pull-left">
                        <span class="info-box-text">Total Vendors</span>
                        <span class="info-box-number">{{ $parent_vendors }}</span>
                    </div>

                    <div class="info-box-content pull-left">
                        <span class="info-box-text">Total Brands</span>
                        <span class="info-box-number">{{$total_brands + $child_vendors }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$total_categories}}</h3>
                    <p>Total Categories</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('/admin/category/all-categories')}}" class="small-box-footer" title="More Info">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$total_brands + $child_vendors }}</h3>
                    <p>Total Brands</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('/admin/brand/all-brands')}}" class="small-box-footer" title="More Info">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$product_with_images}}</h3>
                    <p>Product With Images</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$product_without_images}}</h3>
                    <p>Product Without Images</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    vendor_product_counts = '{!! json_encode($vendor_product_count) !!}';
    child_vendors = '{{ $child_vendors }}';
    parent_vendors = '{{ $parent_vendors }}';
</script>

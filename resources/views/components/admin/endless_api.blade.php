<section class="content-header">
    <h1>
        Upload Product Using API
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Breakdown</h3>
                </div>
                <div class="box-body">
                    <canvas id="pieChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ !empty($total_api_products) ? $total_api_products : '' }}</h3>
                    <p>Total PhillipsPet Api Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ !empty($synced_products) ? $synced_products : '' }}</h3>
                    <p>Synced Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ !empty($not_synced_products) ? $not_synced_products : '' }}</h3>
                    <p>Products Not Synced</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    @if (!empty($categories_mapped))
                        {!! Form::open(['url' => 'admin/upload-products/endless-by-api']) !!}
                        <label for="">Click Sync Button And sync all the products</label>
                        <br>
                        {!! Form::submit('Sync', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    @else
                        <label class="label label-danger" for="">Need To Map the Categories, go Categories Validation
                            Module and map
                            the categories</label>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    {!! Form::open(['url' => 'admin/sync-endless-categories']) !!}
                    <label for="">Categories</label>
                    <br>
                    {!! Form::submit('Categories Sync', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::open(['url' => 'admin/upload-products/fetch-endless-by-api']) !!}
                    <label for="">Click Fetch and then use sync button for upload all the products</label>
                    <br>
                    {!! Form::submit('Fetch Products', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    phillips_api_products = "{{ $total_api_products }}";
    phillips_synced_products = "{{ $synced_products }}";
    phillips_not_synced_products = "{{ $not_synced_products }}";
</script>

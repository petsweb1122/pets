<section class="content-header">
    <h1>
        LeeMarPet: Upload Product Using Sheet
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
                    <h3>{{ !empty($total_api_products) ? $total_api_products : 0 }}</h3>
                    <p>Total LeemarPet Products</p>
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
                    <h3>{{ !empty($synced_products) ? $synced_products : 0 }}</h3>
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
                    <h3>{{ !empty($not_synced_products) ? $not_synced_products : 0 }}</h3>
                    <p>Products Not Synced</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    </div>
    @if (!empty(session()->get('errors')))
        <span class="label label-danger">{{ session()->get('errors') }}</span>
    @endif
    {!! Form::open(['url' => 'admin/upload-products/leemarpet-by-sheet/', 'files' => true]) !!}
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">

                    {!! Form::label('upload_sheet', 'Select a LeeMarPet Sheet for Upload Products:') !!}
                    {!! Form::file('upload_sheet', ['id' => 'upload_product_by_sheet']) !!}



                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit('Upload Sheet', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
    <div class="box box-primary">
        {!! Form::open(['url' => 'admin/sync-leemarpet-categories/']) !!}
        <div class="box-footer">
            {!! Form::submit('Sync Categories', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
    <div class="box box-primary">
        @if (!empty($categories_mapped))
            {!! Form::open(['url' => 'admin/sync-upload-products/sync-leemarpet-by-sheet/5']) !!}
            <div class="box-footer">
                {!! Form::submit('Sync Products 5', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
            {!! Form::open(['url' => 'admin/sync-upload-products/sync-leemarpet-by-sheet/10']) !!}
            <div class="box-footer">
                {!! Form::submit('Sync Products 10', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
            {!! Form::open(['url' => 'admin/sync-upload-products/sync-leemarpet-by-sheet/50']) !!}
            <div class="box-footer">
                {!! Form::submit('Sync Products 50', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
            {!! Form::open(['url' => 'admin/sync-upload-products/sync-leemarpet-by-sheet/100']) !!}
            <div class="box-footer">
                {!! Form::submit('Sync Products 100', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
            {!! Form::open(['url' => 'admin/sync-upload-products/sync-leemarpet-by-sheet/300']) !!}
            <div class="box-footer">
                {!! Form::submit('Sync Products 300', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @else
            <label class="label label-danger" for="">Need To Map the Categories, go Categories Validation Module and map
                the categories</label>
        @endif
    </div>
</section>
<script>
    phillips_api_products = "{{ $total_api_products }}";
    phillips_synced_products = "{{ $synced_products }}";
    phillips_not_synced_products = "{{ $not_synced_products }}";
</script>

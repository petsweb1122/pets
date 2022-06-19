<style>
    .select2-container .select2-selection--single{
        height: 30px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: #000;
    }
</style>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Product Form</h3>
    </div>
    @php
    $errors = session()->get('errors');
    $message = !empty(session()->get('message')) ? session()->get('message') : '';
    $message_class = !empty(session()->get('error')) ? 'label-danger' : 'label-success';
    @endphp
    <div class="{{$message_class}} text-center">{{!empty(session()->get('message')) ? session()->get('message') : ''}}</div>
    @if(!empty($errors))
    <ul class="">
        @foreach($errors as $error)
        <li class="text-danger">{{$error}}</li>
        @endforeach
    </ul>
    @endif
    {!! Form::open(['url' => 'admin/products/edit/'.request()->product_id.'/']) !!}
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-12 input-group-lg">
                {!! Form::label('title', 'Product Title:') !!}
                {!! Form::text('title', !empty($product->title) ? $product->title: '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-12 input-group-sm">
                {!! Form::label('description', 'Product Description:') !!}
                {!! Form::textarea('description', !empty($product->description) ? $product->description: '', ['class' => 'form-control description-area']) !!}
            </div>
            <div class="form-group col-md-12 input-group-sm">
                {!! Form::label('ingredients', 'Product Ingredients:') !!}
                {!! Form::textarea('ingredients', '', ['class' => 'form-control description-area']) !!}
            </div>
            <div class="form-group col-md-3 input-group-sm">
                {!! Form::label('status', 'Product Status:') !!}
                {!! Form::select('status', ['published' => 'published', 'draft' => 'draft', 'closed' => 'closed'], 'published', ['class' => 'form-control']) !!}
            </div>
            @if (!empty($categories))
                <div class="form-group col-md-3 input-group-sm">
                    {!! Form::label('all_categories', 'Categories:') !!}
                    {!! Form::select('all_categories[]', $categories, !empty($product->cat_ids) ? $product->cat_ids: [], ['class' => 'form-control  select-multiple', 'multiple' => 'multiple']) !!}
                </div>
            @endif
            @if (!empty($brands))
                <div class="form-group col-md-3 input-group-sm">
                    {!! Form::label('all_brands', 'Brand:') !!}
                    {!! Form::select('all_brands', $brands, !empty($product->brand) ? $product->brand : '', ['class' => 'form-control  select-single']) !!}
                </div>
            @endif
            @if (!empty($vendors))
                <div class="form-group col-md-3 input-group-sm">
                    {!! Form::label('all_vendors', 'Vendor:') !!}
                    {!! Form::select('all_vendors', $vendors, !empty($product->vendor) ? $product->vendor : '', ['class' => 'form-control  select-single']) !!}
                </div>
            @endif
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Variation Size Area:</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="label label-danger" id="error_message_size"></div>
                    <div class="label label-success" id="success_message_size"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="label label-danger" id="error_message_size"></div>
                    <div class="label label-success" id="success_message_size"></div>
                </div>
                <div class="form-group col-md-5">
                    @if (!empty($sizes))
                        {!! Form::label('all_sizes', 'Size:') !!}
                        {!! Form::select('all_sizes', $sizes, '', ['class' => 'form-control  select-single']) !!}
                    @endif
                </div>
                <div class="form-group col-md-1 input-group-sm">
                    <br>
                    {!! Form::button('Add Size',['class' => 'btn btn-success form-control', 'id' => 'add_size']) !!}
                </div>
            </div>

            @if (!empty(session()->get('size_results')))
                @foreach (session()->get('size_results') as $size)
                    {!! $size !!}
                @endforeach
            @endif

        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Update Product' ,['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>

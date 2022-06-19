@php
$product_id = request()->product_id;
@endphp
@php
$errors = session()->get('errors');
$message = !empty(session()->get('message')) ? session()->get('message') : '';
$message_class = !empty(session()->get('error')) ? 'label-danger' : 'label-success';
@endphp
<div class="{{ $message_class }} text-center">{{ !empty(session()->get('message')) ? session()->get('message') : '' }}
</div>
@if (!empty($errors))
    <ul class="">
        @foreach ($errors as $error)
            <li class="text-danger">{{ $error }}</li>
        @endforeach
    </ul>
@endif
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Upload Product Images</h3>
    </div>
    @include('common.show_messages')
    {!! Form::open(['url' => 'admin/products/' . request()->product_id . '/upload-image', 'files' => true]) !!}
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-12 input-group-lg">
                {!! Form::label('product_images', 'Upload Images:') !!}
                {!! Form::file('product_images[]', ['multiple' => 'multiple', 'id' => 'product_images']) !!}
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Product Images:</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                @foreach ($all_images as $item)
                    <div class="image-container-boundry">
                        <div class="images-container required" data-image_number={{ $item['image_number'] }}>
                            <div class="product-color-images">
                                <img class="" src="{{ $item['image'] }}"
                                    alt="{{ $item['number'] }}">
                            </div>
                        </div>
                        <a href="{{ url("admin/products/$product_id/remove-image/$item[image_number]") }}"
                            class="remove-btn btn btn-info" title="Remove Product Image">Remove Image</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Upload Product Images', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>

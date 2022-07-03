<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Map Category Form</h3>
        <h4><b>Map With: </b> {{$cat_obj->map_name}} ({{$cat_obj->map_bread}})</h4>
    </div>
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
    @php
        $vendor_id = request()->vendor_id;
        $cat_id = request()->cat_id;
    @endphp
    {!! Form::open(['url' => "admin/category-validation/all-vendor-category-$vendor_id/$cat_id"]) !!}
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('title', 'Category Title:') !!} -- {!! Form::label('name', $cat_obj->category_name) !!} ({!! $cat_obj->category_breadcrumb !!})
            </div>
            <div id="parent_category">
                <div class="form-group parent-category col-md-6">
                    {!! Form::label('parent_category', 'Select Category For Map:') !!}
                    {!! Form::select('parent_category[]', !empty($categories) ? $categories : [], null, ['class' => 'form-control single-category' , 'multiple' => 'multiple']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Map Category', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>

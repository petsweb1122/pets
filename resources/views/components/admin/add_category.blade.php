<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Add Category Form</h3>
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
    {!! Form::open(['url' => 'admin/category/add-category', 'files' => true]) !!}
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('title', 'Category Title:') !!}
                <div>{!! Form::text('title', '', ['class' => 'form-control']) !!}</div>
            </div>
            <div id="parent_category">
                <div class="form-group parent-category col-md-6">
                    {!! Form::label('parent_category', 'Select Parent Category:') !!}
                    {!! Form::select('parent_category', !empty($categories) ? $categories :[], null ,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12 input-group-lg">
                {!! Form::label('cat_image', 'Upload Image:') !!}
                {!! Form::file('cat_image', [ 'id' => 'cat_images']) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Add Category' ,['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>

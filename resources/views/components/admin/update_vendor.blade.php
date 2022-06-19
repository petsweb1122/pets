<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Update Vendor Form</h3>
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
    {!! Form::open(['url' => 'admin/vendor/update-vendor']) !!}
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('title', 'Vendor Title:') !!}
                <div>{!! Form::text('title', $vendor->title, ['class' => 'form-control']) !!}</div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Update Vendor' ,['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>

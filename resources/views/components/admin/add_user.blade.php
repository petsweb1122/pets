<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Add User Form</h3>
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
    {!! Form::open(['url' => 'admin/users/add-user', 'files' => true]) !!}
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('first_name', 'First Name:') !!}
                {!! Form::text('first_name', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('last_name', 'Last Name:') !!}
                {!! Form::text('last_name', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('user_name', 'User Name:') !!}
                {!! Form::text('user_name', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('email', 'E-Mail Address') !!}
                {!! Form::text('email', '', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('retype_password', 'Retype Password:') !!}
                {!! Form::password('retype_password', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('','Gender:') !!}
                <br>
                {!! Form::label('gender', 'Fe-Male:') !!}
                {!! Form::radio('gender', 'fe-male',false ,['class' => 'flat-red' , 'id' => 'fe_male']) !!}
                &nbsp;&nbsp;
                {!! Form::label('gender', 'Male:') !!}
                {!! Form::radio('gender', 'male',true ,['class' => 'flat-red', 'id' => 'male']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('dob', 'Date Of Birth:') !!}
                {!! Form::date('dob', '' ,['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('role', 'Role:') !!}
                {!! Form::select('role', ['super-admin' => 'super-admin' , 'developer' => 'developer', 'vendor' => 'vendor' ,'customer' => 'customer'] ,0,['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('vendor', 'Vendors:') !!}
                {!! Form::select('vendor', !empty($vendors) ?  $vendors : [] , '',['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('profile_image', 'Profile Image:') !!}
                {!! Form::file('profile_image') !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Registration' ,['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>

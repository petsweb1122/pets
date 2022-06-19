<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Profile</h3>
    </div>
    <div class="box-body  box-profile">
        <div class="row">
            <div class="form-group col-md-12">
                <img class="profile-user-img img-responsive img-circle" src="{{ $user_update_data->image->l }}"
                    alt="{{ $user_update_data->name }}">

                <h3 class="profile-username text-center">{{ $user_update_data->name }} {{ $user_update_data->last_name }}</h3>

                <p class="text-muted text-center">{{ $user_update_data->role }}</p>

                <div class="col-md-6 col-md-offset-3">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right" title="Email">{{ $user_update_data->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Gender</b> <a class="pull-right" title="Gender">{{ $user_update_data->gender }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Date Of Birth</b> <a
                                class="pull-right" title="DOB">{{ Carbon\Carbon::parse($user_update_data->dateofbirth)->format('d F Y') }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Member Since:</b> <a
                                class="pull-right" title="Member since">{{ Carbon\Carbon::parse($user_update_data->created_at)->format('d F Y') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
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
        <h3 class="box-title">Profile update Form</h3>
        {!! Form::open(['url' => '/admin/users/profile-update', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-6  col-md-offset-3">
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('first_name', 'First Name:') !!}
                        {!! Form::text('first_name', $user_update_data->name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('last_name', 'Last Name:') !!}
                        {!! Form::text('last_name', $user_update_data->last_name, ['class' => 'form-control']) !!}
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
                        {!! Form::label('', 'Gender:') !!}
                        <br>
                        {!! Form::label('gender', 'Fe-Male:') !!}
                        {!! Form::radio('gender', 'fe-male', $user_update_data->gender == 'fe-male' || $user_update_data->gender == 'Fe-Male' ? true : false, ['class' => 'flat-red', 'id' => 'fe_male']) !!}
                        &nbsp;&nbsp;
                        {!! Form::label('gender', 'Male:') !!}
                        {!! Form::radio('gender', 'male', $user_update_data->gender == 'male' || $user_update_data->gender == 'Male' ? true : false, ['class' => 'flat-red', 'id' => 'male']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('dob', 'Date Of Birth:') !!}
                        {!! Form::date('dob', '', ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('profile_image', 'Profile Image:') !!}
                        {!! Form::file('profile_image') !!}
                    </div>
                </div>
                {!! Form::submit('Update', ['class' => 'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

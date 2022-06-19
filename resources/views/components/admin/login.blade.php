<div class="login-box">
    <div class="login-logo">
        <b><a href="{{url('/')}}" title="Home">Petssified Admin Login</a></b>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @php
        $errors = session()->get('errors');
        $message = !empty(session()->get('message')) ? session()->get('message') : '';
        $message_class = !empty(session()->get('errors')) ? 'label-danger' : 'label-success';
        @endphp
        <div class="{{$message_class}} text-center">{{!empty(session()->get('message')) ? session()->get('message') : ''}}</div>
        @if(!empty($errors))
        <ul class="">
            @foreach($errors as $error)
            <li class="text-danger">{{$error}}</li>
            @endforeach
        </ul>
        @endif

        {!! Form::open(['url' => 'admin/login']) !!}
        <span id="valid-msg" class="hide text-success">✓ Valid</span>
        <span id="error-msg" class="hide text-danger"></span>
        <div class="form-group has-feedback">
            {!! Form::email('email', '', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group has-feedback">
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {!! Form::checkbox('checkbox') !!}
                    {!! Form::label('Remember Me') !!}
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                {!! Form::submit('Sign In' ,['class' => 'btn btn-primary btn-block btn-flat']) !!}
            </div>
            <!-- /.col -->
        </div>
        {!! Form::close() !!}
        <a href="#" title="Forgot Password">I forgot my password</a><br>

    </div>
    <!-- /.login-box-body -->
</div>

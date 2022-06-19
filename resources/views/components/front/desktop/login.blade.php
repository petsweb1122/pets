<div class="login page-height">
    <div class="container">
        <div class="row">
            <div class="col-md-8 logo text-center">
                <p><a title="Home" href="{{ url('/') }}"><img alt="Logo" width="80%" height=""
                            src="{{ asset('front/img/login-logo.png') }}"></a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 form-width">
                <div class="block">
                    <p>Login here:</p>
                </div>

                @php
                    $errors = session()->get('errors');
                    $message = !empty(session()->get('message')) ? session()->get('message') : '';
                    $message_class = !empty(session()->get('errors')) ? 'label-danger' : 'label-success';
                @endphp
                @if (!empty(session()->get('message')))
                    <div class="error-block">
                        <h4>{{ session()->get('message') }}</h4>
                    </div>
                @endif
                @if (!empty(session()->get('errors')))
                    @foreach (session()->get('errors') as $error)
                        <div class="alert alert-warning" role="alert">
                            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-triangle"
                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                class="svg-inline--fa fa-exclamation-triangle fa-w-18 fa-2x">
                                <path fill="currentColor"
                                    d="M270.2 160h35.5c3.4 0 6.1 2.8 6 6.2l-7.5 196c-.1 3.2-2.8 5.8-6 5.8h-20.5c-3.2 0-5.9-2.5-6-5.8l-7.5-196c-.1-3.4 2.6-6.2 6-6.2zM288 388c-15.5 0-28 12.5-28 28s12.5 28 28 28 28-12.5 28-28-12.5-28-28-28zm281.5 52L329.6 24c-18.4-32-64.7-32-83.2 0L6.5 440c-18.4 31.9 4.6 72 41.6 72H528c36.8 0 60-40 41.5-72zM528 480H48c-12.3 0-20-13.3-13.9-24l240-416c6.1-10.6 21.6-10.7 27.7 0l240 416c6.2 10.6-1.5 24-13.8 24z"
                                    class=""></path>
                            </svg> {{ $error }}
                        </div>
                    @endforeach
                @endif

                {!! Form::open(['url' => 'admin/login']) !!}

                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input id="email" type="email" class="form-control" name="email" value="" required
                                autocomplete="email" autofocus placeholder="abc@example.com">

                            <span class="invalid-feedback" role="alert">
                                <strong>Invalid</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id=""><svg aria-hidden="true" focusable="false"
                                        data-prefix="fas" data-icon="lock-alt" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                        class="svg-inline--fa fa-lock-alt fa-w-14">
                                        <path fill="currentColor"
                                            d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zM264 392c0 22.1-17.9 40-40 40s-40-17.9-40-40v-48c0-22.1 17.9-40 40-40s40 17.9 40 40v48zm32-168H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"
                                            class=""></path>
                                    </svg></span>
                            </div>
                            <input id="password" type="password" class="form-control" name="password" required
                                autocomplete="current-password" placeholder="Enter password">


                            <span class="invalid-feedback" role="alert">
                                <strong>
                                    Validation Error</strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" <label
                                class="form-check-label" for="remember">
                            Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                    <div class="col-md-12 text-center">
                        <p class="bottom-link"><a title="Register" href="{{ url('/register.html') }}"
                                class="text-warning">
                                Register
                            </a> | <a title="Reset Password" href="{{ url('/password-reset-email.html') }}"
                                class="text-warning">
                                Forgot Your Password?
                            </a>
                        </p>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

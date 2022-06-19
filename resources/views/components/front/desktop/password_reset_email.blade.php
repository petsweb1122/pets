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
                    <p>Enter you registered email to reset password:</p>
                </div>
                @if (!empty(session()->get('errors')))
                        @foreach (session()->get('errors') as $error)
                            <div class="alert alert-warning" role="alert">
                                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-triangle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-exclamation-triangle fa-w-18 fa-2x"><path fill="currentColor" d="M270.2 160h35.5c3.4 0 6.1 2.8 6 6.2l-7.5 196c-.1 3.2-2.8 5.8-6 5.8h-20.5c-3.2 0-5.9-2.5-6-5.8l-7.5-196c-.1-3.4 2.6-6.2 6-6.2zM288 388c-15.5 0-28 12.5-28 28s12.5 28 28 28 28-12.5 28-28-12.5-28-28-28zm281.5 52L329.6 24c-18.4-32-64.7-32-83.2 0L6.5 440c-18.4 31.9 4.6 72 41.6 72H528c36.8 0 60-40 41.5-72zM528 480H48c-12.3 0-20-13.3-13.9-24l240-416c6.1-10.6 21.6-10.7 27.7 0l240 416c6.2 10.6-1.5 24-13.8 24z" class=""></path></svg> {{$error}}
                            </div>
                        @endforeach
                @endif


                <div class="">
                @if (!empty(session()->get('message')))
                    <div class="alert {{!empty(session()->get('message')) ? 'alert-success' : ''}} " role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"
                                data-prefix="far" data-icon="check-circle" class="svg-inline--fa fa-check-circle fa-w-16"
                                role="img" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z" />
                            </svg> {{ session()->get('message') }}
                    </div>
                @endif
                    <form method="POST" action="{{url('/password-reset-email.html')}}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                    </div>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                                        autocomplete="email" autofocus placeholder="abc@example.com">

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Invalid</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

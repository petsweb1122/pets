
   
    <div class="login page-height">
        <div class="container">
            <div class="row">
                <div class="col-md-8 logo text-center">
                    <p><a title="Home" href="{{ url('/') }}"><img alt="logo" width="80%" height="" src="{{asset('front/img/login-logo.png')}}"></a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 form-width">
                    <div class="block">
                        <p>Reset your password:</p>
                    </div>
                    <form method="POST" action="">
                        <input type="hidden" name="token" value="">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                    </div>

                                    <input id="email" type="email" class="form-control"
                                        name="email" value="" required autocomplete="email"
                                        autofocus placeholder="abc@example.com">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Invalid</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id=""><svg aria-hidden="true" focusable="false" 
                                        data-prefix="fas" data-icon="lock-alt" role="img" xmlns="http://www.w3.org/2000/svg" 
                                        viewBox="0 0 448 512" class="svg-inline--fa fa-lock-alt fa-w-14"><path fill="currentColor" d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zM264 392c0 22.1-17.9 40-40 40s-40-17.9-40-40v-48c0-22.1 17.9-40 40-40s40 17.9 40 40v48zm32-168H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" class=""></path></svg></span>
                                    </div>
                                    <input id="password" type="password"
                                    class="form-control" name="password"
                                    required autocomplete="new-password" placeholder="Enter new password">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                        Invalid</strong>
                                    </span>
                                </div>
                            </div>
                   
                            <div class="col-md-6">
                                <div class="input-group mb-3">                               
                                    <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm password">
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="login page-height">
        <div class="container">
            <div class="row">
                <div class="col-md-8 logo text-center">
                    <p><a href="{{ url('/') }}" title="Home"><img alt="Logo" width="80%" height="" src="{{asset('front/img/login-logo.png')}}"></a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 form-width">
                    <div class="block">
                        <p>Fill the form to get registered::</p>
                    </div>
                    
                    @if (!empty(session()->get('message')))
                        <div class="error-block">
                            <h4>{{session()->get('message')}}</h4>
                        @endif
                        @if (!empty(session()->get('errors')))
                                @foreach (session()->get('errors') as $error)
                                <div class="alert alert-warning" role="alert">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-triangle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-exclamation-triangle fa-w-18 fa-2x"><path fill="currentColor" d="M270.2 160h35.5c3.4 0 6.1 2.8 6 6.2l-7.5 196c-.1 3.2-2.8 5.8-6 5.8h-20.5c-3.2 0-5.9-2.5-6-5.8l-7.5-196c-.1-3.4 2.6-6.2 6-6.2zM288 388c-15.5 0-28 12.5-28 28s12.5 28 28 28 28-12.5 28-28-12.5-28-28-28zm281.5 52L329.6 24c-18.4-32-64.7-32-83.2 0L6.5 440c-18.4 31.9 4.6 72 41.6 72H528c36.8 0 60-40 41.5-72zM528 480H48c-12.3 0-20-13.3-13.9-24l240-416c6.1-10.6 21.6-10.7 27.7 0l240 416c6.2 10.6-1.5 24-13.8 24z" class=""></path></svg> {{$error}}
                                </div>
                                @endforeach
                            </div>
                        @endif
                <form method="POST" action="{{ url('/register.html') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" 
                                        focusable="false" data-prefix="fas" data-icon="user" 
                                        class="svg-inline--fa fa-user fa-w-14" role="img" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg></span>
                                </div>
                                <input id="name" type="text" class="form-control" name="fname" value="" placeholder="First name">
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        Invalid</strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" 
                                        focusable="false" data-prefix="fas" data-icon="user" 
                                        class="svg-inline--fa fa-user fa-w-14" role="img" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg></span>
                                </div>                            
                                <input id="lname" type="text" class="form-control" name="lname" value="" placeholder="Last name">
                                <span class="invalid-feedback" role="alert">
                                    <strong>Invalid</strong>
                                </span>
                            </div>
                        </div>
                                         
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                                <input id="email" type="email" class="form-control" name="email" value=""
                                    autocomplete="email" placeholder="abc@example.com">
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        Invalid</strong>
                                </span>
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" 
                                        data-icon="lock-alt" role="img" xmlns="http://www.w3.org/2000/svg" 
                                        viewBox="0 0 448 512" class="svg-inline--fa fa-lock-alt fa-w-14">
                                        <path fill="currentColor" d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zM264 392c0 22.1-17.9 40-40 40s-40-17.9-40-40v-48c0-22.1 17.9-40 40-40s40 17.9 40 40v48zm32-168H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" class=""></path></svg></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="password"
                                autocomplete="new-password" placeholder="Enter password">
                                <span class="invalid-feedback" role="alert">
                                <strong>Invalid</strong>
                                </span>
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                        <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" 
                                        data-icon="lock-alt" role="img" xmlns="http://www.w3.org/2000/svg" 
                                        viewBox="0 0 448 512" class="svg-inline--fa fa-lock-alt fa-w-14">
                                        <path fill="currentColor" d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zM264 392c0 22.1-17.9 40-40 40s-40-17.9-40-40v-48c0-22.1 17.9-40 40-40s40 17.9 40 40v48zm32-168H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" class=""></path></svg></span>
                                </div>
                                <input id="retype_password" type="password" class="form-control"
                                    name="retype_password" placeholder="Confirm password">
                            </div>
                        </div>
                    </div>

                    <div class="row gender">
                        <div class="col-md-4">
                            <label for="gender" class="col-form-label">
                                Select Gender: </label>
                        </div>    
                        <div class="col-md-4 gender-choice">
                            <input type="radio" class="" name="gender" value="Male">
                            <label for="gender" class="">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="male" 
                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" 
                            class="svg-inline--fa fa-male fa-w-6"><path fill="currentColor" 
                            d="M96 0c35.346 0 64 28.654 64 64s-28.654 64-64 64-64-28.654-64-64S60.654 0 96 0m48 144h-11.36c-22.711 10.443-49.59 10.894-73.28 0H48c-26.51 0-48 21.49-48 48v136c0 13.255 10.745 24 24 24h16v136c0 13.255 10.745 24 24 24h64c13.255 0 24-10.745 24-24V352h16c13.255 0 24-10.745 24-24V192c0-26.51-21.49-48-48-48z" class=""></path></svg> Male </label>
                        </div>
                        <div class="col-md-4 gender-choice">
                            <input type="radio" class="" name="gender" value="Fe-Male">
                            <label for="gender" class="">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="female" 
                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" 
                            class="svg-inline--fa fa-female fa-w-8"><path fill="currentColor" 
                            d="M128 0c35.346 0 64 28.654 64 64s-28.654 64-64 64c-35.346 0-64-28.654-64-64S92.654 0 128 0m119.283 354.179l-48-192A24 24 0 0 0 176 144h-11.36c-22.711 10.443-49.59 10.894-73.28 0H80a24 24 0 0 0-23.283 18.179l-48 192C4.935 369.305 16.383 384 32 384h56v104c0 13.255 10.745 24 24 24h32c13.255 0 24-10.745 24-24V384h56c15.591 0 27.071-14.671 23.283-29.821z" class=""></path></svg> Female </label>
                            <span class="invalid-feedback" role="alert">
                                <strong>Invalid</strong>
                            </span>
                        </div>
                    
                        <div class="col-md-12">
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="consent" id="consent"
                                    class="form-check-label" for="consent">
                                <p class="" style="font-size:16px">I agree to the <a
                                        title="Terms & Conditions" class="text-primary" style="font-size:16px"
                                        href="https://petssified.com/terms-and-conditions">terms & conditions</a> & <a
                                        title="Privacy Policy" style="font-size:16px" class="text-primary"
                                        href="https://petssified.com/privacy-policy">privacy policy</a></p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Register">
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-white">Already Have an Account? <a title="Login" href="{{ url('/admin/login') }}"
                                class="text-warning">Login
                                Here</a></span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</div>

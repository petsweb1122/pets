<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Profile</h3>
    </div>
    <div class="box-body  box-profile">
        <div class="row">
            <div class="form-group col-md-12">
                <img class="profile-user-img img-responsive img-circle" src="{{ $user_data->images->l }}"
                    alt="{{ $user_data->name }}">

                <h3 class="profile-username text-center">{{ $user_data->name }} {{ $user_data->last_name }}</h3>

                <p class="text-muted text-center">{{$user_data->role_name}}</p>

                <div class="col-md-6 col-md-offset-3">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right" title="Email">{{$user_data->email}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Mobile Number</b> <a class="pull-right" title="Mobile number">{{$user_data->mobile_number}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Gender</b> <a class="pull-right" title="Gender">{{$user_data->gender}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Date Of Birth</b> <a class="pull-right" title="DOB">{{Carbon\Carbon::parse($user_data->dob)->format('d F Y')}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Email Verified User:</b> <a class="pull-right" title="Email verified user">{{!empty($user_data->email_verified) ? 'Yes' : 'No'}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>OTP Verified User:</b> <a class="pull-right" title="OTP verified user">{{!empty($user_data->otp_verified) ? 'Yes' : 'No'}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Member Since:</b> <a class="pull-right" title="Member since">{{Carbon\Carbon::parse($user_data->created_at)->format('d F Y')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
    </div>
</div>

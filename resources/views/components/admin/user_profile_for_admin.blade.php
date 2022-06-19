<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $user_data_show->name }} {{ $user_data_show->last_name }}: Profile</h3>
    </div>
    <div class="box-body  box-profile">
        <div class="row">
            <div class="form-group col-md-12">
                <img class="profile-user-img img-responsive img-circle" src="{{ $user_data_show->images->l }}"
                    alt="{{ $user_data_show->name }}">

                <h3 class="profile-username text-center">{{ $user_data_show->name }} {{ $user_data_show->last_name }}</h3>

                <p class="text-muted text-center">{{$user_data_show->role}}</p>

                <div class="col-md-6 col-md-offset-3">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right" title="Email">{{$user_data_show->email}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Gender</b> <a class="pull-right" title="Gender">{{$user_data_show->gender}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Date Of Birth</b> <a class="pull-right"  title="DOB">{{Carbon\Carbon::parse($user_data_show->dateofbirth)->format('d F Y')}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Member Since:</b> <a class="pull-right" title="Member Since">{{Carbon\Carbon::parse($user_data_show->created_at)->format('d F Y')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
    </div>
</div>

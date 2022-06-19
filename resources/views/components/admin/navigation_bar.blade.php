<style>
.skin-blue .main-header .logo, .skin-blue .main-header .logo:hover {
    background-color: #f9fafc;
}
.skin-blue .main-header .navbar {
    background-color: #4c883f;
}
.skin-blue .sidebar-menu>li.active>a {
    border-left-color: #dd4b39;
}
.box.box-primary {
    border-top-color: #4CAF50;
}
.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #4CAF50;
    border-color: #4CAF50;
}
</style>


<!-- Logo -->
<a href="{{url('/')}}" class="logo" title="Home">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img alt="Petssified" src="{{ url('front/img/favicon.gif') }}" style="width:50px"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img alt="Logo" src="{{ url('front/img/logo.gif') }}" style="width:98%"></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" title="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="user user-menu">
                <style>
                    .shopping-bag {
                        position: relative;
                        line-height: 50px;
                        vertical-align: middle;
                    }

                    .shopping-bag svg{
                        color: #fff !important;
                        width: 18px;
                        position:relative;
                        top: 4px;
                    }
                    .shopping-bag a{
                        color: #fff !important;
                    }
                </style>
                <span class="shopping-bag">
                    <a title="View Cart" href="{{url('/view-cart.html')}}"><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-shopping-bag fa-w-14"><path fill="currentColor" d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z" class=""></path></svg> Cart</a>
                </span>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="{{!empty($user_data) ? $user_data->name . ' ' .  $user_data->last_name: ''}}">
                    <img alt="User Image" src="{{!empty($user_data->image->m) ? $user_data->image->m : ''}}" class="user-image">
                    <span class="hidden-xs">{{!empty($user_data) ? $user_data->name . ' ' .  $user_data->last_name: ''}}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img alt="User Image" src="{{!empty($user_data->image->m) ? $user_data->image->m : ''}}" class="img-circle">

                        <p>
                            {{!empty($user_data) ? $user_data->name . ' ' .  $user_data->last_name: ''}} - {{!empty($user_data) ? ucfirst($user_data->role) : ''}}
                            <small>Member since - {{Carbon\Carbon::parse($user_data->created_at)->format('d F Y')}}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{url('/admin/users/profile-update')}}"  title="Profile" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{url('/user/logout')}}" class="btn btn-default btn-flat" title="Sign out">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
        </ul>
    </div>
</nav>

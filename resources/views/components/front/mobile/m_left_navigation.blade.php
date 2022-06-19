<div class="mobile-navigation-panel">
    <div class="top-nav">
        <ul>
            @if (!empty($top_bar_categories))
                @foreach ($top_bar_categories as $key => $category)
                    <li class="left {{ request()->segment(1) == $category->breadcrumb ? 'active' : '' }}">
                        <a href="{{ url("/$category->breadcrumb") }}/" title="{{ url("$category->title") }}">
                            {{ $category->title }}
                        </a>
                    </li>
                @endforeach
            @endif
            <li class="left"><a title="Shop" href="{{ url('/shop.html') }}">Shop</a></li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="bottom-nav">
        <ul>
            <li><a href="{{ url('/dog') }}" title="Dog"><img class=" bg-white rounded-circle"
                        src="{{ url('front/img/category-img/dog.png') }}" alt="Dog"><span>Dog</span></a></li>
            <li><a href="{{ url('/cat') }}" title="Cat"><img class=" bg-white rounded-circle"
                        src="{{ url('front/img/category-img/cat.png') }}" alt="Cat"><span>Cat</span></a></li>
            <li><a href="{{ url('/domestic-bird') }}" title="Bird"><img class=" bg-white rounded-circle"
                        src="{{ url('front/img/category-img/bird.png') }}" alt="Bird"><span>Bird</span></a></li>
            <li><a href="{{ url('/aquatic') }}" title="Fish"><img class=" bg-white rounded-circle"
                        src="{{ url('front/img/category-img/fish.png') }}" alt="Fish"><span>Fish</span></a></li>
            <li><a href="{{ url('/reptile') }}" title="Reptile"><img class=" bg-white rounded-circle"
                        src="{{ url('front/img/category-img/reptile.png') }}" alt="Reptile"><span>Reptile</span></a></li>
            <li><a href="{{ url('/small-animal') }}" title="Small Animals"><img class=" bg-white rounded-circle"
                        src="{{ url('front/img/category-img/s-a.png') }}" alt="Small Animals"><span>Small Animals</span></a></li>
            <li><a href="{{ url('/large-animal-livestock') }}" title="Farm Animals"><img
                        class=" bg-white rounded-circle" src="{{ url('front/img/category-img/f-a.png') }}" alt="Farm Animals"><span>Farm
                        Animals</span></a></li>
            <li><a href="{{ url('/shop.html') }}" title="All products"><svg aria-hidden="true" focusable="false"
                        data-prefix="fal" data-icon="phone-laptop" role="img" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 640 512" class="svg-inline--fa fa-phone-laptop fa-w-20">
                        <path fill="currentColor"
                            d="M608 128H416a32 32 0 0 0-32 32v320a32 32 0 0 0 32 32h192a32 32 0 0 0 32-32V160a32 32 0 0 0-32-32zm0 352H416V160h192zM96 32h384v64h32V32a32 32 0 0 0-32-32H96a32 32 0 0 0-32 32v256H16a16 16 0 0 0-16 16v16a64.14 64.14 0 0 0 63.91 64H352v-32H63.91A32 32 0 0 1 32 320h320v-32H96z"
                            class=""></path>
                    </svg>&nbsp;&nbsp;&nbsp;View All Products</a></li>
            @if (empty(session()->get('user_data')))
                <li><a href="{{ url('/admin/login') }}" title="Login"><i
                            class="far fa-key"></i>&nbsp;&nbsp;&nbsp;Login</a></li>
                <li><a href="{{ url('/register') }}" title="Registration"><i class="far fa-user"></i>
                        &nbsp;Registration</a></li>
            @endif
            @if (!empty(session()->get('user_data')))
                <li><a href="{{ url('/admin/dashboard') }}" title="Dashboard">Dashboard</a></li>
                <li><a href="{{ url('/admin/orders') }}" title="My Orders">My Orders</a></li>
                <li><a href="{{url('/user/logout')}}" title="Sign out">Sign out</a></li>

            @endif
        </ul>
    </div>

    <span class="close-navigation-panel">X</span>
</div>
<div class="wrap-panel-navigation"></div>

<style>
.d{
    z-index: 9999;
}

.d .a {text-decoration: none;}

.d .container {
	margin: auto;
	width: 99%;
}
.container-fluid{
    background: #fff;
}

.d ul {
	padding-left: 0;
    margin-top: 0;
    margin-bottom: 0;
	list-style: none;
}

.d nav {
	background: #0ca0d6;
	font-size: 0;
	position: relative;
    
}

.d nav > ul > li {
	display: inline-block;
  	font-size: 14px;
  	padding: 0 15px;
  	position: relative;
    border-bottom: 3px solid #0ca0d6;
}

.d nav > ul > li.active {
    background: #8bc540;
    border-bottom: 3px inset #eee;
}

.d nav > ul > li > a {
	color: #fff;
  	display: block;
  	padding: 20px 0;
    transition: all .3s ease;
}
.d nav > ul > li:hover > a {
	color: #fff; 
}

.d nav > ul > li:hover {
    background: #8bc540;
    border-bottom: 3px solid #fff;
}

.d .mega-menu {
	background: #fefefe;
  	visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.5s linear;
  	position: absolute;
  	left: 0;
  	width: 100%;
    padding-bottom: 20px;
    z-index: 9999;
    box-shadow: 0px 5px 5px #ddd;
    zoom: .8;
}
.d .mega-menu h3 a{color: #d0011b; border: none; font-weight: 600}

.d .mega-menu .container {
    display: flex;
}
.d .mega-menu .item {
	flex-grow: 1;
    margin: 0 10px;
}
.d .mega-menu .item img {
    width: 100%;
}
.d .mega-menu a {
	border-bottom: 1px solid #ddd;
  	color: #0ca0d6;
  	display: block;
  	padding: 8px 0;
    line-height: 16px;
    font-weight: 400
}
.d .mega-menu a:hover {color: #2d6a91;}


.d .dropdown {position: static;}

.d .dropdown:hover .mega-menu {
    visibility: visible;
    opacity: 1;
}
.blinking {
   animation: background 1s ease-in-out infinite;
   color:red;
   position: absolute;
   bottom:10px;
   right:10px;
   padding:10px 20px !important;
   border-radius: 99px;
   text-align: center;
   width: 280px;
}

@keyframes background {
 0% {
   color:#fff;
   background: black;
 }

 100% {
 color:white;
 background: #8bc540;
}
}
</style>
<div class='d'>
<nav>
  <ul class="container">
    <li class="active"><a title="Home" href="{{url('/')}}">Home</a></li>
    <li class='dropdown'>
      <a href='#' title="Shop">Shop <i class="fa fa-angle-down"></i></a>
      <div class='mega-menu'>
      	<div class="container">
            @foreach ($left_cat_navigations as $key => $navs)
            @if ($key <= 5)
          <div class="item">
              <h3><a href="{{$navs['link']}}">{{$navs['title']}}</a></h3>
              <ul>
                @foreach ($navs['childs'] as $nav)
                    <li><a title="{{$nav['title']}}" href="{{$nav['link']}}">{{$nav['title']}}</a></li>
                @endforeach
              </ul>
          </div> <!-- /.item -->
          @endif
        @endforeach
        <a title="View All Products" href="{{ url('/shop.html') }}" class="blinking">View all Products</a>
        </div><!-- /.container -->
      </div><!-- /.mega-menu -->
    </li><!-- /.dropdown -->
    <!--li><a title="About Us" href='#'>About</a></li>
    <li><a href='#' title="Contact Us">Conatct</a></li-->
  </ul><!-- .container -->
</nav>

</div>

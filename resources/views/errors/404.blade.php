<style>

.not-found{
    text-align: center;
}
.not-found h1{
    font-size: 74px;
    margin: 0
}
.shop-icons {
    margin-bottom: 100px;
}
.content-area {
    padding-bottom: 4px;
    font-family: arial
}
</style>
<div class="content-area not-found">
    <a href="{{ url('/') }}" title="Petssified"> <img alt="Logo" src="{{ url('front/img/logo.gif') }}" style="width:250px"></a>

    <h1>404!</h1>
	
    <p><img style="width: 250px; text-align:center;" src="{{url('front/img/box.gif')}}" alt="Empty cart"><br>
    <sub>We’ve dug around for the page you tried to reach, but can’t seem to find it.</sub><br>
    <hr>
    <strong>Start shopping pet products from a wide selection of premium pet food, toys, treats, and supplies!<br>
    <a href="{{ url('/shop.html') }}" title="Shop">Click here to start shopping</a>


</strong>
    </p>
</div>
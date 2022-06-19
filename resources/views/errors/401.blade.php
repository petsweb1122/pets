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
    font-family: arial !important;
}
</style>
<div class="content-area not-found">
    <a href="{{ url('/') }}" title="Petssified Logo"> <img alt="Logo" src="{{ url('front/img/logo.gif') }}" style="width:250px"></a>

    <h1>401!</h1>
	
    <p><img alt="Empty cart" style="width: 250px; text-align:center;" src="{{url('front/img/box.gif')}}"></p>
    <h3>You are not authorised to access this page...</h3>
    <hr>
    <a href="{{ url('/') }}" title="Home">Go to Petssified.com</a>

</strong>
    </p>
</div>
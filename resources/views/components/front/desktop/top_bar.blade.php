<style>
    .top-bar-menu {
        float: right;
        margin-top: 8px;
    }

    .top-bar-menu a {
        font-size: 16px;
        color: #333;
        text-align: left;
        padding: 14px 16px;
        text-decoration: none;
    }

    .subnav {
        display: inline-block;
        overflow: hidden;
    }

    .subnav .subnavbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: #333;
        padding: 10px 2px;
        background-color: inherit;
        font-family: inherit;
        margin: auto 5px;
    }

    .top-bar-menu a:hover,
    .subnav:hover .subnavbtn {
        color: #777
    }

    .subnav-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        border-radius: 8px 0 0px 8px;
        width: 100%;
        max-width: 280px;
        z-index: 1;
        box-shadow: 0px 4px 8px #333;
        max-height: 350px;
        overflow-y: scroll;
        margin-top: -3px;
        zoom: .8;
    }

    .subnav-content a {
        color: #099ad1;
        text-decoration: none;
    }

    .my-account a {
        color: #333 !important;
    }

    .subnav-content a:hover {
        background-color: #ddd;
        color: black;
    }

    .subnav:hover .subnav-content {
        display: block;
    }

    .cart-dropdown {
        vertical-align: top;
        font-size: 12px;

    }

    .cart-dropdown .remove-cart-item {
        color: #dc0505;
        font-size: 24px;
        opacity: .6;
    }

    .cart-dropdown .remove-cart-item:hover {
        opacity: 1;
    }

    .cart-dropdown img {
        height: 40px;
        width: 40px;
        border-radius: 4px;
        padding: 2px;
        border: 1px solid #eee;
    }

    .cart-dropdown tr td {
        padding: 6px;
        border-bottom: 1px dotted #eee
    }

    .cart-dropdown a {
        text-align: inherit;
        padding: 4px;
        font-size: 14px;
        background: transparent;
        font-weight: 300;
        display: inline-block;
        margin-bottom: 10px;
    }

    .cart-dropdown a:hover {
        background-color: transparent;
        color: #4c883f
    }

    .cart-dropdown .cart-item-name {
        width: 160px
    }

    .cart-dropdown .cart-item-price {
        text-align: right !important
    }

    .cart-product-name {
        font-size: 12px;
        color: #555 !important;
        font-weight: normal;
    }

    .cart-qty {
        font-size: 14px;
        color: #555;
        font-weight: 600;
    }

    .cart-price {
        font-size: 14px;
        color: #555;
        margin: 6px 0px 6px 6px;
        font-weight: 600
    }

    .weight-lbs {
        padding: 3px 10px;
        font-size: 14px;
        top: 5px;
        left: 16px;
        color: #fff;
        background: green;
        border-radius: 5px;
        font-weight: bold;
        margin-left: 10px;
    }

    .sub-total {
        background: #fff;
    }

    .cart-subtotal {
        font-size: 20px;
        color: #d0011b;
        margin: 6px;
        font-weight: 600;
    }

    .cart-subtotal-title {
        text-align: left;
    }

    .cart-dropdown img {
        height: auto;
        width: 40px;
        border-radius: 4px;
        padding: 0px;
        border: 0px solid #eee;
        max-width: 40px;
        max-height: 60px;
    }

    .remove-cart-item a {
        font-size: 16px !important;
        color: #dc0505;
        opacity: .9;
        border-right: 1px dotted #ccc;
        background: #eee;
    }

    .subnav-content {
        max-width: 320px;
    }

    .subnav-content .cart-dropdown {
        width: 300px;
    }

    .cart-dropdown .cart-item-name {
        width: auto;
        /* height: 150px !important; */
        /* padding: 40px; */
        display: inline-block;
        width: 210px;
        vertical-align: middle;
    }

    .cart-dropdown .checkout-button {
        /* margin-bottom:30px; */
        border: none;
        background-color: #81d742;
        display: inline-block;
        background-color: #7DC855;
        border-radius: 99px;
        font-size: 16px;
        color: #FFFFFF !important;
        width: 100%;
        text-decoration: none;
        padding: 12px 10px;
        transition: all .5s;
        box-shadow: 0px 0px 10px inset #4c883f;
        float: right;
    }

    .cart-dropdown .checkout-button:hover {
        background-color: #000;
    }

    .edit-cart {
        width: auto !important;
        text-align: left !important;
        border: 0px solid #8bc540 !important;
        margin-left: 3px !important;
        font-weight: bold !important;
        font-size: 16px !important;
        color: blue !important;
        padding: 2px 0 !important;
        margin: 0 !important;
        background-color: transparent !important;
        opacity: .6;
        text-decoration: underline !important;
        float: right !important;

    }

    .container-single-cart {
        width: 100%;
        display: block;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .container-single-cart .remove-cart-item {
        width: 30px;
        background: #ddd;
        padding: 4px;
        border-radius: 4px;
        font-size: 18px;
    }

    .container-single-cart .product-thumb {
        display: inline-block;
        width: 40px;
        height: 40px;
        vertical-align: middle;
    }

    .container-single-cart .cart-price-total {
        display: block;
        /* text-align: end; */
        float: right;
        font-size: 16px;
        color: #d0011b;
        margin: 0;
        font-weight: 600;
    }

    .search-group {
        display: block;
        position: relative;
    }

    .searchTitle {
        width: 100%;
        border-radius: 99px;
    }

    .searchBtn {
        position: absolute;
        right: 0;
        top: 0;
        background: #8bc540;
        border: none;
        padding: 11px;
        border-radius: 0 99px 99px 0;
    }

    .searchBtn * {
        color: #fff;
    }

    .logo-col,
    .search-col,
    .user-menu {
        display: inline-block;
        vertical-align: bottom;
        width: 35%;
    }

    .user-menu {
        width: 26%;
        float: right;
    }
</style>
@php
// dd();
foreach ($carts as $key => $cart) {
    // dd();
}
@endphp
<div class='container'>
    <div class='logo-col'>
        <a title="Home" href="{{ url('/') }}"> <img alt="Logo" src="{{ url('front/img/logo.gif') }}"
                style="width:250px"></a>
    </div>
    <div class='search-col'>
        <form action="{{ url('/search.html') }}" method="GET" class="">
            <div class="search-group">
                <input type="text" name="q" class="searchTitle" placeholder="What are you looking for?">
                <button type="submit" class="searchBtn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class='user-menu'>
        <div class="top-bar-menu">
            <div class="subnav">
                @php
                    $user_data = json_decode(session()->get('user_data'));
                @endphp
                <button class="subnavbtn"><i class="fa fa-user"></i> My Account <i
                        class="fa fa-caret-down"></i></button>
                <div class="subnav-content my-account">
                    @if (empty($user_data))
                        <a title="Login" href="{{ url('/admin/login') }}"><i class="fa fa-key"></i> Login</a>
                        <a title="Create Account" href="{{ url('/register.html') }}"><i class="fa fa-user"></i>
                            Create Account</a>
                    @endif
                    @if (!empty($user_data))
                        <a title="My Orders" href="{{ url('/admin/customer-orders/all-customer-orders') }}"><i
                                class="fas fa-chart-pie"></i>
                            My Orders</a>
                        <a title="My Cart" href="{{ url('/view-cart.html') }}"><i class="fas fa-cart-plus"></i> My
                            Cart</a>
                        <a title="Checkout" href="{{ url('/checkout.html') }}"><i class="fa fa-check"></i>
                            Checkout</a>
                        <a title="Logout" href="{{ url('/user/logout') }}"><i class="fas fa-sign-out-alt"></i>
                            Logout</a>
                    @endif

                </div>
            </div>
            <div class="subnav">
                <button class="subnavbtn">Cart <i class="fa fa-caret-down"></i></button>
                <div class="subnav-content">
                    <table class="cart-dropdown">
                        <tr class="sub-total">
                            <td colspan="3" class="cart-subtotal-title">
                                <a href="{{ url('/view-cart.html') }}" title="View Cart" class="edit-cart"> Edit
                                    Cart</a>
                                Cart Subtotal: <span class="cart-subtotal"
                                    id="top_bar_sub_total">${{ number_format($cart_total, 2) }}</span>
                            </td>
                        </tr>
                        <tr class="cart-buttons">
                            <td colspan="4">
                                <a title="Checkout" href="{{ url('/checkout.html') }}" title="Checkout"
                                    class="checkout-button">Proceed to
                                    Checkout</a>
                            </td>
                        </tr>

                        <tr>

                            <td id="add_to_cart_ajax">
                                @foreach ($carts as $cart)
                                    <div class="container-single-cart">
                                        <span class="remove-cart-item" data-key="{{ $cart['id'] }}"
                                            onclick="deleteCartItem(this)"><i class="fa fa-trash-alt"></i></span>
                                        <span class="product-thumb"><img alt="{{ $cart['name'] }}"
                                                src="{{ url($cart['attributes']['image']) }}"></span>
                                        <span class="cart-item-name">
                                            <a title="{{ $cart['name'] }}" href="#"
                                                class="cart-product-name">{{ $cart['name'] }}</a><br>
                                            <span
                                                class="cart-price">(${{ number_format($cart['price'], 2) }}</span>
                                            <span class="cart-qty">* {{ $cart['quantity'] }})</span>
                                            <span class="weight-lbs">{{ $cart['attributes']['weight'] }}
                                                lbs</span>
                                            <span
                                                class="cart-price-total">${{ number_format($cart['price'] * $cart['quantity'], 2) }}</span>
                                        </span>
                                    </div>
                                @endforeach
                            </td>
                        </tr>


                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* CART PAGE */
    .content-top {
        margin-top: 0px;
    }

    .cart-page {
        margin: 20px auto 50px;
    }

    .cart-page-inner {
        width: 90%;
    }

    .cart-page-title {
        background: #6c757d08;
        padding: 20px;
        font-size: 24px;
        text-align: center;
    }

    .cart-details {
        background: #fff;
        box-shadow: 0px 0px 2px inset #aaa;
        border-radius: 6px;
        margin-bottom: 10px;
        padding: 6px;
        display: block;
        font-size: 12px;
    }

    .cart-details .quantity input {
        min-width: 50px;
        max-width: 100px !important;
        padding: 6px;
        vertical-align: middle;
        margin: 0 6px;
    }

    .cart-page .cart-btn {
        display: inline-block;
        background-color: #7DC855;
        border-radius: 99px;
        font-size: 14px;
        color: #FFFFFF;
        text-decoration: none;
        padding: 10px 12px;
        transition: all .5s;
        box-shadow: 0px 0px 10px inset #4c883f;
        cursor: pointer;
        border: none;
        font-weight: 400;
    }

    .cart-page .cart-btn * {
        color: #fff;
    }

    .cart-page .cart-btn:hover {
        background-color: #64af3d;
    }

    .product-btns {
        text-align: right;
        padding: 4px 4px 0 4px;
        display: block;
        border-top: 1px solid #eee;
        width: 100%;
    }

    .product-img {
        display: block;
        width: 75px;
        height: 75px;
        text-align: left;
    }

    .product-img img {
        max-width: 90%;
        max-height: 90%;
    }

    .qtyamount {
        padding: 0;
        border: 0;
        display: inline-block;
        min-width: 30px;
        text-align: center;
        width: 30px;
        opacity: .7;
        vertical-align: inherit;
        font-weight: 600;
        background: transparent;
        padding: 0 !important;
    }

    .product-total-price {
        color: #d0011b;
        padding: 10px 0px;
        font-weight: 300;
        font-size: 16px;
        display: block;
    }

    .remove-product {
        float: left;
        margin-top: -6px;
    }

    .remove-product * {
        font-size: 34px;
        vertical-align: middle;
        color: red;
    }

    .cart-total {
        padding: 10px 0;
        margin: 20px 0;
        text-align: center;
    }

    .cart-total-amount {
        color: #d0011b;
        font-weight: 900;
        font-size: 18px;
    }

    .cart-bottom {
        text-align: center;
    }

    .cart-page .quantity {
        display: inline-block;
    }

    .cart-page span.update-wrap {
        display: inline-block;
        position: relative;
        padding: 0px;
        width: 84px;
    }

    .cart-page .update-wrap svg {
        position: absolute;
        left: 60px;
        top: 7px;
    }

    .cart-page .update-wrap input.update-product {
        background: none;
        border: none;
        margin-bottom: 0px;
    }

</style>

<div class="content content-top">
    @if (empty($carts))
    <div class="cart-page-title">
        <h4><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-triangle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-exclamation-triangle fa-w-18 fa-2x"><path fill="currentColor" d="M270.2 160h35.5c3.4 0 6.1 2.8 6 6.2l-7.5 196c-.1 3.2-2.8 5.8-6 5.8h-20.5c-3.2 0-5.9-2.5-6-5.8l-7.5-196c-.1-3.4 2.6-6.2 6-6.2zM288 388c-15.5 0-28 12.5-28 28s12.5 28 28 28 28-12.5 28-28-12.5-28-28-28zm281.5 52L329.6 24c-18.4-32-64.7-32-83.2 0L6.5 440c-18.4 31.9 4.6 72 41.6 72H528c36.8 0 60-40 41.5-72zM528 480H48c-12.3 0-20-13.3-13.9-24l240-416c6.1-10.6 21.6-10.7 27.7 0l240 416c6.2 10.6-1.5 24-13.8 24z" class=""></path></svg> Your Cart is Empty!</h4>
    </div>
    <div class="cart-page cart-page-inner center">
        <p><img style="width: 250px; text-align:center;margin-top:20px;" src="{{url('front/img/box.gif')}}" alt="Empty cart"><br>
                    <strong>Start shopping for your pet from a wide range of premium pet food, toys, treats, and supplies!</strong><hr>
                    <a title="Shop" href="{{ url('/shop.html') }}" name="go-shop" class="cart-btn" style="padding: 10px 50px;">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                            class="svg-inline--fa fa-shopping-bag fa-w-14">
                            <path fill="currentColor"
                                d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z"
                                class=""></path>
                        </svg> Go to Shop
                    </a>
        </p>
    </div>
    @else
        <div class="cart-page-title">
            <h4>Your Shopping Cart</h4>
        </div>
        <div class="cart-page cart-page-inner">

            <!-- Product Count -->

            <form action="{{ url('/cart/update-cart/') }}" method="post">
                @csrf
                @foreach ($carts as $cart)
                    <div class="cart-details">
                        <table>
                            <tr>
                                <td>
                                    <span class="product-img"><img
                                    alt="{{ $cart['name'] }}" src="{{ url($cart->attributes->image) }}"></span>
                                </td>
                                <td>
                                    <span class="product-title"><a title="{{ $cart['name'] }}" href="#">{{ $cart['name'] }}</span><br>
                                    <span class="product-price"><span
                                            class="price">${{ $cart['price'] }}</span> *
                                        <strong>
                                            <input id="amount{{ $cart['id'] }}" class="qtyamount" type="number"
                                                disabled="disabled" value="{{ $cart['quantity'] }}" min="0" max="10"
                                                oninput="rangeInput{{ $cart['id'] }}.value=amount{{ $cart['id'] }}.value" />
                                            (Qty)
                                        </strong>
                                    </span>
                                    <br>

                                    <span class="product-discount"><span
                                            class="badge badge-danger text-white discount-price">-{{ env('PETS_DISC') * 100 }}%</span>
                                        discount applied</span><br>
                                    <span class="product-total-price">

                                        <del>${{ number_format($cart['price'] * $cart['quantity'], 2) }}</del>
                                        ${{ number_format($cart['price'] * $cart['quantity'] - $cart['price'] * $cart['quantity'] * env('PETS_DISC'), 2) }}</span>
                                </td>
                            </tr>
                        </table>
                        <span class="product-btns">
                            <span class="quantity">

                                <input name="{{ $cart['id'] }}_quantity" id="rangeInput{{ $cart['id'] }}"
                                    type="range" value="{{ $cart['quantity'] }}" min="0" max="10"
                                    oninput="amount{{ $cart['id'] }}.value=rangeInput{{ $cart['id'] }}.value" />

                            </span>
                            <a href="{{url("/cart/delete-cart-data/$cart->id")}}" title="Remove Product" class="remove-product"><svg aria-hidden="true" focusable="false"
                                    data-prefix="fal" data-icon="minus-hexagon" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                    class="svg-inline--fa fa-minus-hexagon fa-w-18">
                                    <path fill="currentColor"
                                        d="M441.5 39.8C432.9 25.1 417.1 16 400 16H176c-17.1 0-32.9 9.1-41.5 23.8l-112 192c-8.7 14.9-8.7 33.4 0 48.4l112 192c8.6 14.7 24.4 23.8 41.5 23.8h224c17.1 0 32.9-9.1 41.5-23.8l112-192c8.7-14.9 8.7-33.4 0-48.4l-112-192zm84.3 224.3l-112 192c-2.9 4.9-8.2 7.9-13.8 7.9H176c-5.7 0-11-3-13.8-7.9l-112-192c-2.9-5-2.9-11.2 0-16.1l112-192c2.8-5 8.1-8 13.8-8h224c5.7 0 11 3 13.8 7.9l112 192c2.9 5 2.9 11.2 0 16.2zM172 274c-6.6 0-12-5.4-12-12v-12c0-6.6 5.4-12 12-12h232c6.6 0 12 5.4 12 12v12c0 6.6-5.4 12-12 12H172z"
                                        class=""></path>
                                </svg></a>
                            <span class="update-wrap cart-btn "><input type="submit" class="update-product"
                                    value="Update     "><svg aria-hidden="true" focusable="false" data-prefix="fal"
                                    data-icon="sync" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="svg-inline--fa fa-sync fa-w-16">
                                    <path fill="currentColor"
                                        d="M492 8h-10c-6.627 0-12 5.373-12 12v110.627C426.929 57.261 347.224 8 256 8 123.228 8 14.824 112.338 8.31 243.493 7.971 250.311 13.475 256 20.301 256h10.016c6.353 0 11.646-4.949 11.977-11.293C48.157 132.216 141.097 42 256 42c82.862 0 154.737 47.077 190.289 116H332c-6.627 0-12 5.373-12 12v10c0 6.627 5.373 12 12 12h160c6.627 0 12-5.373 12-12V20c0-6.627-5.373-12-12-12zm-.301 248h-10.015c-6.352 0-11.647 4.949-11.977 11.293C463.841 380.158 370.546 470 256 470c-82.608 0-154.672-46.952-190.299-116H180c6.627 0 12-5.373 12-12v-10c0-6.627-5.373-12-12-12H20c-6.627 0-12 5.373-12 12v160c0 6.627 5.373 12 12 12h10c6.627 0 12-5.373 12-12V381.373C85.071 454.739 164.777 504 256 504c132.773 0 241.176-104.338 247.69-235.493.339-6.818-5.165-12.507-11.991-12.507z"
                                        class=""></path>
                                </svg></span>
                        </span>
                    </div>
                @endforeach
            </form>
            <!-- Product Cart Totals -->

            <div class="cart-total">
                <sub class="badge text-white badge-success">
                    You saved
                    ${{ number_format($cart_total- ($cart_total - $cart_total * env('PETS_DISC')),2) }}</sub>
                <hr>
                <span><strong>CART TOTAL: </strong></span>
                <span class="cart-total-amount"><del>${{ number_format($cart_total,2) }}</del>
                    ${{ number_format($cart_total - $cart_total * env('PETS_DISC'), 2) }}</span>
            </div>
            <div class="cart-bottom">
                <a title="Shop" href="{{ url('/shop.html') }}" name="go-shop" class="cart-btn">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                        class="svg-inline--fa fa-shopping-bag fa-w-14">
                        <path fill="currentColor"
                            d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z"
                            class=""></path>
                    </svg> Shop More
                </a>
                <a title="Checkout" href="{{ url('/checkout.html') }}" class="cart-btn">
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="credit-card-front" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                        class="svg-inline--fa fa-credit-card-front fa-w-18">
                        <g class="fa-group">
                            <path fill="currentColor"
                                d="M268 256h-64a12 12 0 0 0-12 12v40a12 12 0 0 0 12 12h64a12 12 0 0 0 12-12v-40a12 12 0 0 0-12-12zm-104 0H76a12 12 0 0 0-12 12v40a12 12 0 0 0 12 12h88a12 12 0 0 0 12-12v-40a12 12 0 0 0-12-12zm208 0h-64a12 12 0 0 0-12 12v40a12 12 0 0 0 12 12h64a12 12 0 0 0 12-12v-40a12 12 0 0 0-12-12zm128 0h-88a12 12 0 0 0-12 12v40a12 12 0 0 0 12 12h88a12 12 0 0 0 12-12v-40a12 12 0 0 0-12-12z"
                                class="fa-secondary"></path>
                            <path fill="currentColor"
                                d="M528 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h480a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48zM192 268a12 12 0 0 1 12-12h64a12 12 0 0 1 12 12v40a12 12 0 0 1-12 12h-64a12 12 0 0 1-12-12zm-32 136a12 12 0 0 1-12 12H76a12 12 0 0 1-12-12v-8a12 12 0 0 1 12-12h72a12 12 0 0 1 12 12zm16-96a12 12 0 0 1-12 12H76a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h88a12 12 0 0 1 12 12zm176 96a12 12 0 0 1-12 12H204a12 12 0 0 1-12-12v-8a12 12 0 0 1 12-12h136a12 12 0 0 1 12 12zm32-96a12 12 0 0 1-12 12h-64a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h64a12 12 0 0 1 12 12zm128 0a12 12 0 0 1-12 12h-88a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h88a12 12 0 0 1 12 12zm0-140a23.94 23.94 0 0 1-24 24h-80a23.94 23.94 0 0 1-24-24v-48a23.94 23.94 0 0 1 24-24h80a23.94 23.94 0 0 1 24 24z"
                                class="fa-primary"></path>
                        </g>
                    </svg> Checkout Now
                </a>
            </div>
        </div>
    @endif
</div>

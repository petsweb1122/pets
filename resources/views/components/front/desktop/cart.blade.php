<style>
    /* CART PAGE */
    .cart-page {
        margin: 0 auto 0px;
    }

    .cart-page-inner {
        width: 100%;
        zoom: .9
    }

    .cart-page .cart-page-title {
        margin: 0;
        background: #6c757d08;
        padding: 20px;
        font-size: 24px;
        text-align: center;
        color: #ddd;
        margin-bottom: 30px;
        font-weight: bold
    }

    .cart-page .cart-page-title a {
        color: #777
    }

    .cart-page .cart-page-title a.active,
    .cart-page .cart-page-title a:focus,
    .cart-page .cart-page-title a:hover {
        color: #81d742;
        text-decoration: none;
        background: transparent;
    }

    .shopping-detail,
    .cart-amount-detail table {
        width: 100%;
    }

    .shopping-detail img {
        width: 75px
    }

    .shopping-detail a {
        font-size: 14px;
        color: #81d742
    }

    .shopping-detail tr,
    .cart-amount-detail table tr {
        border-bottom: 1px solid #eee
    }

    .shopping-detail tr:last-child {
        border-bottom: 0px solid #eee
    }

    .cart-amount-detail table tr:last-child {
        border-bottom: 3px solid #eee;
        font-weight: bold;
        background: #eee
    }

    .shopping-detail td {
        padding: 6px;
        text-align: center;
        vertical-align: middle
    }

    .cart-amount-detail table td {
        padding: 6px;
        font-size: 14px;
    }

    .cart-amount-detail .add-to-cart-button {
        margin-top: 10px !important;
    }

    .shopping-detail .quantity .qty {
        border: 1px solid #eee;
        width: 50px;
        border-radius: 0px;
        background-color: #ffffff;
        padding: 8px 4px;
        margin: -4px
    }

    .shopping-detail .table-head td,
    .cart-amount-detail table .table-head {
        border: 1px solid #fff;
        font-weight: bold;
        background: #fff;
        color: #777;
        box-shadow: 0px 0px 0px #000;
    }

    .shopping-detail td {
        height: 70px;
    }

    .shopping-detail {
        border-bottom: 6px solid #ccc;
        border-top: 2px solid #ccc;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .shopping-detail .cart-product-title {
        padding: 6px;
        text-align: left !important;
        vertical-align: middle;
        color: #333;

    }

    .shopping-detail .cart-product-title a {
        color: #333;

    }

    .cart-page-price {
        color: #333;
        font-weight: bold
    }

    .cart-page-price-total {
        color: #d0021b;
        font-weight: bold;
    }

    .shopping-detail .remove-product a {
        border: 1px solid #ff0018;
        padding: 1px 6px;
        border-radius: 100%;
        font-size: 20px;
        color: #ff0018;
        opacity: .6
    }

    .shopping-detail .remove-product a:hover {
        text-decoration: none;
        border: 1px solid #81d742;
        color: #81d742
    }

    .cart-page .add-to-cart-button {
        /* margin-bottom:30px; */
        color: #fff;
        font-size: 18px;
        padding: 8px 40px;
        /* margin-top:40px; */
        border: none;
        background-color: #81d742;
        border-radius: 99px;
        width: 100%
    }

    .cart-page .add-to-cart-button:hover {
        opacity: .8;
    }

    .cart-page .coupon {
        background-color: #eee;
        border: 2px dashed #81d742;
        padding: 40px
    }

    .cart-page .coupon .add-to-cart-button {
        margin-bottom: 0px
    }

    .cart-page-col {
        display: inline-block;
    }

    .cart-product-count {
        width: 60%;
        margin-right: 20px;
    }

    .cart-amount-detail {
        width: 36%;
        vertical-align: top;
        padding: 0 px;
    }

    .cart-amount-detail table {
        border-collapse: collapse !important;
        border-top: 2px solid #ccc;
        ;
    }


    .cart-amount-detail table td {
        font-size: 14px !important;
        height: 60px;
        ;
        padding: 20px
    }

    .cart-amount-detail table .table-head {
        background: #fff;
        color: #000;
        border-bottom: 2px solid #eee;
    }

    .cart-amount-detail table .table-head td {
        font-size: 22px !important;
    }

    .cart-amount-detail table .cart-price-total {
        color: #d0021b;
        font-weight: bold;
        font-size: 22px !important;
    }

    .cart-amount-detail table .cart-price-subtotal {
        color: #555;
        font-weight: bold;
        font-size: 18px !important;
    }


    .cart-page .pill-btn {
        padding: 14px 14px !important;
        font-size: 14px !important;
        margin-bottom: 4px;
        display: inline-block;
        background-color: #7DC855;
        border-radius: 99px;
        font-size: 16px;
        color: #FFFFFF;
        text-decoration: none;
        padding: 12px 40px;
        transition: all .5s;
        box-shadow: 0px 0px 10px inset #4c883f;
    }

    .cart-amount-detail table td {
        font-size: 16px;
        text-transform: uppercase;
    }

    .cart-total-row {
        background: #fff;
    }

    .product-col-title {
        text-align: left !important
    }

    @media (max-width: 991px) {

        .cart-product-count,
        .cart-amount-detail {
            width: 100%;
            margin: 8px 0% 8px 0%;
        }
    }

</style>

<div class="content">
    <div class="cart-page">
        {{-- <div class="cart-page-title">
            <a href="" class="active" title="Shopping cart">SHOPPING CART</a> &gt;&gt; <a href="" class="" title="Checkout">CHECKOUT
                DETAILS</a> &gt;&gt; <a href="" title="Order">ORDER
                COMPLETE</a>
        </div> --}}
    </div>
    @if (empty($carts))
        <div class="cart-page-title" style="text-align:center; margin-top:-30px;">
            <h2><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-triangle" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                    class="svg-inline--fa fa-exclamation-triangle fa-w-18 fa-2x">
                    <path fill="currentColor"
                        d="M270.2 160h35.5c3.4 0 6.1 2.8 6 6.2l-7.5 196c-.1 3.2-2.8 5.8-6 5.8h-20.5c-3.2 0-5.9-2.5-6-5.8l-7.5-196c-.1-3.4 2.6-6.2 6-6.2zM288 388c-15.5 0-28 12.5-28 28s12.5 28 28 28 28-12.5 28-28-12.5-28-28-28zm281.5 52L329.6 24c-18.4-32-64.7-32-83.2 0L6.5 440c-18.4 31.9 4.6 72 41.6 72H528c36.8 0 60-40 41.5-72zM528 480H48c-12.3 0-20-13.3-13.9-24l240-416c6.1-10.6 21.6-10.7 27.7 0l240 416c6.2 10.6-1.5 24-13.8 24z"
                        class=""></path>
                </svg> Your Cart is Empty!</h2>
        </div>
        <div class="cart-page cart-page-inner center" style="text-align:center">
            <p><img style="width: 250px; text-align:center;margin-top:0px;" src="{{url('front/img/box.gif')}}" alt="Empty box"><br>
                        <strong>Start shopping for your pet from a wide range of premium pet food, toys, treats, and supplies!</strong><hr>
                        <a href="{{ url('/shop.html') }}" name="go-shop" title="Shop" class="update-cart-button pill-btn" style="padding: 10px 50px !important;">
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
        <div class="cart-page cart-page-inner">
            <div class="cart-product-count cart-page-col">
                <h2>Your Shopping Cart</h2>
                <!-- Product Count -->
                <div class="">
                    <form action="{{ url('/cart/update-cart/') }}" method="post">
                        @csrf
                        <table class="shopping-detail table-responsive">
                            <tbody>
                                <tr class="table-head">

                                    <td colspan="3" class="product-col-title">PRODUCT</td>
                                    <td>PRICE </td>
                                    <td>QTY </td>
                                    <td class="mobile_hide">DISC </td>
                                    <td>TOTAL </td>
                                </tr>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td class="remove-product"><a
                                                href="{{url("/cart/delete-cart-data/$cart->id")}}" title="Remove Product">×</a></td>
                                        <td class="mobile_hide"><img src="{{ url($cart->attributes->image) }}"  alt="Product Image">
                                        </td>
                                        <td class="cart-product-title"><a href="#" title="{{ $cart['name'] }}">{{ $cart['name'] }}</a>
                                        </td>
                                        <td class="cart-page-price">${{ number_format($cart['price'],2) }}</td>
                                        <td>
                                            <div class="quantity">
                                                <input type="number" class="qty" step="1" min="1" max="9999"
                                                    name="{{ $cart['id'] }}_quantity"
                                                    value="{{ $cart['quantity'] }}" title="Qty" inputmode="numeric"
                                                    style="min-width: 0px">
                                            </div>
                                        </td>
                                        <td class="mobile_hide">
                                            {{ env('PETS_DISC') * 100 }}%
                                        </td>
                                        <td class="cart-page-price-total">
                                            ${{ number_format($cart['price'] * $cart['quantity'] - $cart['price'] * $cart['quantity'] * env('PETS_DISC'), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{url('/shop.html')}}" name="go-shop" class=" go-shop pill-btn" title="Shop">
                            <i class="fa fa-shopping-cart"></i> Continue Shopping
                        </a>

                        <input type="submit" name="update-cart" class="update-cart-button pill-btn" value="Update Cart">

                    </form>
                </div>
            </div>
            <!-- Product Cart Totals -->

            <div class="cart-amount-detail cart-page-col">
                <table class="" id="cart-total">
                    <tbody>
                        <tr class="table-head">
                            <td colspan="2">CART TOTAL</td>
                        </tr>
                        <tr class="cart-total-row">
                            <td>Subtotal<br><sub>({{ env('PETS_DISC') * 100 }}% Discount Applied)</sub>
                        </td>
                            <td class="cart-price-subtotal">
                                ${{ number_format($cart_total - $cart_total * env('PETS_DISC'), 2) }}</td>
                        </tr>

                        <tr class="cart-total-row">
                            <td>Tax</td>
                            <td>Tax will apply on checkout</td>
                        </tr>
                        <tr class="cart-total-row">
                            <td>Shipping Charges</td>
                            <td>Shipping will apply on checkout</td>
                        </tr>

                        <tr class="cart-total-row">
                            <td>Total</td>
                            <td class="cart-price-total">
                                ${{ number_format($cart_total - $cart_total * env('PETS_DISC'), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{ url('/checkout.html') }}" title="Checkout">
                    <button type="" name="go-checkout" class="add-to-cart-button pill-btn">Proceed to Checkout</button>
                </a>
            </div>
        </div>
    @endif

</div>

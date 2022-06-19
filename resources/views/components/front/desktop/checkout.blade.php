<style>
    /* CART PAGE */
    .cart-page {
        margin: 0 auto 0px;
    }

    .cart-page-inner {
        width: 100% !important;
    }

    .cart-page .order-total td,
    .cart-page .order-total th {
        border-top: 2px solid #333;
        background: #b6efc4;
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
        font-weight: bold
    }

    .cart-total-row td {
        font-size: 14px !important;
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
        padding: 4px;
        margin: -4px
    }

    .shopping-detail .table-head,
    .cart-amount-detail table .table-head {
        border-bottom: 3px solid #eee;
        font-weight: bold;
        color: #777;
        ;
    }

    .shopping-detail .remove-product a {
        border: 2px solid #ff0018;
        padding: 0 4px;
        border-radius: 100%;
        color: #ff0018;
    }

    .shopping-detail .remove-product a:hover {
        text-decoration: none;
        border: 2px solid #81d742;
        color: #81d742
    }

    .cart-page .add-to-cart-button {
        /* margin-bottom:30px; */
        border: none;
        background-color: #81d742;
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

    .cart-page .add-to-cart-button:hover {
        opacity: .8
    }

    .cart-page .coupon {
        background-color: #eee;
        border: 2px dashed #81d742;
        padding: 40px
    }

    .cart-page .coupon .add-to-cart-button {
        margin-bottom: 0px
    }

    .checkout-page-col {
        display: inline-block;
    }

    .checkout-form {
        width: 55%;
        margin-right: 20px;
    }

    .checkout-amount-detail {
        width: 41%;
        vertical-align: top;
    }

    .checkout-page .pill-btn {
        padding: 6px 14px !important;
        font-size: 14px !important;
    }

    .checkout-amount-detail table td {
        font-size: 16px;
        text-transform: uppercase;
    }

    /* CHECKOUT PAGE */
    .checkout-page-inner {
        width: 100%;
    }

    .checkout-review-order {
        border: 2px solid #d4edda;
        padding: 10px 20px 20px 20px;
        margin-top: 0px;
        background: #d4edda
    }

    .checkout-review-order table {
        margin: 30px 0;
        width: 100%;
        font-size: 14px
    }

    .checkout-review-order table tr {
        border-bottom: 1px solid #eee
    }

    .checkout-review-order table thead {
        border-bottom: 3px solid #eee
    }

    .checkout-review-order table tfoot {
        border-bottom: 3px solid #eee
    }

    .checkout-review-order table td,
    .checkout-review-order table th {
        padding: 10px
    }

    .checkout .checkbox input[type=checkbox],
    .checkbox-inline input[type=checkbox],
    .radio input[type=radio],
    .radio-inline input[type=radio] {
        margin-left: 0px;
        position: relative
    }

    .checkout label {
        margin: 14px 0 0 0
    }

    .checkout label abbr {
        color: #dc3545;
        margin: 14px 0 0 0
    }

    .different-address {
        border: 2px dotted #eee;
        margin: 20px auto;
        padding: 10px 20px 20px 20px
    }

    .shopping-input-col {
        width: 46%;
        margin: 8px 0% 8px 3%;
        display: inline-block;
        position: relative;
    }

    .shopping-input-col-full {
        width: 96%;
        margin: 8px 3%;
        display: inline-block;
    }

    .shopping-input-col .iti {
        width: 100%
    }

    .checkout-review-order-table * {
        font-size: 14px !important;
        text-align: left;
    }

    table {
        border-collapse: separate;
        text-indent: initial;
        white-space: normal;
        line-height: normal;
        font-weight: normal;
        font-size: medium;
        font-style: normal;
        color: -internal-quirk-inherit;
        text-align: start;
        border-spacing: 2px;
        font-variant: normal;
    }

    .product-name {
        font-size: 12px !important;
    }

    h3 {
        color: #d20619;
        text-transform: uppercase;
        font-weight: bold;
        border-bottom: 2px solid #ececec;
        margin: 10px 0 20px;
    }

    h3:after {
        content: "";
        display: block;
        width: 100px;
        padding-top: 10px;
        border-bottom: 2px solid #eee;
    }

    .form-control {
        border: 1px solid #8bc540;
        margin-bottom: 10px;
    }

    .form-control {
        display: block;
        width: 46%;
        margin: 8px 0% 8px 3%;
        display: inline-block;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .form-control-lg {
        display: block;
        width: 100%;
        margin: 0;
    }

    .pill-btn {
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

    @media (max-width: 991px) {

        .form-control,
        .form-control-lg,
        .shopping-input-col {
            width: 48%;
            margin: 8px 0% 8px 0%;
        }

        .shopping-input-col .form-control,
        .form-control-lg {
            width: 100%;
            margin: 8px 0% 8px 0%;
        }

        .shopping-input-col-full,
        .shopping-input-col {
            margin: 0;
        }

        .checkout-form {
            width: 100%;
        }

        .checkout-amount-detail {
            width: 100%;
        }
    }

    .errors {
        padding: 0;
        margin: 0;
        list-style: none;
        font-size: 12px;
        color: red;
        line-height: 16px;
    }

    .validation-error h4 {
        margin-bottom: 0;
    }

</style>

<div class="content">
    @if (!empty(count($carts)))
        <div class=" cart-page checkout-page-inner">
            <div class="">
                <!-- Product Count -->
                <div class="checkout-form checkout-page-col">
                    <!--p>Already Registered? <a href="https://petssified.com/login" class="text-primary" title="Login">Login here!</a>
                    </p-->
                    <div class="validation-error">

                        @if (!empty(session()->get('errors')))
                            @if (!empty(session()->get('message')))
                                <h4>{{ session()->get('message') }}</h4>
                            @endif
                            <ul class="errors">
                                @foreach (session()->get('errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <form method="POST" action="{{ url('/checkout.html') }}">
                        <h3>Shipping details</h3>
                        <div class="" id="">
                            <div class="shopping-input-col">
                                <input type="text" class="input-text form-control form-control-lg"
                                    name="shipping_first_name" id="shipping_first_name" placeholder="First name *"
                                    value="{{ old('shipping_first_name') }}" autocomplete="nope">
                                @if (!empty(session()->get('errors')))
                                    <ul class="errors">
                                    </ul>
                                @endif
                            </div>

                            <div class="shopping-input-col">
                                <input type="text" class="input-text form-control form-control-lg"
                                    name="shipping_last_name" id="shipping_last_name" placeholder="Last name *"
                                    value="{{ old('shipping_last_name') }}" autocomplete="nope">
                            </div>

                            <div class="shopping-input-col">
                                <input type="text" class="input-text form-control form-control-lg"
                                    name="shipping_company" id="shipping_company" placeholder="Company name (optional)"
                                    value="{{ old('shipping_company') }}" autocomplete="nope">

                            </div>
                            <div class="shopping-input-col">
                                <select name="shipping_country" id="shipping_country"
                                    class="shipping_country form-control form-control-lg" autocomplete="nope"
                                    tabindex="-1" title="Country&nbsp;*">
                                    <option value="US" selected> United States</option>
                                </select>

                            </div>
                            <div class="shopping-input-col">
                                <input type="text" class="input-text form-control form-control-lg"
                                    name="shipping_address_1" id="shipping_address_1"
                                    placeholder="House number and street name *"
                                    value="{{ old('shipping_address_1') }}" autocomplete="nope"
                                    data-placeholder="House number and street name *">

                            </div>
                            <div class="shopping-input-col">
                                <input type="text" class="input-text form-control form-control-lg"
                                    name="shipping_address_2" id="shipping_address_2"
                                    placeholder="Apartment, suite, unit etc. (optional)"
                                    value="{{ old('shipping_address_2') }}" autocomplete="nope"
                                    data-placeholder="Apartment, suite, unit etc. (optional)">

                            </div>
                            <div class="shopping-input-col">
                                <input type="text" class="input-text form-control form-control-lg" name="shipping_city"
                                    id="shipping_city" placeholder="Town / City *" value="{{ old('shipping_city') }}"
                                    autocomplete="nope">

                            </div>
                            <div class="shopping-input-col">
                                <select name="shipping_state" id="shipping_state"
                                    class="state_select form-control form-control-lg" autocomplete="address-level1"
                                    data-placeholder="Select an option…" tabindex="-1" title="State / County&nbsp;*">
                                    <option value="">Select State/County</option>
                                    @foreach ($state_names as $key => $state)
                                        <option value="{{ $state }}">{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="shopping-input-col">
                                <input onkeyup="getZipCodeTax(this)" type="text"
                                    class="input-text form-control form-control-lg" name="shipping_postcode"
                                    id="shipping_postcode" value="{{ old('shipping_postcode') }}"
                                    placeholder="Postcode / ZIP *" autocomplete="nope">

                            </div>
                            <input type="hidden" id="tax_value_hidden" name="tax_value_hidden">
                            <div class="shopping-input-col">
                                <input type="tel" class="input-text form-control form-control-lg" name="shipping_phone"
                                    id="shipping_phone" value="{{ old('shipping_phone') }}">
                                <span id="valid-msg" class="hide text-success">✓ Valid</span>
                                <span id="error-msg" class="hide text-danger"></span>
                            </div>
                            <div class="shopping-input-col">
                                <input type="email" class="input-text form-control form-control-lg"
                                    name="shipping_email" id="shipping_email" placeholder="Email address *"
                                    value="{{ old('shipping_email') }}" autocomplete="nope">
                            </div>

                            <div class="shopping-input-col-full">
                                <label for="order_comments" class="">Order notes&nbsp;<span
                                        class="optional">(optional)</span></label><br>
                                <textarea name="order_comments" class="input-text form-control form-control-lg"
                                    id="order_comments"
                                    placeholder="Notes about your order, e.g. special notes for delivery."
                                    rows="4">{{ old('order_comments') }}</textarea>
                            </div>
                        </div>

                </div>
                <div class="checkout-amount-detail checkout-page-col">
                    <div id="order_review" class="checkout-review-order">
                        <h3 id="order_review_heading">Your order</h3>
                        <table class="shop_table checkout-review-order-table">
                            <thead>
                                <tr>
                                    <th class="product-name">Product</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr class="cart_item">
                                        <td class="product-name">
                                            {{ $cart['name'] }}&nbsp;
                                            <strong class="product-quantity">× {{ $cart['quantity'] }}</strong>
                                        </td>
                                        <td class="product-total">
                                            <span class="amount lead">
                                                <span
                                                    class="currency-symbol">$</span>{{ number_format($cart['quantity'] * $cart['price'], 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal">
                                    <th>Discount</th>
                                    <td>
                                        <span class="amount lead">
                                        -{{number_format(env('PETS_DISC') * $cart_total, 2)}}({{ env('PETS_DISC') * 100 }}%)
                                        </span>
                                    </td>
                                </tr>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td>
                                        @php
                                            // dd(number_format($cart_total, 2));
                                            $cart_total_amount = $cart_total - $cart_total * env('PETS_DISC');
                                        @endphp
                                        <span class="amount lead">
                                            <span class="currency-symbol">
                                                $</span>{{ number_format($cart_total_amount, 2) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td class="remove-product" id="shipping_value">
                                        Shipping will calculate when you add the zip / postal code.
                                    </td>
                                </tr>
                                <tr class="cart-subtotal">
                                    <th>Sales Taxes</th>
                                    <td>
                                        <span class="amount lead">
                                            <span id='taxt_value'>0</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td>
                                        <strong>
                                            <span class="amount lead">
                                                <span class="currency-symbol">$</span><span
                                                    class="cart_total_value">{{ number_format($cart_total - $cart_total * env('PETS_DISC'), 2) }}</span>
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr>

                    <div id="onetime-payment-order" class="method_paypal" style="">
                        <input id="payment_method_paypal" type="radio" checked class="input-radio"
                            name="payment_method" value="onetime" data-order_button_text="Proceed to PayPal"
                            style="min-width: 0px;">
                        <strong>PayPal One Time Payment</strong>
                        <br>
                        <label for="payment_method_paypal">
                            <img style="max-width: 250px"
                                src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png"
                                alt="PayPal acceptance mark" width="100%">
                            <a href="https://www.paypal.com/gb/webapps/mpp/paypal-popup" class="about_paypal"
                                title="PayPal"
                                onclick="javascript:window.open('https://www.paypal.com/gb/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                                <br>What is PayPal?</a>
                        </label>
                        <div class="payment_box payment_method_paypal" style="display: block;">
                            <small>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                account.</small>

                        </div>
                    </div>


                    <div class="place-order">

                        <button type="submit" class="add-to-cart-button" name="checkout_place_order" id="place_order"
                            value="Place order" data-value="Place order">Place Order</button>
                    </div>
                </div>

                </form>
                <script>
                    function myFunction() {
                        var checkBox = document.getElementById("select-address");

                        if (checkBox.checked == true) {
                            document.getElementById("addresses").style.display = "block";
                            document.getElementById("shipping-form").style.display = "none";

                        } else {
                            document.getElementById("addresses").style.display = "none";
                            document.getElementById("shipping-form").style.display = "block";

                        }

                    }
                </script>

            </div>
        </div>
    @else
        @if (!empty(session()->get('message')))
            <h3>{{ session()->get('message') }}</h3>
        @endif
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
            <p><img style="width: 250px; text-align:center;margin-top:0px;" src="{{ url('front/img/box.gif') }}"
                    alt="Empty cart"><br>
                <strong>Start shopping for your pet from a wide range of premium pet food, toys, treats, and
                    supplies!</strong>
                <hr>
                <a href="{{ url('/shop.html') }}" name="go-shop" class="update-cart-button pill-btn"
                    style="padding: 10px 50px !important;" title="Shop">
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
    @endif

</div>

<style>
    .page-title {
        background: #6c757d08;
        padding: 20px;
        font-size: 24px;
        text-align: center;
    }

    .content-top {
        margin-top: 0px;
    }

    .checkout-page {
        margin: 20px auto 50px;
    }

    .checkout-page-inner {
        width: 90%;
    }

    .order-details {
        background: #fff;
        box-shadow: 0px 0px 2px inset #aaa;
        border-radius: 6px;
        margin-bottom: 10px;
        padding: 6px;
        display: block;
        font-size: 12px;
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

    .product-total-price {
        color: #d0011b;
        padding: 10px 0px;
        font-weight: 300;
        font-size: 16px;
        display: block;
    }

    .order-total {
        padding: 10px 0;
        margin: 20px 0;
        text-align: right;
    }

    .order-total td {
        padding: 4px 0;
    }

    .order-total-bottom td {
        border-top: 6px groove #ddd;
        border-bottom: 1px solid #ddd;
    }

    .order-amount {
        color: #d0011b;
        font-weight: 400;
        font-size: 18px;
        text-align: right;
    }

    .order-detail-table {
        width: 100%;
    }

    .checkout-review-order-table {
        width: 100%;
    }

    .checkout-page .checkout-btn {
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
        margin-top: 20px;
    }

    .checkout-page .checkout-btn * {
        color: #fff;
    }

    .checkout-page .checkout-btn:hover {
        background-color: #64af3d;
    }

    .method_paypal img {
        max-width: 280px;
    }

    .free-shipping-msg {
        text-align: left;
    }

    .free-shipping-msg sub {
        font-size: 12px;
        opacity: .8;
    }

    .checkout-page .shopping-input-col .iti{
        width: 100%;
        margin-bottom: 10px;
    }

    .select2-container--default{
        width: 100% !important;
        margin-bottom:10px;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #8bc540;
        border-radius: 4px;
        padding: 0.175rem 0.75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 6px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0px;
    }
    .select2-container .select2-selection--single {
        height: auto;
    }

    div.clearfix {
        clear: both;
    }
    .order-detail-table{
        width: 100%;
        display: block;
        zoom: .9;
    }
    .order-detail-table tr td:first-child{
        border-bottom: 1px solid #eee;
        width: 70%;
    }
    .order-detail-table tr th, .order-detail-table tr td{
        text-align: right;
        padding: 4px;
    }
    .order-detail-table tr.order-total-final td{
        border-top:3px solid #ddd;
        border-bottom: 1px solid #aaa;
        display: block;
    }
    .order-detail-table tr.order-total-final th{
        border-top:3px solid #ddd;
        border-bottom: 1px solid #aaa;
    }

</style>

<div class="content content-top">
    <div class="page-title">
        <h4>Checkout Details</h4>
    </div>
</div>
<div class="checkout-page checkout-page-inner">
    <div class="">
        <!-- Product Count -->
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
            <div>
                <h4>Enter shipping details:</h4>
                <hr>
                <div class="" id="">
                    <div class="shopping-input-col">
                        <input type="text" class="input-text form-control form-control-lg" name="shipping_first_name"
                            id="shipping_first_name" placeholder="First name *"
                            value="{{ old('shipping_first_name') }}" autocomplete="nope">
                        @if (!empty(session()->get('errors')))
                            <ul class="errors">
                            </ul>
                        @endif
                    </div>

                    <div class="shopping-input-col">
                        <input type="text" class="input-text form-control form-control-lg" name="shipping_last_name"
                            id="shipping_last_name" placeholder="Last name *" value="{{ old('shipping_last_name') }}"
                            autocomplete="nope">
                    </div>

                    <div class="shopping-input-col">
                        <input type="text" class="input-text form-control form-control-lg" name="shipping_company"
                            id="shipping_company" placeholder="Company name (optional)"
                            value="{{ old('shipping_company') }}" autocomplete="nope">

                    </div>
                    <div class="shopping-input-col">
                        <select name="shipping_country" id="shipping_country"
                            class="shipping_country form-control form-control-lg" autocomplete="nope" tabindex="-1"
                            title="Country&nbsp;*">
                            <option value="US" selected> United States</option>
                        </select>

                    </div>
                    <div class="shopping-input-col">
                        <input type="text" class="input-text form-control form-control-lg" name="shipping_address_1"
                            id="shipping_address_1" placeholder="House number and street name *"
                            value="{{ old('shipping_address_1') }}" autocomplete="nope"
                            data-placeholder="House number and street name *">

                    </div>
                    <div class="shopping-input-col">
                        <input type="text" class="input-text form-control form-control-lg" name="shipping_address_2"
                            id="shipping_address_2" placeholder="Apartment, suite, unit etc. (optional)"
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
                        <input onkeyup="getZipCodeTax(this)" type="text" class="input-text form-control form-control-lg"
                            name="shipping_postcode" id="shipping_postcode" value="{{ old('shipping_postcode') }}"
                            placeholder="Postcode / ZIP *" autocomplete="nope">

                    </div>
                    <input type="hidden" id="tax_value_hidden" name="tax_value_hidden">
                    <div class="shopping-input-col">
                        <input type="tel" class="input-text form-control form-control-lg" name="shipping_phone"
                            id="shipping_phone" value="{{ old('shipping_phone') }}">
                    </div>
                    <div class="shopping-input-col">
                        <input type="email" class="input-text form-control form-control-lg" name="shipping_email"
                            id="shipping_email" placeholder="Email address *" value="{{ old('shipping_email') }}"
                            autocomplete="nope">
                    </div>

                    <div class="shopping-input-col">
                        <label for="order_comments" class="">Order notes&nbsp;<span
                                class="optional">(optional)</span></label><br>
                        <textarea name="order_comments" class="input-text form-control form-control-lg"
                            id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery."
                            rows="4">{{ old('order_comments') }}</textarea>
                    </div>

                </div>
            </div>

    </div>
    <div class="clearfix"></div>
    <div class="checkout-amount-detail checkout-page-col">
        <div id="" class="">
            <br>
            <h4>Your order details:</h4>
            <hr>

            <div>
                <table class="order-detail-table">
                    <tbody>
                        @foreach ($carts as $cart)
                            <tr class="cart_item">
                                <td class="product-name" width="70%">
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
                                Add correct zip / postal code.
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
                        <tr class="order-total-final">
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
            <!-- Product Totals -->
        </div>

        <div id="onetime-payment-order" class="method_paypal" style="">
                        <br>
                        <input id="payment_method_paypal" type="radio" checked class="input-radio"
                            name="payment_method" value="onetime" data-order_button_text="Proceed to PayPal"
                            style="min-width: 0px;">
                        <strong>PayPal One Time Payment</strong>
                        <br>
                        <label for="payment_method_paypal">
                            <img style="max-width: 250px"
                                src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png"
                                alt="PayPal acceptance mark" width="100%">
                            <a title="PayPal" href="https://www.paypal.com/gb/webapps/mpp/paypal-popup" class="about_paypal"
                                onclick="javascript:window.open('https://www.paypal.com/gb/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                                <br>What is PayPal?</a>
                        </label>
                        <div class="payment_box payment_method_paypal" style="display: block;">
                            <small>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                account.</small>

                        </div>
        </div>
        <div class="place-order">
            <button type="submit" class="checkout-btn" name="checkout_place_order" id="place_order"
                value="Place order" data-value="Place order"><i class="fab fa-paypal"></i> Proceed to PayPal</button>
        </div>
    </div>


    </form>
</div>

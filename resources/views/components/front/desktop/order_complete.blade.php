<style>
    .alert-success {
        background: #8bc54087;
        margin: 0
    }

    .alert-success {
        background: #8bc54087;
        margin: 0
    }

    /* CART PAGE */
    .cart-page {
        margin: 0 auto 50px;
    }

    .cart-page-inner {
        width: 90%;
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
        box-shadow: 0px 0px 1px #000;
        ;
    }

    .shopping-detail .remove-product a {
        border: 2px solid #ff0018;
        padding: 2px 4px;
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
        color: #fff;
        font-size: 18px;
        padding: 8px 40px;
        /* margin-top:40px; */
        border: none;
        background-color: #81d742;
        border-radius: 99px;
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
    }

    .cart-page .pill-btn {
        padding: 6px 14px !important;
        font-size: 14px !important;
        margin-bottom: 4px;
    }

    .cart-amount-detail table td {
        font-size: 16px;
        text-transform: uppercase;
    }

    .cart-total-row td {
        font-size: 14px !important;
    }

    @media (max-width: 991px) {

        .cart-product-count,
        .cart-amount-detail {
            width: 100%;
            margin: 8px 0% 8px 0%;
        }
    }


    /* Order Complete PAGE */
    .order-complete-col {
        display: inline-block;
        width: 46%;
        vertical-align: top;
    }

    .order_status {
        border: 1px solid #eee;
        padding: 10px 20px 20px 20px;
        margin-top: 50px;
    }

    .order_status ul {
        list-style: none;
        padding: 0;
    }

    .order_status ul li {
        padding: 4px;
    }

    .order_status ul li strong {
        color: #81d742
    }

    .order_status .success {
        background-color: #eee;
        line-height: 22px;
        font-size: 14px;
        color: #333;
        font-weight: bold
    }

    .order_status .success strong {
        font-size: 14px;
        color: #aaa;
    }

    .order_complete {
        width: 100%;
        max-width: 300px;
    }

    .order_complete a {
        color: #81d742
    }

    .order_complete .price-amount {
        font-size: 16px;
    }

    .order_complete .order_details {
        width: 100%;
        font-size: 13px;
        border-collapse: collapse;
    }

    .order_complete .order_details th {
        border: 1px solid #aaa;
        padding: 10px 10px 10px 10px;
        width: 20%;
        text-align: left
    }

    .order_complete .order_details td {
        border: 1px solid #aaa;
        background-color: #eee;
        padding: 10px 10px 10px 10px;
    }

    .order_complete .order_details td p {
        margin: 0
    }

</style>


<div class="cart-page">
    <div class="cart-page-title"><a title="Shopping Cart" href="" class="">SHOPPING CART</a> >> <a title="Checkout Details" href=""
            class="">CHECKOUT DETAILS</a> >> <a title="Order Complete" href="" class="active">ORDER
            COMPLETE</a>
    </div>
</div>

<div class="content-area">

    <!-- Product Count -->

    <div class="order-complete-col ">
        <div id="order_complete" class="order_complete">
            <p><strong>Pay with paypal</strong></p>
            <h3 id="order_complete_heading">Order Details</h3>
            <table class="order_table order-complete-table order_details">
                <thead>
                    <tr>
                        <th class="product-name">Product</th>
                        <th class="product-total">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order['products'] as $product)
                        <tr class="cart_item">
                            <th>
                                {{ $product->product_title }}&nbsp;
                                <strong class="product-quantity">× {{ $product->order_product_qty }}</strong>
                            </th>
                            <td class="product-total">
                                <span class="price-amount amount">
                                    <span
                                        class="currency-symbol">$</span>{{ number_format($product->order_product_qty * $product->order_product_price, 2) }}
                                </span>
                            </td>

                        </tr>
                    @endforeach

                    <tr class="cart-subtotal">
                        <th>Subtotal</th>
                        <td>
                            <span class="price-amount amount">
                                <span
                                    class="currency-symbol">$</span>{{ number_format($order['order']->discount_amount + $order['order']->total_price, 2) }}
                            </span>
                        </td>
                    </tr>
                    <tr class="shipping-cost">
                        <th>Discount</th>
                        <td>
                            <span class="price-amount amount">
                                <span
                                    class="currency-symbol">-$</span>{{ number_format($order['order']->discount_amount, 2) }}
                            </span>
                        </td>
                    </tr>
                    <tr class="shipping-cost">
                        <th>Shipping</th>
                        <td>
                            <span class="price-amount amount">
                                <span
                                    class="currency-symbol">$</span>{{ number_format($order['order']->shipping_price, 2) }}
                            </span>
                        </td>
                    </tr>
                    <tr class="shipping-cost">
                        <th>Tax</th>
                        <td>
                            <span class="price-amount amount">
                                <span class="currency-symbol">$</span>{{ number_format($order['order']->tax, 2) }}
                            </span>
                        </td>
                    </tr>
                    <tr class="payment-method">
                        <th>Payment Method</th>
                        <td>
                            <p>Paypal</p>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="order-total">
                        <th>Total</th>
                        <td>
                            <strong>
                                <span class="price-amount amount">
                                    <span
                                        class="currency-symbol">$</span>{{ number_format($order['order']->final_amount, 2) }}
                                </span>
                            </strong>
                        </td>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>
    <div class="order-complete-col order_status">
        <h2 class="text-center" style="color:red"><strong>CONGRATULATIONS!</strong></h2>
        <p class="lead text-center" style="color:#ffc107">Your Order <strong
                style="color:#81d742; text-decoration:underline;"># pet-{{ $order['order']->order_id }}</strong>
            is in process.</p>
        <p class="alert alert-success"><strong>Thank you. Your order has been received.</strong></p>
        <ul class="order_details">
            <li class="order_no">
                Order number: <strong>pet-{{ $order['order']->order_id }}</strong>
            </li>
            <li class="order_date">
                Date: <strong>{{ $order['order']->created_at }}</strong>
            </li>
            <li class="order_total">
                Total: <strong><span class="price-amount"><span
                            class="currency-symbol">$</span>{{ number_format($order['order']->final_amount, 2) }}</span></strong>
            </li>
            <li class="payment-method">
                Payment method: <strong>Paypal</strong>
            </li>
        </ul>
    </div>
</div>
<div class="gap"></div>

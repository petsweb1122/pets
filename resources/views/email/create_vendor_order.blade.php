<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Order Details - Petssified</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	body {padding:0; margin: 0;}
	.main-wrap tr td, .main-wrap tr th{padding: 6px; }
	.main-wrap tr td a{color: #7DC855 }
	.logo {width: 250px;}
	.ship-to, .order-details{ width: 48%; display:inline-block; }
	 @media only screen and (max-width:600px) {
	 	table[class=main-wrap] {width: 100%;}
		.main-wrap {width: 100%;}
	}
	 @media only screen and (max-width:480px) {
		 .video {width: 100%; height: auto;}
		 .ship-to, .order-details{ width: 100%; }
	 }
</style>
</head>
<body>
	<table class="container" width="100%" cellpadding="0" cellspacing="0" style="background: #f5f5f5;">
    	<tr>
        	<td align="center">
            	<table class="main-wrap" width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                	<tr>
                    	<td align="center" style="padding-top: 20px; padding-bottom: 30px;" >
                            <img src="{{url('front/img/logo.png')}}" alt="petssified" class="logo" style="display: block" />
                        </td>
                  	</tr>
                    <tr>
                    	<td align="center" style="font-size: 24px; font-weight: 200; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222;">
                        	<em>Petssified</em>!
                        </td>
                 	</tr>
                    <tr>
                    	<td align="center" style="font-size: 16px; font-weight: 400; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; text-transform: uppercase; letter-spacing: 10px; padding-top: 20px; line-height: 2;">
                        	You created your order successfully.
                        </td>
                 	</tr>
                    <tr>
                    	<td align="center" style="padding-top: 20px; padding-bottom: 20px;">
                            <img class="video" src="{{url('/img/email/petssified-img2.jpg')}}" width="580" height="300"  style="display: block" alt="Petssified" />
                        </td>
                    </tr>
					<tr>
                    	<td align="center" style="background: #7dc85533; font-size: 18px; font-weight: 200; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; padding-top: 10px; padding-bottom: 10px;">
                        	<h3>Thank you for your order!</h3>
							<p style="font-size: 13px; padding: 10px;">Your order number is #pet-{{$details['order']->vendor_order_id}}</a>.
							We'll let you know as soon as your items have shipped. Here are your order details:</p>
                        </td>
                 	</tr>
                    <tr>
                    	<td align="right" style="font-size: 14px; font-weight: 400; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; padding-top: 10px; padding-left: 20px; padding-right: 20px;">
							<div class="ship-to" style="text-align:left">
								<h3 style="margin-bottom:0">Ship To:</h3>
								<span style="font-size:13px; line-height:20px;">
									<strong style="font-size:16px; color: #777; font-weight: 200;">Petssified</strong><br>
									<b>Address:</b> 3773 Howard Hughes Pkwy, Las Vegas, NV 89169, United States<br>
									<b>Phone:</b> +1-213-442-5200 <br>
									<b>City:</b> Las Vegas<br>
									<b>Email:</b> vendor@petssified.com
								</span>
							</div>
							<div class="order-details" style="text-align:left">
								<h3 style="margin-bottom:0">Order Details:</h3>
								<span style="font-size:13px; line-height:18px;">
									<b>Order Date:</b> {{$details['order']->created_at}}<br>
									<b>Order Total Items:</b> {{$details['order']->total_items}}<br>
									<b>Order Total Qty:</b> {{$details['order']->total_qty}}<br>
									<b>Order Status:</b> {{$details['order']->order_status}}<br>
									<b>Status Message:</b> {{$details['order']->order_message}}<br>
								</span>
							</div>

							<table class="product-detail" width="100%" >
								<thead>
									<tr>
										<td>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="3" width="100%">
											<table width="100%">
												<tr>
													<th align="right" width="20%" style="border-top: 2px solid #aaa;border-bottom: 1px solid #ddd;">Image</th>
													<th align="right" style="border-top: 2px solid #aaa;border-bottom: 1px solid #ddd;">Product</th>
													<th align="right" style="border-top: 2px solid #aaa;border-bottom: 1px solid #ddd;">Discount</th>
													<th align="right" style="border-top: 2px solid #aaa;border-bottom: 1px solid #ddd;">Price</th>
												</tr>
												@foreach ($details['products'] as $item)
												<tr>
													<td align="right">
														<a href="#" target="_blank" title="{{$item->product_title}}">{{$item->product_title}}</a><br>
														(${{$item->v_price}} * <strong>{{$item->order_product_qty}}</strong>)
													</td>
													<td align="right"> {{($item->v_price * $item->order_product_qty)}}$ </td>
												</tr>
												@endforeach
											</table>
										</td>
									</tr>

									<tr>
										<th colspan="2" align="right">Subtotal</th>
										<td align="right">US: ${{$details['order']->total_price}}$</td>
									</tr>
									<tr>
										<th colspan="2" align="right">Shipping</th>
										<td align="right">US: {{$details['order']->shipping_price}}$</td>
									</tr>
									<tr>
										<th colspan="2" align="right" style="border-top: 2px solid #aaa;border-bottom: 1px solid #ddd;">Total</th>
										<th align="right" style="border-top: 2px solid #aaa;border-bottom: 1px solid #ddd;">US: {{$details['order']->final_amount}}$</th>
									</tr>
								</tbody>
							</table>

                        </td>
                 	</tr>

                    <tr>
                    	<td align="center" style="font-size: 24px; font-weight: 200; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; padding-top: 30px; padding-bottom: 30px;">
                        	Happy Pet Shopping!
                        </td>
                 	</tr>
                    <tr>
                    	<td align="center" style="font-size: 14px; font-weight: 400; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; padding-top: 10px; padding-left: 20px; padding-right: 20px;">
                        	We’d love to get some feedback from you. Please write to us at <a href="feedback@petssified.com" style="color: #0592e9; text-decoration: none;">feedback@petssified.com</a> and we will try to keep improving with your help.
                        </td>
                 	</tr>

                    <tr>
                    	<td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                        	<hr color="#ebebeb">
                        </td>
                 	</tr>
                    <tr>
                    	<td align="center" style="padding-top: 20px; padding-bottom: 20px; padding-right: 10px; padding-left: 10px;">
                        	<table width="100%" cellpadding="0" cellspacing="0" style="text-align: center;">
                                <tr>
                                	<td>
                                        <a href="https://web.facebook.com/pg/Petssified/"><img src="{{url('front/img/facebook.png')}}" alt="facebook" /></a>
                                        <a href="https://twitter.com/petssified"><img src="{{url('front/img/twitter.png')}}" alt="twitter" /></a>
                                        <a href="https://www.instagram.com/petssified/"><img src="{{url('front/img/instagram.png')}}" alt="instagram" /></a>
                                    </td>
                              	</tr>
                                <tr>
                                    <td style="font-size: 10.5px; color: #565a5c; font-family: Open sans, Helvetica, Arial, sans-serif; margin:0; padding-top: 10px; padding-bottom: 15px;">
                                    	 Dont forget to add <a href="noreply@petssified.com" style="color: #0592e9; text-decoration: none;">noreply@petssified.com</a> to your contacts or safe-list to ensure our emails reach your inbox.<br />
                                         Please note that this e-mail has been sent from an e-mail address that cannot receive e-mails.<br />
                                         © Copyright 2021 <a href="https://www.petssified.com/" style="color: #0592e9; text-decoration: none;">petssified.com</a>. All rights are reserved.
                                    </td>
                          		</tr>
                                <tr>
                                    <td>
                                    	<a href="mailto:yourlist@yourdomain.tld?subject=remove" style="color: #0592e9; text-decoration: none; font-family: Open sans, Helvetica, Arial, sans-serif; font-size: 13px; border: 1px solid #0592e9; padding: 5px;">Unsubscribe form this email alert</a>
                                    </td>
                          		</tr>
                                <tr>
                                    <td style="font-size: 10.5px; color: #565a5c; font-family: Open sans, Helvetica, Arial, sans-serif; margin:0; padding-top: 15px; padding-bottom: 10px;">
                                    	<a href="https://www.petssified.com/contact-us.html" style="color: #0592e9; text-decoration: none;">Contact Us</a><br />
                                        3773 Howard Hughes Pkwy, Las Vegas, NV 89169, United States.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
              	</table>
       		</td>
   		</tr>
 	</table>
</body>
</html>

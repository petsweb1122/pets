<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password - Petssified</title>
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
                        	Welcome to Petssified, <em>Sarah</em>!
                        </td>
                 	</tr>
                    <tr>
                    	<td align="center" style="font-size: 16px; font-weight: 400; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; text-transform: uppercase; letter-spacing: 10px; padding-top: 20px; line-height: 2;">
                        	Let No Pet Be Left Behind
                        </td>
                 	</tr>
					<tr>
                    	<td align="center" style="background: #7dc85533; font-size: 18px; font-weight: 200; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; padding-top: 10px; padding-bottom: 10px;">
                        	<p style="font-size: 13px; padding:10px; line-height: 18px;">
								Order {{$details['order']['order_status']}}<br>
								You order number #<a href="{{url('/order-complete/'.$details['order']['order_id'])}}">pet-{{$details['order']['order_id']}}</a><br>
								Here is your tracking code: <strong>{{!empty($details['order']['tracking_number']) ? $details['order']['tracking_number'] : 'Code Not Found'}}</strong>
							</p>
                        </td>
                 	</tr>
					<tr>
						<td><strong>Status:</strong> {{$details['order']['order_status']}}</td>
					</tr>
					<tr>
						<td><strong>Message:</strong> {{$details['order']['order_message']}}</td>
					</tr>
					<tr>
						<td><strong>Shipping Company:</strong> {{$details['order']['shipping_method']}}</td>
					</tr>
					<tr>
						<td><strong>Tracking Code:</strong> {{$details['order']['tracking_number']}}</td>
					</tr>
                    <tr>
                    	<td align="center" style="padding-top: 20px; padding-bottom: 20px;">
                            <img class="video" src="{{url('/img/email/petssified-img2.jpg')}}" width="580" height="300"  style="display: block" alt="Petssified" />
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

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Contact Us - Petssified</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .main-wrap tr td,
        .main-wrap tr th {
            padding: 6px;
        }

        .main-wrap tr td a {
            color: #7DC855
        }

        .logo {
            width: 250px;
        }

        .ship-to,
        .order-details {
            width: 100%;
        }

        @media only screen and (max-width:600px) {
            table[class=main-wrap] {
                width: 100%;
            }

            .main-wrap {
                width: 100%;
            }
        }

        @media only screen and (max-width:480px) {
            .video {
                width: 100%;
                height: auto;
            }

            .ship-to,
            .order-details {
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <table class="container" width="100%" cellpadding="0" cellspacing="0" style="background: #f5f5f5;">
        <tr>
            <td align="center">
                <table class="main-wrap" width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                    <tr>
                        <td align="center" style="padding-top: 20px; padding-bottom: 30px;">
                            <img src="images/logo.png" alt="petssified" class="logo" style="display: block" />
                        </td>
                    </tr>
                    <tr>
                        <td align="center"
                            style="font-size: 20px; font-weight: 200; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222;">
                            We received a message from <em>{{!empty($details['first_name']) ? $details['first_name'] : ''}} {{!empty($details['last_name']) ? $details['last_name'] : ''}}</em>!
                        </td>
                    </tr>
                    <tr>
                        <td align="right"
                            style="font-size: 14px; font-weight: 400; font-family: Open sans, Helvetica, Arial, sans-serif; color: #222222; padding-top: 10px; padding-left: 20px; padding-right: 20px;">
                            <div class="ship-to" style="text-align:left">
                                <h3 style="margin-bottom:0">Details:</h3>
                                <span style="font-size:13px; line-height:20px;">
                                    <strong style="font-size:16px; color: #777; font-weight: 200;">{{!empty($details['first_name']) ? $details['first_name'] : ''}} {{!empty($details['last_name']) ? $details['last_name'] : ''}}</strong><br>
                                    <b>Email:</b> {{!empty($details['email']) ? $details['email'] : ''}}<br>
                                    <b>Purpose:</b> {{!empty($details['purpose']) ? $details['purpose'] : ''}}<br>
                                    <b>Message:</b> {{!empty($details['message']) ? $details['message'] : ''}}<br>
                                </span>
                            </div>
                        </td>



                    <tr>
                        <td align="center" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                            <hr color="#ebebeb">
                        </td>
                    </tr>
                    <tr>
                        <td align="center"
                            style="padding-top: 20px; padding-bottom: 20px; padding-right: 10px; padding-left: 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="text-align: center;">
                                <tr>
                                    <td>
                                        <a href="https://web.facebook.com/pg/Petssified/"><img src="images/facebook.png"
                                                alt="facebook" /></a>
                                        <a href="https://twitter.com/petssified"><img src="images/twitter.png"
                                                alt="twitter" /></a>
                                        <a href="https://www.instagram.com/petssified/"><img src="images/instagram.png"
                                                alt="instagram" /></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-size: 10.5px; color: #565a5c; font-family: Open sans, Helvetica, Arial, sans-serif; margin:0; padding-top: 10px; padding-bottom: 15px;">
                                        Dont forget to add <a href="noreply@petssified.com"
                                            style="color: #0592e9; text-decoration: none;">noreply@petssified.com</a> to
                                        your contacts or safe-list to ensure our emails reach your inbox.<br />
                                        Please note that this e-mail has been sent from an e-mail address that cannot
                                        receive e-mails.<br />
                                        © Copyright 2021 <a href="https://www.petssified.com/"
                                            style="color: #0592e9; text-decoration: none;">petssified.com</a>. All
                                        rights are reserved.
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-size: 10.5px; color: #565a5c; font-family: Open sans, Helvetica, Arial, sans-serif; margin:0; padding-top: 15px; padding-bottom: 10px;">
                                        <a href="https://www.petssified.com/contact-us.html"
                                            style="color: #0592e9; text-decoration: none;">Contact Us</a><br />
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


<style>
/* Order Complete PAGE */
.order_status{border:1px solid #eee; padding:10px 20px 20px 20px;margin-top:50px;}
.order_status ul{list-style:none;padding:0;}
.order_status ul li{padding:4px;}
.order_status ul li strong{color:#81d742}
.order_status .success{background-color: #eee; line-height:22px; font-size:14px; color: #333; font-weight: bold} 
.order_status .success strong{font-size:14px; color: #aaa;} 
.order_complete{width:100%; max-width:300px;}
.order_complete a{color:#81d742}
.order_complete table {margin:30px 0; width:100%; font-size:14px;font-size:16px;}
.order_complete table tr{border-bottom:1px solid #eee}
.order_complete table thead{border-bottom:3px solid #eee}
.order_complete table tfoot{border-bottom:3px solid #eee}
.order_complete table td,.order_complete table th{padding:10px}
.order_complete .price-amount{font-size:16px;}

/* ORDER Status Pag */
ol.progtrckr {margin: 0;padding: 0;list-style-type:none;}
ol.progtrckr li {display: inline-block; text-align: center;line-height: 3.5em; font-size: 12px;}
ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 32%; }
ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
ol.progtrckr[data-progtrckr-steps="5"] li {width: 20%;}
ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }
ol.progtrckr li.progtrckr-done {color: black;border-bottom: 4px solid yellowgreen;}
ol.progtrckr li.progtrckr-todo {color: silver; border-bottom: 4px solid silver;}
ol.progtrckr li:after {content: "\00a0\00a0";}
ol.progtrckr li:before { position: relative; bottom: -2.5em; float: left; left: 50%; line-height: 1em;}
ol.progtrckr li.progtrckr-done:before {content: "\2713";color: white;background-color: yellowgreen;height: 2.2em;width: 2.2em;line-height: 2.2em; border: none; border-radius: 2.2em;}
ol.progtrckr li.progtrckr-todo:before {content: "\039F"; color: silver;background-color: white;font-size: 2.2em;bottom: -1.2em;}


@media (max-width: 535px) {
 ol.progtrckr[data-progtrckr-steps="3"] li { width: 48%; }
}

@media (max-width: 400px) {
 ol.progtrckr[data-progtrckr-steps="3"] li { width: 90%; }
.order_status {padding: 10px 6px 30px 6px;}
.order_status .success {margin:0; padding:10px; font-size:11px;}
}


</style>


<div class="content-area">
    <div class="">
        <h3>Track Your Order Status</h3>
        <div class="gap"></div>
        <div class="">
            <!-- Product Count -->

            <div class="">
                <div id="order_complete" class="order_complete">

                    <form class="" action='order-complete.html'>
                        <div class="control-group">
                            <div class="controls">
                                <input class="form-control" type="text" id="name" placeholder="Enter your email address...">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input class="form-control" type="text" id="phone" placeholder="Enter your order ID...">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn btn-primary">Check Order Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="order_status">
                <h3>Where is my order?</h3>


                <div class="success"><strong>Order Tracking:</strong> #555555<br><strong>Shipped
                        Via:</strong> Ipsum Dolor<br><strong>Expected Date:</strong> 7-NOV-2021</div>



                <ol class="progtrckr" data-progtrckr-steps="3">
                    <li class="progtrckr-done">Order Processing</li>
                    <!--
                             -->
                    <li class="progtrckr-todo">Shipped</li>
                    <!--
                             -->
                    <li class="progtrckr-todo">Delivered</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="gap"></div>



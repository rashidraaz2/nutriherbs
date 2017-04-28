<?php

require "include/common.php";
session_start();
//GET Order Detail From API Throught Order Id;
$customer_info=array();
if(!empty($_SESSION['order_id'])){
    $order_id = $_SESSION['order_id'];
    $order_info=$obj->getOrderPlaced($order_id);
	$api=$obj->ApiAccess();
		
	########################################################################################################
	################################ Required Code for all template starts here ############################
	
	foreach($api['tracker_data'][0] as $key=>$value){ $$key = $value; }
	foreach($api['header_data'] [0] as $key=>$value){ $$key = $value; }
	foreach($api['footer_data'] [0] as $key=>$value){ $$key = $value; }
	
	//Header Scripts
	$header_scripts ='';
	if(!empty($header_script) && $show_on_checkout_h == 'on'){
		$header_scripts .= html_entity_decode($header_script);
	}
	foreach($api['fb_data'] as $key=>$value){ 
		if(!empty($_SESSION['CH_ID']) && !empty($order_info['total']) && $value['channel_id'] ==  $_SESSION['CH_ID'] && $value['type'] == 'facebook' && $value['show_on_checkout'] == 'on'){
			
			$header_scripts .= $obj->facebook_pixel_success($value['pixel_code'], $order_info['total']); 
			
		}
		
		if(empty($_SESSION['CH_ID']) && !empty($order_info['total']) && $value['channel_id'] == '*' && $value['type'] == 'facebook' && $value['show_on_checkout'] == 'on'){
			$header_scripts .= $obj->facebook_pixel_success($value['pixel_code'], $order_info['total']); 
		}
		
		if(!empty($_SESSION['CH_ID']) && !empty($order_info['total']) && $value['channel_id'] ==  $_SESSION['CH_ID'] && $value['type'] == 'gocloud' && $value['show_on_checkout'] == 'on'){
			$header_scripts .= $obj->Offer_Conversion_Pixel_Code($_SESSION['CH_AFFILIATE_ID']);
		}
	}

	//Footer Scripts
	$footer_scripts = '';
	if(!empty($footer_script) && $show_on_checkout_f == 'on' ){
		$footer_scripts .= html_entity_decode($footer_script);
	}
	if(!empty($tracker_id)){
		if($tracker == 'hotjar' && $show_on_checkout_s == 'on' ){
			$footer_scripts .= $obj->track_hotjar($tracker_id);
		}
		
		if($tracker == 'mouseflow'  && $show_on_checkout_s == 'on' ){
			$footer_scripts .= $obj->track_mouseflow($tracker_id);
		}
		
		if($tracker == 'crazyegg'  && $show_on_checkout_s == 'on' ){
			$footer_scripts .= $obj->track_crazyegg($tracker_id);
		}

	}
	################################# Required Code for all template ends here #############################
	########################################################################################################	

}
//print_r($order_info);
//print_r($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Thank you!</title>
<link href="success/success.min.css" rel="stylesheet" type="text/css">
<script src="success/jquery-3.0.0.min.js"></script>
<?php  
include_once('pixel.php');
echo $header_scripts;
?>
</head>
<body>
  <br/>
 <div class="container"> 
  <p><img src="success/top-logo.png" style="position: relative;margin: 0 auto; display: block;"></p>
   
  <div class="right-div" style="width:100%">  
           <div class="receipt"><h1>THANK YOU FOR YOUR ORDER!</h1><div>       
                  <table class="table">
                
                  <thead>
                    <tr>
                      <td>Name</td>
                      <td>E-Mail</td>
                      <td>Order Id</td>
                      <td>Payment Type</td>
                    </tr>
                  </thead>
                  <tbody>
                   
                    <tr>
                      <td><?php echo $order_info['firstname'].' '.$order_info['lastname'];?></td>
                      <td><?php echo $order_info['email'];?></td>
                      <td>#<?php echo $order_info['order_id'];?></td>
                       <td><?php echo $order_info['payment_method'];?></td>
                    </tr>
                   </tbody>
                  </table>
                  <table class="table">
                  <thead>
                    <tr>
                      <td class="left">Payment Address</td>
                      <td class="left">Shipping Address</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="left"><?php echo $order_info['payment_address'];?></td>
                      <td class="left"><?php echo $order_info['shipping_address'];?></td>
                    </tr>
                  </tbody>
                </table>
                           
                 <table class="table">
                    <thead>
                    <tr>
                      <td>Product</td>
                      <td>Model</td>
                      <td>Quantity</td>
                      <td>Price</td>
                      <td>Amount</td>
                    </tr>
                  </thead>
                  <tbody>
                   
                   <?php if(!empty($order_info['products'])){?>

                    <?php foreach ($order_info['products'] as $key => $product) {?>
                      <tr>                 
                      <td><?php echo $product['name'];?></td>
                      <td class="left"><?php echo $product['model'];?></td>
                      <td class="right"><?php echo $product['quantity'];?></td>
                      <td class="right"><?php echo $product['price'];?></td>
                      <td class="right"><?php echo $product['total'];?></td>
                      </tr>

                     <?php } ?>

                    <?php } ?>
                                                          
                  </tbody>
                  <tfoot>

                    <?php if(!empty($order_info['totals'])){?>
                        <?php foreach ($order_info['totals'] as $key => $total) {?>
                        <tr>
                        <td colspan="4" class="right"><b> <?php echo $total['title'];?>:</b></td>
                        <td class="right price"><?php echo $total['text'];?></td>
                        </tr>
                        <?php } ?>

                    <?php } ?>

                    </tfoot>
                </table>
          
           </div> 
   </div>

</div> 
<!--....................................container ends..................................-->

  

<div class="clear">&nbsp;</div>


<div class="footer">  
      <h3>Our customer care will contact you to confirm your order details. We hope you enjoy the benefits of Garcinia Cambogia Extract!"</h3>
  
  <h2>If you have any questions please call us +91 11 6525 2786</h2>
  <p>&nbsp;</p>
<p><img src="success/fda.png" alt="" width="80"> 
           <img src="success/iso_certified_co_logo_blue1.png" alt="" width="60"> 
           <img src="success/gmp.png" alt="" width="60"> 
           <img src="success/fssai.png" alt="" width="80"> 
        </p>
<p class="footernav">
            <a class="privacy_open" href="http://www.nutriherbs.in/privacy-policy">Privacy Policy</a> | 
            <a class="terms_open" href="http://www.nutriherbs.in/terms-and-conditions">Terms &amp; Conditions</a> | 
            <a class="contact_open" href="http://www.nutriherbs.in/contactus">Contact Us</a>
        </p>
 <p class="copyrighttext">Copyright © 2015 Nutriherbs.  All rights reserved.</p>

</div>
<?php 
 echo $footer_scripts;
	?>
</body>
</html>
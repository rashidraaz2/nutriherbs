<?php
require "include/common.php";
session_start();
$api=$obj->ApiAccess();
//$product=$obj->getProducts();
//print_r($product);


//GET Order Detail From API Throught Order Id;
$customer_info=array();
if(!empty($_SESSION['order_id'])){
    $order_id = $_SESSION['order_id'];
    $customer_info=$obj->getOrder($order_id);
}
//print_r($customer_info);
//print_r($_POST);




if(isset($_POST['order_id']) && !empty($_POST['order_id'])){


    $param=array();
    $param['firstname']       =  $_POST['firstname'];
    $param['lastname']        =  $_POST['lastname'];
    $param['address_1']       =  $_POST['address_1'];
    $param['address_2']       =  $_POST['address_2'];
    $param['city']            =  $_POST['city'];
    $param['postcode']        =  $_POST['postcode'];
    $param['email']           =  $_POST['email'];
    $param['telephone']       =  $_POST['telephone'];
    $param['zone_id']         =  $_POST['zone_id'];
    $param['order_id']        =  $_POST['order_id'];
    $param['product_id']      =  $_POST['product_id']; 
    $param['payment_code']    =  $_POST['payment_type'];  
    $param['coupon']          =  $_POST['coupon'];
  //  print_r($param);
    //exit;
      
    $order=$obj->addOrders($param);
    if(!empty($order['error'])){
         print_r($order);
         exit; 
    } 
    $_SESSION['PUT_ORDER_ID']=$order['order_id'];
    header("location:thankyou.php");
    exit;
}

?>


<?php

global $pid;


if(isset($_GET["pid"])){
	
	$pid = intval($_GET["pid"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="shortcut icon" type="image/x-icon" href="mobile/images/favicon.png" />
<meta name="viewport" content="width=640">
<title>Nutriherbs</title>
<link rel="shortcut icon" href="mobile/images/favicon.ico" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link href="mobile/css/index.min.css" rel="stylesheet" type="text/css">

<script src="mobile/js/jquery-1.11.0.js"></script>


<style type="text/css">

.bg-none{
  
    border: none;
    background: none;
    overflow: hidden;
    outline: none;
}
.bg-none:hover,.bg-none:active,.bg-none:focus{
    border: none;
    overflow: hidden; 
}
.bg-none img:hover{
  opacity: 0.9;
  cursor: pointer;
}


/*FOR MOBILE VERSION - ORDER TOTAL TABLE CSS STARTS : required Don't Remove*/*/
#result_show > table {border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;margin-top: 10px;}
#result_show > table > thead tr td {font-size: 20px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px 10px; }
#result_show > table > thead tr:nth-child(1) { font-size: 22px; color: #d71e1c;}
#result_show > table > tfoot tr td {font-size: 20px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px 10px; }
#result_show > table > tfoot tr:nth-last-child(1) {font-size: 22px; color:#207001; font-weight: 700;}
/*FOR MOBILE VERSION - ORDER TOTAL TABLE CSS END */



</style>

</head>
<body>
<div class="container">
  <img src="mobile/images/confirm-hd.jpg"alt="" />
        <div class="clearfix"></div>
          <p class="con-txt1"><span>Great Choice! </span>You’re taking your first<br>step towards a 
          better body. Act now so you don’t miss out on this offer!</p>
          <p class="con-txt2">Current Availability: <b>LOW STOCK</b>. Sell-out Risk: <span>HIGH</span> </p>
            <div class="brd"></div>
     

<?php if(!empty($pid) && $pid==53){?>
    <div class="confirm-prcbox box1" >
          <div class="confirm-prcboxlft"><img src="mobile/images/conf-3btl.png"  alt="" class="conf-lftbtl" /></div>
          <div class="confirm-prcboxrgt">
              <p class="confhding">Garcinia CAMBOGIA HERBS</p>   
              <p class="confhding-txt1">Natural Weight Loss Formula<br>3 Month Supply - Get 3 Free</p>
             <!--  <div class="brd2"></div>
              <p class="con-txt4" style="font-size: 18px; margin: 5px 0px;height: 10px; text-align: center;">Billing Information</p> -->
              <p id="result_show"></p>  
          </div>
    </div>

 <?php } else if(!empty($pid) && $pid==47){?>
    <div class="confirm-prcbox box2">
          <div class="confirm-prcboxlft"><img src="mobile/images/conf-2btl.png" alt="" class="conf-lftbtl" /></div>
          <div class="confirm-prcboxrgt">
                <p class="confhding">Garcinia CAMBOGIA HERBS</p>   
                <p class="confhding-txt1">Natural Weight Loss Formula<br>2 Month Supply - Get 2 Free</p>
                <!-- <div class="brd2"></div>
                <p class="con-txt4" style="font-size: 18px; margin: 5px 0px;height: 10px; text-align: center;">Billing Information</p> -->
                <p id="result_show"></p>  
          </div>
    </div>
 <?php } else if(!empty($pid) && $pid==32){?>

    <div class="confirm-prcbox box3">
          <div class="confirm-prcboxlft"><img src="mobile/images/conf-1btl.png" alt="" class="conf-lftbtl" /></div>
          <div class="confirm-prcboxrgt">
            <p class="confhding">Garcinia CAMBOGIA HERBS</p>   
            <p class="confhding-txt1">Natural Weight Loss Formula<br>Buy 1 Month supply</p>
            <!-- <div class="brd2"></div>
            <p class="con-txt4" style="font-size: 18px; margin: 5px 0px;height: 10px; text-align: center;">Billing Information</p> -->
            <p id="result_show"></p>    
          </div>
    </div>
 <?php } ?>



      <form method="post" enctype="multipart/form-data" action="" name="package-payment" id="package-payment">
        <input type="hidden" id="firstname" name="firstname" value="<?php echo $customer_info['firstname']?$customer_info['firstname']:'';?>"  />
        <input type="hidden" id="lastname" name="lastname" value="<?php echo $customer_info['lastname']?$customer_info['lastname']:'';?>"  />
        <input type="hidden" id="address1" name="address_1" value="<?php echo $customer_info['address_1']?$customer_info['address_1']:'';?>"  />
        <input type="hidden" id="address2" name="address_2" value="<?php echo $customer_info['address_2']?$customer_info['address_2']:'';?>"  />
        <input type="hidden" name="city" id="city" value="<?php echo $customer_info['city']?$customer_info['city']:'';?>"  />
        <select name="zone_id" id="state" style="display:none;">
        <option value="">Select State </option>                                             
        <?php foreach ($api['state'] as $result) {?>

        <?php if(!empty($customer_info['zone_id']) && $customer_info['zone_id']==$result['zone_id']){?>
        <option value="<?php echo $result['zone_id'];?>" selected><?php echo $result['name'];?></option>
        <?php } else { ?>
        <option value="<?php echo $result['zone_id'];?>"><?php echo $result['name'];?></option>
        <?php } ?>
        <?php } ?>
        </select>
        <input type="hidden" id="pincode" name="postcode" value="<?php echo $customer_info['postcode']?$customer_info['postcode']:'';?>"  />
        <input type="hidden" name="telephone" id="phone" value="<?php echo $customer_info['telephone']?$customer_info['telephone']:'';?>"  />
        <input type="hidden" name="email" id="email" value="<?php echo $customer_info['email']?$customer_info['email']:'';?>"  />

        <input name="code" type="hidden" id="code" />                  
        <input name="product_id" type="hidden" id="product_id" value="<?php echo $pid;?>"/>     
        <input name="coupon" type="hidden" value="" id="coupon"  />             
        <input type="hidden" value="<?php echo $customer_info['order_id']?$customer_info['order_id']:'';?>" id="order_id" name="order_id"/> 
            

          <div class="case-part" style="height:auto;">
              <p class="case-part-txt1"><input type="checkbox" name="payment_type" id="cod" checked="checked" value="cod" class="chk_box"> Cash On Delivery</p>               
              <p class="case-part-txt3">Please enter the confirmation code you have received on your phone/email to confirm your order.</p>
              <input name="verif_code" style="height:45px;margin:2% auto 0 auto;" id="verif_code" class="order-area">
              <p class="case-part-txt3">If you did not receive a confirmationcode, please <a href="javascript:void(0)" id="refresh">Click Here</a> for Re Send OTP Confirmation.</p>
          </div>
            
          <div class="clearfix"></div>

          <div class="upbtm">
          <div class="clearfix"></div>
          <p class="scure-lock"><img src="mobile/images/lock.png" alt=""/></p>
              <div class="btncontainer" style="margin:2% auto 2% auto;">
                  <center><button type="submit" id="submit-order" class="button bg-none"><img src="mobile/images/ck-btn.png" width="540" height="99" alt="" /></button></center>
              </div>
              <center><img src="mobile/images/scure.png" alt=""  class="scure"/></center>
          </div> 
        

        <img src="mobile/images/logos.jpg"alt=""  class="logos"/>
       <div id="footer">
          <p class="footer-txt">
            
         
          <a href="https://www.nutriherbs.in/Disclaimer-Policy" class="fancybox fancybox.iframe" target="_blank" >disclaimer </a>
         |<a href="https://www.nutriherbs.in/privacy-policy" class="fancybox fancybox.iframe" target="_blank" > PRIVACY POLICY</a> | 
         <a href="https://www.nutriherbs.in/terms-and-conditions" target="_blank" class="fancybox fancybox.iframe">terms & conditions</a><br>
           For Any Question Email Us: support@nutriherbs.in<br>
            Or call Us:+91 11 6525 2786<br>
           Open Monday - Friday 9:00 Am To 6:00 PM IST<br>
           Nutriherbs. © 2016. All Rights Reserved.
        </p>
        </div>
 </div>
 <script type="text/javascript" src="js/mob_checkout.min.js"></script>


<script type="text/javascript" src="mobile/js/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="mobile/css/jquery.fancybox.min.css">
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();			   
	});
</script>	 					  			
</body>
</html>
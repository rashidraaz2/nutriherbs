<?php
require "include/common.php";

session_start();
$api=$obj->ApiAccess();
$product = $obj->getProducts();

//GET Order Detail From API Throught Order Id;
$customer_info=array();
if(!empty($_SESSION['order_id'])){
    $order_id = $_SESSION['order_id'];
    $customer_info=$obj->getOrder($order_id);
}

$ruleq = ["pincode" => $customer_info["postcode"],"state_id" => $customer_info["zone_id"],"page_url" => "garcinia/home2t"];
$rules = $obj->getRules($ruleq);
//print_r($rules);die();
$threshold_amount = isset($rules[0]) ? $rules[0]['threshold_amount'] : 999999 ;
$shipping = 101;

$preSelectedProductId = $obj->getPreSelectedPriductId($product['products'], $threshold_amount,$shipping);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="shortcut icon" type="image/x-icon" href="mobile/images/favicon.png" />
<meta name="viewport" content="width=640">
<title>Nutriherbs</title>
<link rel="shortcut icon" href="mobile/images/favicon.ico" />
<link href=<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link href="mobile/css/index.min.css" rel="stylesheet" type="text/css">

<script src="mobile/js/jquery-1.11.0.js"></script>
</head>
<body>
<div class="container">
  <img src="mobile/images/select-hd.jpg"alt="" />
        <div class="clearfix"></div>

        <?php  if($threshold_amount > (5999+$shipping)){ ?>
           <div class="package1" onclick="location.href='confirm.php?pid=53'" style="cursor:pointer;">  
             <div class="package1">
            <div class="package-top">
                 <div class="pg-top-left">
                   <img src="mobile/images/select-btn.png" alt=""  class="select-btn"/> 
                 </div>
                   <div class="pg-top-right">
                   <p class="pg-top-right-txt">Buy 3 Month supply <br>& get 3 free</p>
                </div>
             </div>
            <div class="pg-mid">
                <div class="pg-mid-lft">
                    <p class="pg-mid-lft-txt1">Retail Price: <span>Rs.16,740</span><br>
                       Offer:  Rs.5999</p>
                     <p class="pg-mid-lft-txt2">Rs.1000/ea</p>  
                       <p class="pg-mid-lft-txt3">Current Availability: <img src="mobile/images/presentage.png"  alt=""  class="presentage"/></p>
                         <p class="clearall"></p>
                       <p class="pg-mid-lft-txt4"><b>LOW STOCK</b>. Sell-out Risk: <span>HIGH</span></p>
                  <img src="mobile/images/free-shipping.png" alt="" class="free-shipping" />
               </div>
                <div class="pg-mid-rgt"> 
                   <p class="save"> 64%</p>
                  <img src="mobile/images/bottle1.png" alt="" class="bottle1"/> 
               </div>
            </div>
          </div>
          </div>
           <?php } ?>
                    <?php if($threshold_amount > (4999+$shipping)){ ?> 
           <div class="package1" onclick="location.href='confirm.php?pid=47'" style="cursor:pointer;">  
             <div class="package1">
            <div class="package-top">
                 <div class="pg-top-left">
                   <img src="mobile/images/select-btn.png" alt=""  class="select-btn"/> 
                 </div>
                   <div class="pg-top-right">
                   <p class="pg-top-right-txt">Buy 2 Month supply <br>& get 2 free</p>
                </div>
             </div>
            <div class="pg-mid">
                <div class="pg-mid-lft">
                    <p class="pg-mid-lft-txt1">Retail Price: <span>Rs.11,160</span><br>
                       Offer: Rs.4999</p>
                     <p class="pg-mid-lft-txt2">Rs.1250/ea</p>  
                       <p class="pg-mid-lft-txt3">Current Availability: <img src="mobile/images/presentage2.png"  alt=""  class="presentage"/></p>
                         <p class="clearall"></p>
                       <p class="pg-mid-lft-txt4"><b>LOW STOCK</b>. Sell-out Risk: <span style="color:#ff9c00;">MEDIUM</span></p>
                  <img src="mobile/images/free-shipping.png" alt="" class="free-shipping" />
               </div>
                <div class="pg-mid-rgt"> 
                   <p class="save2"> 55%</p>
                  <img src="mobile/images/bottle2.png" alt="" class="bottle2" /> 
               </div>
            </div>
          </div>
          </div>
                   <?php } ?>
                    <?php if($threshold_amount > (2499+$shipping)){ ?>
           <div class="package1" onclick="location.href='confirm.php?pid=32'" style="cursor:pointer;">  
              <div class="package1">
            <div class="package-top">
                 <div class="pg-top-left">
                   <img src="mobile/images/select-btn.png" alt=""  class="select-btn"/> 
                 </div>
                   <div class="pg-top-right">
                   <p class="pg-top-right-txt">Buy 1 Month supply </p>
                </div>
             </div>
            <div class="pg-mid">
                <div class="pg-mid-lft">
                    <p class="pg-mid-lft-txt1">Retail Price: <span>Rs.2,790</span><br>
                       Offer:  Rs.2499</p>
                     <p class="pg-mid-lft-txt2">Rs.2499/ea</p>  
                       <p class="pg-mid-lft-txt3">Current Availability: <img src="mobile/images/presentage3.png"  alt=""  class="presentage"/></p>
                         <p class="clearall"></p>
                       <p class="pg-mid-lft-txt4"><b>LOW STOCK</b>. Sell-out Risk: <span style="color:#96e166;">LOW</span></p>
                  <img src="mobile/images/free-shipping.png" alt="" class="free-shipping" />
               </div>
                <div class="pg-mid-rgt"> 
                   <p class="save3"> 10%</p>
                  <img src="mobile/images/bottle3.png" alt="" class="bottle3" /> 
               </div>
            </div>
          </div>
           </div>   
           <?php } ?>
              <div class="clearfix"></div>
                        
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

<script type="text/javascript" src="mobile/js/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">

<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();			   
	});
</script>			  					  			
</body>
</html>

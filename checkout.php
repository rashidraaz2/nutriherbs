<?php
error_reporting(0);
require "include/common.php";
$user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
$url = "https://" . $_SERVER['HTTP_HOST'];
$i = 1;
if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|ucweb|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
header("location:select-package.php");
exit;   
}
session_start();
$api=$obj->ApiAccess();
$product = $obj->getProducts();

	########################################################################################################
	################################ Required Code for all template starts here ############################
	//print_r($api['fb_data']);
	foreach($api['tracker_data'][0] as $key=>$value){ $$key = $value; }
	foreach($api['header_data'] [0] as $key=>$value){ $$key = $value; }
	foreach($api['footer_data'] [0] as $key=>$value){ $$key = $value; }
	
	//Header Scripts
	$header_scripts ='';
	if(!empty($header_script) && $show_on_cart_h == 'on'){
		$header_scripts .= html_entity_decode($header_script);
	}
	foreach($api['fb_data'] as $key=>$value){ 
		if($value['channel_id'] ==  $_SESSION['CH_ID'] && $value['type'] == 'facebook' && $value['show_on_cart'] == 'on' ){
				$header_scripts .=  $obj->facebook_pixel_lead($value['pixel_code']); 
		}
		if($value['channel_id'] == '*' && $value['type'] == 'facebook' && $value['show_on_cart'] == 'on' ){
			$header_scripts .= $obj->facebook_pixel_lead($value['pixel_code']); 
		}
		
		if($value['channel_id'] ==  $_SESSION['CH_ID'] && $value['type'] == 'gocloud' && $value['show_on_cart'] == 'on' ){
			$header_scripts .= $obj->Offer_Conversion_Pixel_Code($_SESSION['CH_AFFILIATE_ID']);
		}

	}

	//Footer Scripts
	$footer_scripts = '';
	if(!empty($footer_script) && $show_on_cart_f == 'on' ){
		$footer_scripts .= html_entity_decode($footer_script);
	}
	if(!empty($tracker_id)){
		if($tracker == 'hotjar' && $show_on_cart_s == 'on' ){
			$footer_scripts .= $obj->track_hotjar($tracker_id);
		} 
		
		if($tracker == 'mouseflow'  && $show_on_cart_s == 'on' ){
			$footer_scripts .= $obj->track_mouseflow($tracker_id);
			
		}
		
		if($tracker == 'crazyegg'  && $show_on_cart_s == 'on' ){
			$footer_scripts .= $obj->track_crazyegg($tracker_id);
		}

	}
	################################# Required Code for all template ends here #############################
	########################################################################################################	

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

if(empty($customer_info['order_id'])){
    header("location:index.php");
    exit;  
}

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php  
include_once('pixel.php');
echo $header_scripts;
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<link href="css/style.min.css" rel="stylesheet" type="text/css" />
<title>Garcina Cambogia Herbs</title>
<style type="text/css">
/*FOR DESKTOP VERSION - ORDER TOTAL TABLE CSS STARTS : required Don't Remove*/
#result_show > table {border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;margin-top: 10px;}
#result_show > table > thead tr td {font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px 10px; }
#result_show > table > thead tr:nth-child(1) { font-size: 16px; color: #d71e1c;}
#result_show > table > tfoot tr td {font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px 10px; }
#result_show > table > tfoot tr:nth-last-child(1) {font-size: 18px; color:#207001; font-weight: 700;}
/*FOR DESKTOP VERSION - ORDER TOTAL TABLE CSS END*/
</style>
</head>
<body>
<div class="chk_bg">
	<div class="container">
    	<div class="inner_sec">
        	<div class="hdr_sec">
            	<img src="images/logo.png" class="logo" alt="" />
                <img src="images/graphic.png" alt="" class="graphic" />
                <div class="offer">
                	<p><span>Exclusive Internet Offer</span> <br />Available to IND Residents Only</p>
                	<img src="images/flag.png" class="flag" alt="" />
                </div>
            </div>
            <div class="clearall"></div>	
            <div class="lft-sec">
                    <center><img src="images/sel_pak.png" class="sel_pak" alt="" /></center>
                    <?php if($threshold_amount > (5999+$shipping)){ ?>
                    <a href="javascript:void(0)" class="box1 selected">
                        <img src="images/buy_3-btl.png" alt="" class="buy_3-btl" />
                        <img src="images/6_btl.png" alt="" class="btl_6" />
                        <img src="images/seal.png" alt="" class="seal" />
                        <div class="rgt-box">
                            <img src="images/best_sell.png" alt="" class="best_sell" />
                            <p class="box_txt1">6 MONTH SUPPLY</p>
                            <p class="box_txt2" style="font-size: 32px;"> <b>Rs.1000</b><span>/ea</span></p>
                            <p class="box_txt3">Retail: <span style="color:red; text-decoration:line-through;"> <span style="color:#000;">Rs.17,994</span></span> <br /> Offer:Rs.5999</b></p>
                            <img src="images/avial-1.png" alt="" class="avail-1" />
                        </div>
                    </a>
                    <?php } ?>
                    <?php if($threshold_amount > (4999+$shipping)){ ?>                  
                    <a href="javascript:void(0)" class="box2">
                        <img src="images/buy_2-btl.png" alt="" class="buy_3-btl" />
                        <img src="images/4_btl.png" alt="" class="btl_6" />
                        <div class="rgt-box">
                            <img src="images/mod_pack.png" alt="" class="best_sell" />
                            <p class="box_txt1">4 MONTH SUPPLY</p>
                            <p class="box_txt2" style="font-size: 32px;"><b>Rs.1250</b><span>/ea</span></p>
                            <p class="box_txt3">Retail: <span style="color:red; text-decoration:line-through;"> <span style="color:#000;">Rs.11,996</span></span> <br /> Offer: Rs.4999</b></p>
                            <img src="images/avail-2.png" alt="" class="avail-1" />
                        </div>
                    </a>
                    <?php } ?>
                    <?php if($threshold_amount > (2499+$shipping)){ ?>
                    <a href="javascript:void(0)" class="box3">
                        <img src="images/buy_1-btl.png" alt="" class="buy_3-btl" />
                        <img src="images/1_btl.png" alt="" class="btl_6" />
                        <div class="rgt-box">
                            <img src="images/sam_pack.png" alt="" class="best_sell" />
                            <p class="box_txt1">1 MONTH SUPPLY</p>
                            <p class="box_txt2" style="font-size: 32px;"><b>Rs.2499</b></p>
                            <p class="box_txt4">Retail: <span style="color:red; text-decoration:line-through;"> <span style="color:#000;">Rs.2790</span></span></p>
                            <img src="images/avail-3.png" alt="" class="avail-1" />
                        </div>
                    </a> 
                    <?php } ?> 
                    <center><img src="images/verified_logo.png" class="verified_logo" alt=""/></center>
              </div>
            <div class="rgt-sec">
<?php ///* ?>


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
        <input name="product_id" type="hidden" id="product_id" value="53"/>     
        <input name="coupon" type="hidden" value="" id="coupon"  />             
        <input type="hidden" value="<?php echo $customer_info['order_id']?$customer_info['order_id']:'';?>" id="order_id" name="order_id"/> 
                   
           
            	
                	<div class="frm-bg">

                    <img src="images/frm-top.png" alt="" />
                    	<p class="ship">Shipping / Billing Information</p>
                    	<div class="frm-fields">
                            <table width="100%" border="1">
                            <tr>
                             <td>Name</td>
                             <td><?php echo $customer_info['firstname']?$customer_info['firstname']:'';?> <?php echo $customer_info['lastname']?$customer_info['lastname']:'';?></td>
                            </tr>
                            <tr>
                            <td>Address 1</td>
                            <td><?php echo $customer_info['address_1']?$customer_info['address_1']:'';?></td>
                            </tr>
                            <tr>
                            <td>Address 2</td>
                            <td><?php echo $customer_info['address_2']?$customer_info['address_2']:'';?></td>
                            </tr>
                            <tr>
                            <td>Postal Code</td>
                            <td><?php echo $customer_info['postcode']?$customer_info['postcode']:'';?></td>
                            </tr>
                            <tr>
                            <td>City</td>
                             <td><?php echo $customer_info['city']?$customer_info['city']:'';?></td>
                            </tr>
                            <tr>
                            <td>State</td>
                            <td><?php echo $customer_info['zone']?$customer_info['zone']:'';?></td>
                            </tr>
                            <tr>
                            <td>Telephone Number</td>
                             <td><?php echo $customer_info['telephone']?$customer_info['telephone']:'';?></td>
                            </tr>
                            <tr>
                            <td>Email</td>
                            <td><?php echo $customer_info['email']?$customer_info['email']:'';?></td>
                            </tr>
                        </table>
                     	</div>
                        <!-- <a href=""><input type="button" value="" /></a> -->
                        <div class="clearall"></div>
                        <div class="delivery">                          
                        <input type="checkbox" name="payment_type" id="cod" checked="checked" value="cod" class="chk_box">
                        <p>Cash On Delivery</p>
                        </div>
                      


                        <div class="frm-btm-sec" >
                             <p id="result_show"></p>
                        	<p class="frm-txt1">
                          Please enter the confirmation code you have received on your phone/email to confirm your order.
						<input type="text" name="verif_code" id="verif_code" class="frm-input" /> <br />
                        If you did not receive a confirmation code, please <a href="javascript:void(0)" id="refresh">Click Here</a>  for Re Send OTP Confirmation.
                        </p>
                        <div class="frm-btn"> 
                        <div class="arrow-frm">              
                            <img class="frm-arrow" alt="" src="images/rush-arrow.png">
                        </div> 
                        <input type="submit" id="submit-order" class="frm-submit" value="RUSH MY ORDER">
                    </div>
                        <p class="scr_txt">100% safe and secure transactions</p>
                        <img src="images/frm-verified.jpg" alt="" class="verified_img" />
                        </div>


                        
                    </div>
                </form>
            </div>
        </div>
        <div class="footer">
        <center><img src="images/verified_logo_2.png" alt="" class="ftr_img" /></center>
        <p>For Any Question Email Us: support@nutriherbs.in <br />
Or call Us:+91 11 6525 2786 <br />
Open Monday - Friday 9:00 Am To 6:00 PM IST <br />
Nutriherbs. © <script type="text/javascript">var year = new Date();document.write(year.getFullYear());</script>. All Rights Reserved.</p>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
<script type="text/javascript" src="js/checkout.js"></script>
<script>
    $(document).ready(function(){
          var pay_method = $('input[name=\'payment_type\']:checked').val();  
         Auto_load_Product(<?php echo $preSelectedProductId; ?>, pay_method);
    });
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$('.box1').click(function(e) {
            $('.box1').addClass('selected');
			$('.box2').removeClass('selected');
			$('.box3').removeClass('selected');
			$('#prd_img').html('<img src="images/total_btl.png" alt=""/>')
			$('#prd_desc').html('<p class="prd_txt1">3 MONTH SUPPLY - GET 3 FREE</p>')
			$('#prc').html('<p class="prd_txt2">₹5999</p>')
			$('#tot_prc').html('<p class="prd_txt2">₹4999</p>')
        });
		$('.box2').click(function(e) {
            $('.box2').addClass('selected');
			$('.box1').removeClass('selected');
			$('.box3').removeClass('selected');
			$('#prd_img').html('<img src="images/total_btl_2.png" alt=""/>')
			$('#prd_desc').html('<p class="prd_txt1">2 MONTH SUPPLY - GET 2 FREE</p>')
			$('#prc').html('<p class="prd_txt2">₹4999</p>')
			$('#tot_prc').html('<p class="prd_txt2">₹4999</p>')
        });
		$('.box3').click(function(e) {
            $('.box3').addClass('selected');
			$('.box1').removeClass('selected');
			$('.box2').removeClass('selected');
			$('#prd_img').html('<img src="images/total_btl_3.png" alt=""/>')
			$('#prd_desc').html('<p class="prd_txt1">1 MONTH SUPPLY - 1 Bottle</p>')
			$('#prc').html('<p class="prd_txt2">₹2499</p>')
			$('#tot_prc').html('<p class="prd_txt2">₹2499</p>')
        });
	});
</script>
<?php echo $footer_scripts; ?>
</body>
</html>

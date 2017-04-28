<?php
error_reporting(0);
session_start();
require "include/common.php";


$api=$obj->ApiAccess();
$ch='';
$ssd='';
if(!empty($_GET['ch'])){  
  $ch=$_GET['ch'];
  unset($_GET['ch']);
  $ssd=implode(',', $_GET);
}
########################################################################################################
 ################################ Required Code for all template starts here ############################
	//print_r($api['fb_data']);
 	foreach($api['tracker_data'][0] as $key=>$value){ $$key = $value; }
	foreach($api['header_data'] [0] as $key=>$value){ $$key = $value; }
	foreach($api['footer_data'] [0] as $key=>$value){ $$key = $value; }
	
	//Header Scripts
	$header_scripts ='';
	if(!empty($header_script) && $show_on_landing_h == 'on'){
		$header_scripts .= html_entity_decode($header_script);
	}
	foreach($api['fb_data'] as $key=>$value){ 
		if($value['channel_id'] == $ch && $value['type'] == 'facebook' && $value['show_on_landing'] == 'on' ){
			$header_scripts .= $obj->facebook_pixel_lead($value['pixel_code']); 
		}
		if($value['channel_id'] == '*' && $value['type'] == 'facebook' && $value['show_on_landing'] == 'on' ){
			$header_scripts .= $obj->facebook_pixel_lead($value['pixel_code']); 
		}
		
		if($value['channel_id'] == $ch && $value['type'] == 'gocloud' && $value['show_on_landing'] == 'on' ){
			$header_scripts .= $obj->Offer_Conversion_Pixel_Code($_SESSION['CH_AFFILIATE_ID']);
		}

	} 

	//Footer Scripts
	$footer_scripts = '';
	if(!empty($footer_script) && $show_on_landing_f == 'on' ){
		$footer_scripts .= html_entity_decode($footer_script);
	}
	if(!empty($tracker_id)){
		if($tracker == 'hotjar' && $show_on_landing_s == 'on' ){
			$footer_scripts .= $obj->track_hotjar($tracker_id);
		}
		
		if($tracker == 'mouseflow'  && $show_on_landing_s == 'on' ){
			$footer_scripts .= $obj->track_mouseflow($tracker_id);
		}
		
		if($tracker == 'crazyegg'  && $show_on_landing_s == 'on' ){
			$footer_scripts .= $obj->track_crazyegg($tracker_id);
		}

	} 
	################################# Required Code for all template ends here #############################
	########################################################################################################	
if(isset($_POST['submit'])){
    $param=array();

    if(isset($_POST['firstname']) && $_POST['firstname']==''){
      $_SESSION['firstname']='Please enter the firstname...!';
    } else {
      unset($_SESSION['firstname']);
       $param['firstname']       =  $_POST['firstname'];
    }
    if(isset($_POST['lastname']) && $_POST['lastname']==''){
      $_SESSION['lastname']='Please enter the firstname...!';
    } else {
      unset($_SESSION['lastname']);
      $param['lastname']        =  $_POST['lastname'];
    }  
    if(isset($_POST['address_1']) && $_POST['address_1']==''){
      $_SESSION['address_1']='Please enter the address_1...!';
    } else {
      unset($_SESSION['address_1']);
       $param['address_1']       =  $_POST['address_1'];
    }  
    if(isset($_POST['city']) && $_POST['city']==''){
      $_SESSION['city']='Please enter the city...!';
    } else {
      unset($_SESSION['city']);
       $param['city']       =  $_POST['city'];
    }  

    if(isset($_POST['postcode']) && $_POST['postcode']==''){
      $_SESSION['postcode']='Please enter the post code...!';
    } else {
       unset($_SESSION['postcode']);
       $param['postcode']       =  $_POST['postcode'];
    }    
    if(isset($_POST['zone_id']) && $_POST['zone_id']==''){
      $_SESSION['zone_id']='Please Select the state name...!';
    } else {
       unset($_SESSION['zone_id']);
       $param['zone_id']         =  $_POST['zone_id'];
    }  
    if(isset($_POST['telephone']) && $_POST['telephone']==''){
      $_SESSION['telephone']='Please enter the telephone...!';
    } else {
       unset($_SESSION['telephone']);
       $param['telephone']       =  $_POST['telephone'];
    }
    if(isset($_POST['email']) && $_POST['email']==''){
      $_SESSION['email']='Please enter the Email Id...!';
    } else {
        unset($_SESSION['email']);
        $param['email']           =  $_POST['email'];
    }

    
    if(!empty($param['firstname']) && !empty($param['lastname']) && !empty($param['address_1']) && !empty($param['city']) && !empty($param['postcode']) && !empty($param['zone_id']) && !empty($param['telephone']) && !empty($param['email'])){
   
      unset($_SESSION['OLD']);
      $param['address_2']       =  $_POST['address_2'];
      $param['product_id']      =  '32';  
      $param['initial_status']  =  'lead';  
      $param['reference_url']   =  $_SERVER['HTTP_X_FORWARDED_PROTO'] . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $param['sub_aff']         =  $_POST['sub_aff'];
      $param['affiliate']       =  $_POST['affiliate'];
      $param['offer_id']        =  $_POST['offer_id']?$_POST['offer_id']:'';
      $param['aff_id']          =  $_POST['aff_id']?$_POST['aff_id']:'';
      $param['ip']              =  $_SERVER['REMOTE_ADDR'];

      $_SESSION['CH_AFFILIATE_ID']        =  $_POST['sub_aff']?$_POST['sub_aff']:'';
      $_SESSION['CH_ID']        =  $_POST['affiliate']?$_POST['affiliate']:'';



        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
           $param['forwarded_ip'] =  $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
           $param['forwarded_ip'] =  $_SERVER['HTTP_CLIENT_IP'];
        } else {
           $param['forwarded_ip'] = '';
        }

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
           $param['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        } else {
           $param['user_agent'] = '';
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
          $param['accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        } else {
          $param['accept_language'] = '';
        }

      //  print_r($param);
     //  exit;
        
        $return_details=$obj->addOrders($param);   

         if(!empty($return_details['error'])){
              print_r($return_details);
              exit; 
         } 
          

        $_SESSION['order_id']=$return_details['order_id'];

        $_SESSION['customer_id']=$return_details['customer_id'];
		
		
	 $zone_id = $_POST['zone_id'];
	 $pin_code = $_POST['postcode'];
	
	$query_string = '';
	
	if($zone_id == 1488 ){ // redirect for Jammu and prepaid methods
	

	 $query_string .= '&firstname='.$_POST['firstname'].'&lastname='.$_POST['lastname'].'&address_1='.$_POST['address_1'].'&address_2='.$_POST['address_2'].
	'&city='.$_POST['city'].'&postcode='.$pin_code.'&email='.$_POST['email'].'&telephone='.$_POST['telephone'].'&zone_id='.$zone_id.
	
	'&landingurl='.$_SERVER[HTTP_HOST].'&upr=upr'.'&sub_aff='.$_POST['sub_aff'].'&affiliate='.$_POST['affiliate'].
	'&offer_id='.$_POST['offer_id'].'&aff_id='.$_POST['aff_id'];
	//header("location:https://www.nutriherbs.in/index.php?route=garcinia/pphome".$query_string);
  header("location:https://www.nutriherbs.in/staging2/index.php?route=garcinia/pphome".$query_string);
	exit;
	}
	
	//2. UP show only products less than 5000
	$exclude_postcodes = "110021,110022,110030,110037,110038,110043,110047,110050,110057,110058,110061,110066,110067,110069,110070,110071,110072,110073,110074,110075,110077,110078,110079,122000,122001,122002,122003,122004,122005,122006,122007,122008,122009,122010,122011,122012,122013,122014,122015,122016,122017,110001,110002,110004,110005,110006,110008,110011,110055,110007,110009,110012,110028,110033,110034,110035,110036,110039,110040,110041,110042,110052,110054,110056,110081,110082,110083,110084,110085,110086,110087,110088,110089,110003,110013,110014,110016,110017,110019,110020,110023,110024,110025,110029,110044,110048,110049,110060,110062,110065,110068,110076,110080,121003,121011,121101,121103,121107,110031,110032,110051,110053,110090,110091,110092,110093,110094,110095,110096,110097,110098,201001,201002,201003,201004,201005,201007,201009,201010,201011,201012,201014,201202,201300,201301,201302,201303,201304,201305,201306,201307,201309,201310,110010,110015,110018,110026,110027,110045,110046,110059,110063,110064,141001,141002,141003,141004,141005,141006,141007,141008,141009,141010,141011,141012,141013,141014,141015,140301,140603,160002,160003,160004,160008,160009,160010,160011,160012,160014,160015,160017,160018,160019,160020,160021,160022,160023,160024,160025,160029,160030,160035,160036,160037,160038,160040,160043,160047,160049,160055,160056,160058,160059,160061,160062,160063,160064,160065,160066,160071,160072,160101,160106,302001,302002,302003,302004,302005,302006,302007,302008,302009,302010,302011,302012,302013,302015,302016,302017,302018,302019,302020,302021,302022,302023,360001,360002,360003,360004,360005,360006,380001,380002,380004,380005,380006,380007,380008,380009,380013,380014,380015,380016,380017,380018,380022,380025,380027,380028,380050,380051,380052,380054,380055,380060,380061,380063,382224,382424,382480,382481,387001,387002,390001,390002,390003,390004,390005,390006,390008,390009,390010,390011,390013,390014,390016,390018,390019,390023,392001,392002,392011,392015,393002,394115,394101,394107,394210,395001,395002,395003,395004,395005,395006,395007,395008,395009,395010,395023,396010,400022,400024,400029,400031,400037,400042,400043,400046,400049,400050,400051,400052,400053,400054,400055,400056,400057,400058,400059,400061,400069,400070,400071,400072,400073,400074,400075,400076,400077,400078,400079,400080,400081,400082,400083,400084,400085,400086,400087,400088,400089,400093,400094,400096,400098,400099,400001,400002,400003,400004,400005,400006,400007,400008,400009,400010,400011,400012,400013,400014,400015,400016,400017,400018,400019,400020,400021,400023,400025,400026,400027,400028,400030,400032,400033,400034,400035,400036,400038,400039,400060,400062,400063,400064,400065,400066,400067,400068,400090,400091,400092,400095,400097,400101,400102,400103,400104,400614,400701,400703,400705,400706,400708,400709,400710,410209,410210,400601,400602,400603,400604,400605,400606,400607,400608,400609,400610,400615,403001,403002,403004,403501,403502,403503,403505,403509,403510,403511,403515,403516,403517,403521,403401,403601,403602,403705,403706,403708,403710,403722,403802,411001,411002,411006,411009,411011,411013,411014,411028,411029,411030,411036,411037,411038,411040,411042,411043,411052,411003,411004,411005,411007,411008,411010,411012,411016,411017,411018,411019,411020,411026,411027,411034,411045,413001,413002,413003,413004,413005,413006,416001,416002,416003,416004,416005,416006,416007,416012,416406,416410,416414,416415,416416,416436,421302,422001,422002,422003,422008,423105,423203,431001,431003,431601,431602,431604,452001,452002,452003,452004,452005,452006,452007,452008,452009,452010,452011,452012,452013,452014,452015,452017,452018,500001,500002,500003,500004,500005,500006,500007,500009,500010,500011,500012,500013,500015,500016,500020,500022,500023,500024,500025,500026,500027,500029,500035,500036,500037,500039,500040,500042,500044,500047,500053,500054,500056,500058,500059,500060,500062,500063,500064,500065,500066,500068,500069,500070,500071,500074,500076,500077,500079,500080,500092,500095,500097,500098,500008,500018,500019,500028,500032,500033,500034,500038,500041,500045,500046,500048,500049,500050,500057,500072,500073,500075,500081,500082,500084,500085,500089,500090,500096,560001,560002,560004,560009,560011,560018,560019,560025,560027,560030,560041,560042,560052,560053,560007,560008,560017,560038,560047,560071,560075,560093,560003,560010,560012,560013,560014,560015,560020,560021,560022,560023,560026,560031,560039,560040,560044,560054,560055,560056,560057,560058,560059,560060,560072,560079,560080,560086,560096,560097,560098,560005,560006,560024,560032,560033,560043,560045,560046,560063,560064,560065,560077,560084,560092,560094,560028,560029,560034,560035,560050,560051,560061,560062,560068,560069,560070,560076,560078,560081,560083,560085,560095,560099,560100,560102,575001,575002,575003,575004,575005,575006,575007,575008,575009,575010,575011,575013,575014,575015,575016,575018,575019,575022,575028,575030,600015,600016,600017,600020,600022,600026,600027,600032,600033,600042,600043,600044,600061,600078,600083,600085,600087,600088,600089,600091,600092,600093,600097,600107,600114,600116,380023,380024,380026,133001,133003,133005,133006,133021,134001,134002,134003,134005,134007,144001,144002,144003,144004,144005,144006,144007,144008,282001,282002,282003,282004,282005,282006,282007,282008,282009,282010,132102,132103,132106,132140,132104,132105,132145,171001,171002,171003,171004,171009,146001,146024,125055,249408,249401,249403,249407,249402,249404,249405,700002,700003,700004,700005,700006,700007,700009,700010,700011,700012,700028,700030,700037,700048,700050,700051,700052,700054,700055,700059,700064,700065,700067,700074,700079,700080,700081,700085,700089,700091,700097,700098,700101,700102,700106,700019,700029,700031,700032,700033,700039,700040,700041,700042,700045,700046,700047,700053,700068,700070,700075,700078,700084,700086,700092,700093,700094,700095,700096,700099,700100,700103,700105,700107,641601,641602,641603,641604,641605,641606,641607,641608,641652,641004,641006,641009,641011,641012,641018,641028,641037,641038,641044,641045,403512,403523,403524,403527,403701,403704,403715,403718,403724,403725,410206,410208,410211,410218,560016,560036,560037,560048,560049,560066,560067,560087,560103,580001,580002,580003,580004,580005,580006,580007,580008,580009,580010,590001,590002,590003,590004,590005,590006,590007,590008,590009,590010,590011,590014,590015,590016,440006,440033,440019,440016,440002,440012,500055,502032,500014,500017,500052,500083,500087,500078,403507,533101,533102,533103,533104,533105,533106,533107,530001,530002,530003,530004,530013,530016,530017,530020,530022,520001,520002,520003,520004,520009,520011,473551,570001,570002,570003,570004,570005,570006,570007,570008,570009,570010,570011,570012,570013,570014,570015,570016,570017,570018,570019,570020,570021,570022,570023,570024,570025,570026,570027,570028,570029,570030,800001,800002,800003,800004,800005,800006,800007,800008,800009,800010,800011,800012,800013,800014,800015,800016,800017,800018,800019,800020,800021,800022,800023,800024,800025,800026,800027,800028,800029,421501,421503,421001,421002,421003,421004,421005,421301,421201,421202,396195,396220,396210,600034,600024,600094,600031,600002,600006,600018,600035,600008,600003,600007,600010,600029,600106,600005,600014,600004,600028,600084,600023,600038,396191,226001,226002,226003,226004,226005,226006,226007,226008,226009,226010,226011,226012,226013,226014,226015,226016,226017,226018,226019,226021,226024,226028,226031,226101,226102,226103,226104,226201,226202,226203,226301,226302,226303,226401,226501,248001,248002,248003,248005,248007,248008,248009,248010,248115,248121,248126,248140,248141,248161,248171,485001,834001,834002,834003,834004,834005,834006,834008,834009,834010,834011,834012,835215";
	$exclude_postcodes_array = explode(',',$exclude_postcodes);
	if($zone_id == 1505 && !in_array($pin_code, $exclude_postcodes_array)){ // UP show only products less than 5000
		
		
		 $query_string .= '?h=1';
		
	}
	
	//3. If COD not avail redirect to prepaid page.
	if(!empty($pin_code)){
		
		$cod_status = $obj->cod_avail_check($pin_code);
	   if($cod_status['row']['checked'] && $cod_status['row']['is_serviceable'] =='')
	   {

	$query_string3 .= '&firstname='.$_POST['firstname'].'&lastname='.$_POST['lastname'].'&address_1='.$_POST['address_1'].'&address_2='.$_POST['address_2'].
	'&city='.$_POST['city'].'&postcode='.$pin_code.'&email='.$_POST['email'].'&telephone='.$_POST['telephone'].'&zone_id='.$zone_id.
	
	'&landingurl='.$_SERVER[HTTP_HOST].'&upr=upr'.'&sub_aff='.$_POST['sub_aff'].'&affiliate='.$_POST['affiliate'].
	'&offer_id='.$_POST['offer_id'].'&aff_id='.$_POST['aff_id'];		
	  //	header("location:https://www.nutriherbs.in/index.php?route=garcinia/pphome".$query_string3);

    header("location:https://www.nutriherbs.in/staging2/index.php?route=garcinia/pphome".$query_string3);
		exit;
	   }
	}
		
	header("location:select-package.php".$query_string);
    exit;
    } else {
           $_SESSION['OLD']=$param;    
           header("location:shipping.php");
           exit;
    }


      

}

if(isset($_SESSION['OLD'])){
  $get_value=$_SESSION['OLD'];
} else {
  $get_value='';
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
.text-danger {
    color: #f56b6b;
}
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


</style>
</head>
<body>
<div class="container">

  <img src="mobile/images/shipping-hd.jpg"alt="" />
<div id="trialsec2">



<form method="post" enctype="multipart/form-data" action="" name="order-info" id="order-info">
       <?php if(!empty($_REQUEST['ch']) && !empty($ch)){?>
                      <input type="hidden" name="sub_aff" id="cid" value="<?php echo $ssd; ?>"/>
                      <input type="hidden" name="affiliate" id="chan" value="<?php echo $ch; ?>" />
                      <input type="hidden" name="offer_id" id="offer_id" value="<?php echo $_REQUEST['offer_id']; ?>"/>
                      <input type="hidden" name="aff_id" id="aff_id" value="<?php echo $_REQUEST['aff_id']; ?>" />
       <?php } ?>
    
        <div class="clearfix"></div>
    <div class="trialform" >
            	<div class="trial-top">
                	<p class="trial-toptxt1">VERIFY YOUR SHIPPING INFO<br>
                    <span>Please submit shipping details for guaranteed <br>delivery. 
                    Your order is almost complete.</span></p>
                </div>
                <div class="brd"></div>
           		 <div class="trialfrmmid">                                                       
                   <div class="formbox">
                                <div class="frmelmnts1">                                          
                                <label>First Name&#58;</label><br>
                                <input type="text" id="input-firstname" name="firstname" value="<?php echo $get_value['firstname'];?>" placeholder="e.g. first name" >
                                <?php if(!empty($_SESSION['firstname'])){?>
                                <div class="text-danger"><?php echo $_SESSION['firstname'];?></div>
                                <?php } ?>
                                </div>
                           
                                <div class="frmelmnts1">
                                                                
                                <label>Last Name&#58;</label><br>
                                <input type="text" id="input-lastname" value="<?php echo $get_value['lastname'];?>" name="lastname" placeholder="e.g. last name">
                                <?php if(!empty($_SESSION['lastname'])){?>
                                <div class="text-danger"><?php echo $_SESSION['lastname'];?></div>
                                <?php } ?>
                                </div>  
                                </div>  
                                <div class="clearfix"></div>                

                                <div class="frmelmnts2">
                                <label>Address 1&#58;</label><br>
                                <input type="text" id="input-address-1" value="<?php echo $get_value['address_1'];?>" name="address_1">
                                <?php if(!empty($_SESSION['address_1'])){?>
                                <div class="text-danger"><?php echo $_SESSION['address_1'];?></div>
                                <?php } ?>
                                </div>

                                <div class="frmelmnts2">
                                <label>Address 2&#58;</label><br>
                                <input type="text" id="input-address-2" name="address_2">
                              <!--   <input type="hidden" id="postcode_check" value=""> -->

                                </div>


                                <div class="clearfix"></div>

                                <div class="frmelmnts2">
                                                                
                                <label>City&#58;</label><br>
                                <input type="text" id="input-city" value="<?php echo $get_value['city'];?>" name="city">
                                <?php if(!empty($_SESSION['city'])){?>
                                <div class="text-danger"><?php echo $_SESSION['city'];?></div>
                                <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                             <div class="formbox">   

                                 <div class="frmelmnts1" >                                          
                                <label>State</label><br>
                                         <select name="zone_id" id="input-state" style="height:53px; line-height:57px;     width:263px;" onchange="state_change()">
                                         <option value="*">Select State</option>
                                          <?php foreach ($api['state'] as $result) {?>

                                          <?php if(!empty($get_value['zone_id']) && $get_value['zone_id']==$result['zone_id']){?>
                                               <option value="<?php echo $result['zone_id'];?>" selected><?php echo $result['name'];?></option>

                                          <?php } else {?>                                         
                                             <option value="<?php echo $result['zone_id'];?>"><?php echo $result['name'];?></option>
                                          <?php } ?>   
                                          <?php } ?>
            
                                   </select>
                                    <?php if(!empty($_SESSION['zone_id'])){?>
                                      <div class="text-danger"><?php echo $_SESSION['zone_id'];?></div>
                                    <?php } ?>  
            
                                  </div>                            
                                <div class="frmelmnts1">             
                                            <label>Zip Code</label><br>
                                            <input type="text" maxlength="6" value="<?php echo $get_value['postcode'];?>" id="input-postcode" name="postcode" onkeyup="setvalue_pincode()">
                                            <?php if(!empty($_SESSION['postcode'])){?>
                                            <div class="text-danger"><?php echo $_SESSION['postcode'];?></div>
                                            <?php } ?>    
                              <!-- add postal code check  24-04-2017 -->
                                <input type="hidden" name="postcode_check" value="" id="postcode_check"  class="textbox validate[required] post-code form-control"/>        
                                 </div>
                              
                              </div>
                               <div class="clearfix"></div>
                               
                                            <div class="frmelmnts2">
                                            <label>Phone Number&#58;</label><br>
                                            <input type="text" id="input-telephone" maxlength="11" value="<?php echo $get_value['telephone'];?>"  name="telephone" placeholder="Where we can call you">
                                            <?php if(!empty($_SESSION['telephone'])){?>
                                              <div class="text-danger"><?php echo $_SESSION['telephone'];?></div>
                                            <?php } ?>  
                                            </div>  
            
                                            <div class="clearfix"></div>
            
                                            <div class="frmelmnts2">
                                            <label>E-mail&#58;</label><br>                  
            
                                            <input type="text" id="input-email" value="<?php echo $get_value['email'];?>"  name="email" placeholder="where we can email you" >
                                            <?php if(!empty($_SESSION['email'])){?>
                                              <div class="text-danger"><?php echo $_SESSION['email'];?></div>
                                            <?php } ?> 
            
                                            </div>  
            </div>   
                   <div class="clearfix"></div>
                
      <div class="upbtm">
                   <div class="clearfix"></div>
                         <p class="scure-lock"> <img src="mobile/images/lock.png" alt=""/></p>
                      <div class="btncontainer" style="margin:2% auto 2% auto;">
                        <center>  <button type="submit"  id="btnSubmit" name="submit" class="button bg-none">
                           <img src="mobile/images/ck-btn.png" width="540" height="99" alt="" />
                            </button></center></div>
                 <center><img src="mobile/images/scure.png" alt=""  class="scure"/></center>
                  </div>
            
             </div> 
              </form>         
                        
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
</div>
<script src="js/formvalidation1.min.js"></script>

<script type="text/javascript" src="mobile/js/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="mobile/css/jquery.fancybox.min.css">
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();			   
	});
</script>	
<?php ######################Change and replace below zipcode and state dropdown ID with your HTML code#################### ?>
<script>
$('#input-postcode').blur(function(){
  var pin_code = $('#input-postcode').val();
  var zone_id = $("#input-state").val();
  var url = "include/servicecheck.php?pin_code="+pin_code+"&zone_id="+zone_id;
  var url_postal = "include/postalcodecheck.php?pin_code="+pin_code+"&zone_id="+zone_id;
    
    if ( pin_code.length == 6 && pin_code != "" ){
    //alert(url);
     
  $.ajax({
          url: url_postal,
          dataType: 'json',         
          success: function(json1) { 

               $('#postcode_check').val(json1.result);
          },
          error: function(xhr, ajaxOptions, thrownError) {

          // alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

              //document.getElementById('input-postcode').focus();
          }
        }); 

      $.ajax({
          url: url,
          dataType: 'json',         
          success: function(json) {          
           
          },
          error: function(xhr, ajaxOptions, thrownError) {
           // alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        }); 
  }
  
  
 });




//// set a value onkeyup//////////
function setvalue_pincode() {
    $('#postcode_check').val("0");
}

function state_change(){

  $('#postcode_check').val("0");
}




$("#btnSubmit").mouseover(function(){

    var pin_code = $('#input-postcode').val();
    var zone_id = $("#input-state").val();
    var postcode_check = $("#postcode_check").val();

    var url_postal = "include/postalcodecheck.php?pin_code="+pin_code+"&zone_id="+zone_id;
    
    if(postcode_check=='' || postcode_check==0){


 $.ajax({
          url: url_postal,
          dataType: 'json',         
          success: function(json1) { 

               $('#postcode_check').val(json1.result);
          },
          error: function(xhr, ajaxOptions, thrownError) {

          // alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

              //document.getElementById('input-postcode').focus();
          }
        }); 

}


 });
////// end the postal code  /////////

</script>   
<?php 
 	echo $footer_scripts;
?> 			 		  					  			
</body>
</html>

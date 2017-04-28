<?php
error_reporting(0);
session_start();
unset($_SESSION['CH_ID']);

require "include/common.php";

$user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
$url = "https://" . $_SERVER['HTTP_HOST'];
$i = 1;
if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|ucweb|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
    $link='';
    foreach ($_GET as $key => $value) {
        if($key=='ch'){
            $link='?'.$key.'='. $value; 
						
			
        } else {
            $link .='&'.$key.'='. $value;
        }  
    }
   
   header("location:mob-index.php$link"); 
   exit;   
}

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
	//print_r($api);
	foreach($api['tracker_data'][0] as $key=>$value){ $$key = $value; }
	foreach($api['header_data'] [0] as $key=>$value){ $$key = $value; }
	foreach($api['footer_data'] [0] as $key=>$value){ $$key = $value; }
	
	//Header Scripts
	$header_scripts ='';
	if(!empty($header_script) && $show_on_landing_h == 'on'){ //raw header
		$header_scripts .= html_entity_decode($header_script);
	}
	//print_r($api['fb_data']);
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
		//$tracker.$tracker_id.$show_on_landing_s.$show_on_cart_s.$show_on_checkout_s;
	}
	################################# Required Code for all template ends here #############################
	########################################################################################################	
	
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(isset($_POST) && !empty($_POST)){


/*-------statrt validation code  25-04-2017------*/
if($_POST['firstname']=='' || $_POST['lastname']=='' || $_POST['address_1']=='' || $_POST['address_2']=='' || $_POST['city']=='' || $_POST['zone_id']=='' || $_POST['postcode']=='' || $_POST['telephone']==''|| $_POST['email']==''){

/////// start validatation code  25-04-2017////////////

$firstErr = $lasttErr = $addressErr = $address1Err = "";

$cityErr = $stateErr = $postalcodeErr = "";

$telephone = $emailErr = "";

/////// first name validate ///////////////
        if (empty($_POST["firstname"])) {
             $firstErr = "FirstName is required";

        } else {
             $firstname = test_input($_POST["firstname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
             $firstErr = "Only letters"; 
         }
        }

///// last name validate /////////////////
        if (empty($_POST["lastname"])) {
             $lasttErr = "LastName is required";
        } else {
             $lastname = test_input($_POST["lastname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
             $lasttErr = "Only letters and white space allowed"; 
        }
        }

//////// Address one validated  ///////////

        if (empty($_POST["address_1"])) {
             $addressErr = "Address  is required";
        } 

//////// Address_2 one validated  ///////////

       if (empty($_POST["address_2"])) {
             $address1Err = "Address  is required";
        } 

  //////// City one validated  ///////////

        if (empty($_POST["city"])) {
             $cityErr = "City  is required";
        } 

        ////////// state validatation ///////////

          if ($_POST["zone_id"] == '*') {
             $stateErr = "State  is required";
        } 

        //////// postcode one validated  ///////////

     if (empty($_POST["postcode"])) {

             $postalcodeErr = "Postcode  is required";
        } else {
             $postcode = test_input($_POST["postcode"]);

             if(strlen($postcode) > 6 || strlen($postcode) < 6){

                  $postalcodeErr = "Valid Postcode  is required";

             }
        
        } 

////////// mobile number validatation  ///////

  if (empty($_POST["telephone"]))
  {
          $telephoneErr = "Mobile number is required";
  }else{
          $value = $_POST["telephone"];

     if(!preg_match('/^\+?([0-9]{1,4})\)?[-. ]?([0-9]{9})$/', $value) ) {

              $telephoneErr = 'Please enter a valid phone number';

/*        }else if(strlen($value) > 9 || strlen($value) < 13){

               $telephoneErr = 'Please enter a valid phone number';
*/
          }else{}

  }


////////////// eamil validation 
    if (empty($_POST["email"])) {
          $emailErr = "Email is required";
  } else {
           $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $emailErr = "Invalid email format"; 
    }
  } 


}

else{

  ///////end validatation code ///////////////

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
    $param['product_id']      =  '32';  
    $param['initial_status']  =  'lead';    
    $param['reference_url']   =  $_SERVER['HTTP_X_FORWARDED_PROTO'] . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param['sub_aff']         =  $_POST['sub_aff'];
    $_SESSION['CH_AFFILIATE_ID']        =  $_POST['sub_aff']?$_POST['sub_aff']:'';
    $_SESSION['CH_ID']        =  $_POST['affiliate']?$_POST['affiliate']:'';
    $param['affiliate']       =  $_POST['affiliate'];
	
    $param['offer_id']        =  $_POST['offer_id']?$_POST['offer_id']:'';
    $param['aff_id']          =  $_POST['aff_id']?$_POST['aff_id']:'';
    $param['ip']              =  $_SERVER['REMOTE_ADDR'];

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
    
   $return_details=$obj->addOrders($param); 
    if(!empty($return_details['error'])){
         print_r($return_details);
         exit; 
    } 

   // print_r($return_details);
   // exit; 
/*  	$_SESSION['order_id'] ='';
	$_SESSION['customer_id']='';  */
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
	
	
	//header("location:https://www.nutriherbs.in/garcinia3_p".$query_string);
	
	 header("location:https://www.nutriherbs.in/index.php?route=garcinia/pphome".$query_string);
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
		//$sub_aff = !empty($_POST['sub_aff']) ? "&offer_id=".$_POST['offer_id'] : ""; 
		$query_string3 .= '&firstname='.$_POST['firstname'].'&lastname='.$_POST['lastname'].'&address_1='.$_POST['address_1'].'&address_2='.$_POST['address_2'].
	'&city='.$_POST['city'].'&postcode='.$pin_code.'&email='.$_POST['email'].'&telephone='.$_POST['telephone'].'&zone_id='.$zone_id.'&landingurl='.$_SERVER[HTTP_HOST].'&upr=upr'
	.'&sub_aff='.$_POST['sub_aff'].'&affiliate='.$_POST['affiliate'].
	'&offer_id='.$_POST['offer_id'].'&aff_id='.$_POST['aff_id'];		
		
		header("location:https://www.nutriherbs.in/index.php?route=garcinia/pphome".$query_string3);
		exit;
	   }
	}
	
    header("location:checkout.php".$query_string);
////// addd this } else cloase /////
}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Garcinia Cambogia</title>
<link href="css/style.min.css" rel="stylesheet" type="text/css" />
<link href="fonts/fonts.min.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<style>
img.shine {
    position: absolute;
    left: 0;
    top: 583px;
    height: 69px;
    z-index:999;
}

</style>

<?php  
include_once('pixel.php');
echo $header_scripts;
?>

</head>

<body>

<div id="container">
	<div id="header">
        <p class="hdrtxt"><b>WARNING:&nbsp;</b>Due to increased demand for our free trial we cannot guarantee supply. As of  
                <span><script>
                
                var mydate=new Date()
                var year=mydate.getYear()
                if (year < 1000)
                year+=1900
                var day=mydate.getDay()
                var month=mydate.getMonth()
                var daym=mydate.getDate()
                if (daym<10)
                daym="0"+daym
                var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
                var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
                document.write("<font color='fcff00' face=''Roboto', sans-serif;', sans-serif;'>"+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"</font>")
                
                </script></span> we currently have the product <b>IN STOCK</b> and are ready to ship within 24 hours of purchase.</p>
    </div>
	<div id="secone">			
    	<div class="contentWrap" id="bdone"> 
            <img src="images/product.png"  alt="" class="sec1-product1" />
            <img src="images/seal_index.png" alt="" class="seal_index" />
            <div class="form-position">

                           <form method="post" enctype="multipart/form-data" action="" name="order-info" id="order-info">
                                 <?php if(!empty($_REQUEST["ch"]) && !empty($ch)){?>
                                                  <input type="hidden" name="sub_aff" id="cid" value="<?php echo $ssd; ?>"/>
                                                  <input type="hidden" name="affiliate" id="chan" value="<?php echo $ch; ?>" />
                                                  <input type="hidden" name="offer_id" id="offer_id" value="<?php echo $_REQUEST['offer_id']; ?>"/>
                                                  <input type="hidden" name="aff_id" id="aff_id" value="<?php echo $_REQUEST['aff_id']; ?>" />
                                   <?php } ?>
                                <span style="color:red; margin-left: 104px;"><?php //echo $firstErr; ?></span>                      
                            <div class="frmElemts">
                                <label id="input-firstname1" for="input-firstname2">First Name:</label>
                                <input type="text" name="firstname" value="<?php echo $_POST['firstname'];  ?>" placeholder="First Name" id="input-firstname" class="textbox validate[required] form-control <?php  if($firstErr!=''){ echo 'firstnameErr'; }  ?>" />
                                 
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                                <label id="input-lastname1" for="input-lastname2">Last Name:</label>
                                <input type="text" name="lastname" value="<?php echo $_POST['lastname'];  ?>" placeholder="Last Name" id="input-lastname" class="textbox validate[required]form-control  <?php  if($lasttErr!=''){ echo 'lastnameErr'; }  ?>" />                               
                               <!--  <span style="color:red; margin-left: 104px;"><?php echo $lasttErr; ?></span> -->
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                               <label id="input-address-10" for="input-address-10">Address 1:</label>
                               <input type="text" name="address_1" value="<?php echo $_POST['address_1'];  ?>" placeholder="Address 1" maxlength="36" id="input-address-1" class="textbox validate[required] form-control <?php  if($addressErr!=''){ echo 'address_oneErr'; }  ?>" />
                              <!--  <span style="color:red; margin-left: 104px;"><?php echo $addressErr; ?></span> -->
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                                <label id="input-address-21" for="input-address-21">Address 2:</label>
                                <input type="text" name="address_2" value="<?php echo $_POST['address_2'];  ?>" placeholder="Address 2" id="input-address-2" class="textbox validate[required] form-control <?php  if($address1Err!=''){ echo 'address_twoErr'; }  ?>" />
                               <!--  <span style="color:red; margin-left: 104px;"><?php echo $address1Err; ?></span> -->
                            
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                                <label id="input-city1" for="input-city2">City:</label>
                                <input type="text" name="city" value="<?php echo $_POST['city'];  ?>" placeholder="City" minlength="4" id="input-city" class="textbox validate[required] form-control <?php  if($cityErr!=''){ echo 'cityErr'; }  ?>" />   
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                                <label id="input-state1" for="input-state2">State:</label>
                                <div id="new-ajay-select" style="display: initial;">
                                  <select name="zone_id" id="input-state" class="inputField myselect selectBox county <?php  if($stateErr!=''){ echo 'stateErr'; }  ?>" onchange="state_change()">
                                      <option value="*">Select State</option>
                                          <?php foreach ($api['state'] as $result) {?>
                                             <option  <?php  if($_POST['zone_id'] == $result['zone_id']){ echo "selected"; } ?>  value="<?php echo $result['zone_id'];?>"><?php echo $result['name'];?></option>
                                          <?php } ?>
                                      </select>                                                   
                                 </div> 
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                                <label id="input-postcode1" for="input-postcode2">Post Code:</label>
                                <input type="text" name="postcode" value="<?php echo $_POST['postcode'];  ?>" placeholder="Post Code" minlength="6" maxlength="6" id="input-postcode" class="textbox validate[required] post-code form-control  <?php  if($postalcodeErr!=''){ echo 'postalcodeError'; }  ?>" onkeyup="setvalue_pincode()"/>                              
                 <!--  24-04-2017 add this  -->           
                     <input type="hidden" name="postcode_check" value="" id="postcode_check"  class="textbox validate[required] post-code form-control"/>
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                                <label id="input-telephone1" for="input-telephone2">Telephone:</label>

                                <input type="text" name="telephone" value="<?php echo $_POST['telephone'];  ?>" placeholder="+91-10 digit mobile no." maxlength="11"  id="input-telephone" class="textbox validate[required] form-control <?php  if($telephoneErr!=''){ echo 'telephoneError'; }  ?>"  />
                             
                                <div class="clear"></div>
                            </div>

                            <div class="frmElemts">
                                  <label id="input-email1" for="input-email2">E-Mail:</label>
                                <input type="email" name="email" value="<?php echo $_POST['email'];  ?>" placeholder="E-Mail" id="input-email" class=" textbox validate[required,custom[email]] form-control  <?php  if($emailErr!=''){ echo 'emailErr'; }  ?>" />
                            
                                <div class="clear"></div>
                            </div> 

                              <img src="images/lock.png" alt="" class="secure-text" />
                            <div class="clearall"></div>  
                            <div class="frm-btn" > 
                                <div class="arrow-frm">              
                                      <img src="images/rush-arrow.png" alt="" class="frm-arrow" />
                                </div>
                           <!--   <button type="button" name="btnSubmit" onClick="return form_validate()" id="btnSubmit" class="frm-submit">RUSH MY ORDER</button> 
 -->


                                <input type="submit"  onClick="return form_validate()" id="btnSubmit" value="RUSH MY ORDER" class="frm-submit"> 
                            </div>
                       
                            <!--  -->
                        </form>


               <!--  -->
            </div>       
        </div>   
    </div> 	
	<div id="sectwo">
        <div class="contentWrap">
            <div class="sec-2-lft">
                <p class="sec2-txt">What is Garcinia Cambogia?</p>	
                <p class="sec2-txt2">The Miraculous Weight Loss Fruit</p>	
                <p class="sec2-txt3">From news channels to celebrity doctors on famous talk shows, the topic of conversation is on Garcinia Cambogia.  From the exotic jungles of Southeast Asia, local legend spoke about a magic fruit known as Garcinia Cambogia, sometimes called tamarind.  Small and pumpkin shaped, observers noticed that the fruit was being eaten raw in its natural form or as a flavoring agent by what seemed to be the healthiest people.
</p>	
                <p class="sec2-txt2">But Why?</p>	
                <p class="sec2-txt3">The makers of Nutriherbs Garcinia had a simple goal in mind. Uncover the secrets of this local legend and create the most effect weight loss supplement possible. Join millions of people from around the world to find out today what the media is buzzing about.
</p>
            </div>
            <div class="section-bottom-box"> 
            	<div class="btm-left-text">
             		<h4>ALL NATURAL SUPPLEMENT THAT WORKS!</h4>   
             		<p>Due to high demand, supplies are limited. Reserve your bottle today!</p>  
                </div>
             	<a href="javascript:bookmarkscroll.scrollTo('bdone')">
                	<div class="frm-btn" > 
                        <div class="arrow-frm">              
                            <img src="images/rush-arrow.png" alt="" class="frm-arrow" />
                        </div> 
                        <input type="submit" value="RUSH MY ORDER" class="frm-submit">
                    </div>
                </a>      
            </div>     
         </div>
	</div>
	<div id="secthree">
    	<div class="contentWrap">
    		<div class="sec-3-rgt">
    			<p class="sec3-txt">The Science Behind</p>	
    			<p class="sec3-txt2">Introducing Hydroxycitric Acid (HCA)</p>
    			<div class="clearall"></div>	
        		<p class="sec3-txt3">Why are scientists all over the world studying Garcinia Cambogia and the effects of HCA?  What is science so curious about? Research is focused on HCA extract from Garcinia Cambogia as a weight loss aid in two powerful ways.
</p>
				<p class="sec3-txt2 green">Helps Eliminate Fat</p>
				<div class="clearall"></div>
				<p class="sec3-txt3 helps-para">There is an enzyme in your body called Citrate Lyase that helps you turn your favorite snacks into fat. HCA aims to prevent this enzyme from producing more stored fat than you need. You could burn more tasty treats as fuel rather than store them.
</p>
				<div class="clearall"></div>
				<p class="sec3-txt2 green">Suppresses Appetite</p>
				<div class="clearall"></div>
				<p class="sec3-txt3 helps-para">Researchers are also encouraged by HCA’s ability to increase serotonin levels - a key to suppressing appetite.   Serotonin is a neurotransmitter in your brain that makes you feel good.  By increasing serotonin levels, HCA improves mood and suppresses emotional eating during stressful times.
</p>	
			</div>
   			<div class="section-bottom-box"> 
            	<div class="btm-left-text">
             		<h4>ALL NATURAL SUPPLEMENT THAT WORKS!</h4>   
             		<p>Due to high demand, supplies are limited. Reserve your bottle today!</p>  
                </div>
             	<a href="javascript:bookmarkscroll.scrollTo('bdone')">
                	<div class="frm-btn" > 
                        <div class="arrow-frm">              
                            <img src="images/rush-arrow.png" alt="" class="frm-arrow" />
                        </div> 
                        <input type="submit" value="RUSH MY ORDER" class="frm-submit">
                    </div>
                </a>      
            </div>         
   		</div>
	</div>
	<div id="secfour">
		<div class="contentWrap">
    		<div class="sec4-mid">
    			<p class="sec4-txt1">Garcinia Cambogia...</p>
    			<div class="clearall"></div>
    			<p class="sec4-txt2">Tropical species native to Indonesia</p>
    			<p class="sec4-txt3">Common names include garcinia gummi-gutta, tamarind, and brindleberry</p>
    			<p class="sec4-txt4">This fruit looks like a small pumpkin and is green to pale yellow in color </p>
    		</div>
    		<div class="sec4-rgt">
    			<p class="sec4-rgt-txt1">Why Choose Garcinia Cambogia?</p>
				<p class="sec4-rgt-txt2"><span>Nutriherbs Garcinia</span> is carefully produced in a sterile, expert lab to ensure the highest level of product quality and effectiveness; our product is a step above the rest. <br /> <br />

The greatest part of <span>Nutriherbs Garcinia</span> is it's a dual action fat buster! It prevents fat from being made and suppresses your appetite. You can aim to lose weight in a healthy, simple way!
<br /> <br />
Keep up a reasonable exercise regimen, and you can say goodbye to shopping for expensive diet foods. Go with the solution that makes sense!</p>
    		</div>
    		<div class="section-bottom-box"> 
            	<div class="btm-left-text">
             		<h4>ALL NATURAL SUPPLEMENT THAT WORKS!</h4>   
             		<p>Due to high demand, supplies are limited. Reserve your bottle today!</p>  
                </div>
             	<a href="javascript:bookmarkscroll.scrollTo('bdone')">
                	<div class="frm-btn" > 
                        <div class="arrow-frm">              
                            <img src="images/rush-arrow.png" alt="" class="frm-arrow" />
                        </div> 
                        <input type="submit" value="RUSH MY ORDER" class="frm-submit">
                    </div>
                </a>      
            </div>
    	</div>
	</div>
	<div id="secfive">
    	<div class="contentWrap">
    		<p class="sec-5-txt5">Garcinia Cambogia in the Media...</p>
    		<div class="sec-5-top">
   				<p class="sec-5-txt1">"Garcinia Cambogia has been used as a traditional weight loss & health remedy in Ayurvedic medicine. The supplement is the perfect blend of traditional knowledge and modern technology."</p>
        		<p class="sec-5-txt2">"Weight watchers, take a note of Garcinia Cambogia - this supplement has taken the US market by storm and is finally available in India. Make sure you that your supplement has at least 70% HCA for best results. "</p>
        	</div>
        	<div class="sec-5-btm">
        		<p class="sec-5-txt3">"Garcinia Cambogia has been clinically proven to help with weight loss and energy replenishment. So if you are looking to drop pounds without a drastic change in your diet or exercise routine, this may be mother natures answer! "</p>
        		<p class="sec-5-txt4">"Secretly used by celebrities across the world, this natural miracle has now been introduced in the open market! Garcinia Cambogia may not only help lose weight but also boost metabolic rate for improved fitness."</p>
        	</div>
   		</div>  
	</div>
	<div id="secsix">
        <div class="contentWrap">
            <div class="se6-rgt-txt">
                <p class="sec-6-txt1">Be Confident <br /> With Your Body!</p>
                <p class="sec-6-txt2">We are almost <span style="color:#ff8400; text-transform:uppercase;">out of stock.</span> <br />
        By placing your order today, <br />
        we can guarantee you a <span style="color:#37b500; text-transform:uppercase;">free bottle!</span></p>
            </div>
            <div class="section-bottom-box"> 
                <div class="btm-left-text">
                    <h4>ALL NATURAL SUPPLEMENT THAT WORKS!</h4>   
                    <p>Due to high demand, supplies are limited. Reserve your bottle today!</p>  
                </div>
                <a href="javascript:bookmarkscroll.scrollTo('bdone')">
                    <div class="frm-btn" > 
                        <div class="arrow-frm">              
                            <img src="images/rush-arrow.png" alt="" class="frm-arrow" />
                        </div> 
                        <input type="submit" value="RUSH MY ORDER" class="frm-submit">
                    </div>
                </a>      
            </div>
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
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/bookmarkscroll.js"></script>
<script src="js/formvalidation1.js"></script>

<style type="text/css">
.firstnameErr{ border-color: #e21f1f !important;  background-color: #f5c0c0 !important;}
.lastnameErr{ border-color: #e21f1f !important;   background-color: #f5c0c0 !important;}
.address_oneErr{ border-color: #e21f1f !important; background-color: #f5c0c0 !important;}
.address_twoErr{ border-color: #e21f1f !important; background-color: #f5c0c0 !important;}
.cityErr{ border-color: #e21f1f !important;  background-color: #f5c0c0 !important;}
.stateErr{ border-color: #e21f1f !important; background-color: #f5c0c0 !important;}
.postalcodeError{ border-color: #e21f1f !important;  background-color: #f5c0c0 !important;}
.emailErr{ border-color: #e21f1f !important;  background-color: #f5c0c0 !important;}
.telephoneError{border-color: #e21f1f !important; background-color: #f5c0c0 !important;}
</style>

<?php  
require "include/footer_script.php"; 	
echo $footer_scripts;
?>
</body>
</html>

<?php
session_start();
unset($_SESSION['CH_ID']);

$ch='';
$ssd='';
if(!empty($_GET['ch'])){    
    $ch='?ch='.$_GET['ch'];
    unset($_GET['ch']);   
    foreach ($_GET as $key => $var) {
            $ssd .='&'.$key.'='. $var;
    }
}

$url_link='shipping.php'.$ch.$ssd;

########################################################################################################
################################ Required Code for all template starts here ############################
$included_files = get_included_files();
$include = false;

foreach ($included_files as $filename) {
   if(basename($filename) == 'common.php'){
	$include = true;
   }
}

if(!$include){
	require "include/common.php";
	$api=$obj->ApiAccess();
	foreach($api['tracker_data'][0] as $key=>$value){ $$key = $value; }
	foreach($api['header_data'] [0] as $key=>$value){ $$key = $value; }
	foreach($api['footer_data'] [0] as $key=>$value){ $$key = $value; }
	
	//Header Scripts
	$header_scripts ='';
	if(!empty($header_script) && $show_on_landing_h == 'on'){
		$header_scripts .= html_entity_decode($header_script);
	}
	foreach($api['fb_data'] as $key=>$value){ 
		if($value['channel_id'] == $_GET['ch'] && $value['type'] == 'facebook' && $value['show_on_landing'] == 'on' ){
			$header_scripts .= $obj->facebook_pixel_lead($value['pixel_code']); 
		}
		if($value['channel_id'] == '*' && $value['type'] == 'facebook' && $value['show_on_landing'] == 'on' ){
			$header_scripts .= $obj->facebook_pixel_lead($value['pixel_code']); 
		}
		if($value['channel_id'] == $_GET['ch'] && $value['type'] == 'gocloud' && $value['show_on_landing'] == 'on' ){
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

}
################################ Required Code for all template ends here ##############################
########################################################################################################
?>
<!doctype html>
<html>
<head>

<meta charset="utf-8"/>
<title>Nutriherbs</title>
<meta name="description" content="Pure Garcinia Cambogia" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="content-language" content="en-us" /> 
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta name="HandheldFriendly" content="true"/>
<meta name="viewport" content="width=640, maximum-scale=1.0, user-scalable=no,  minimal-ui">    
<link href="mobile/css/magnific-popup.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="mobile/css/app.min.css" />
<link rel="stylesheet" type="text/css" href="mobile/css/special.min.css">
<?php  
include_once('pixel.php');
echo $header_scripts;
?>
</head>

<body>
                 
 <div id="lp_wrap">
    <div id="above_fold">
        <div class="lead-scroll" id="toparrows">
            <a href="#media_block" id="anchor" class="lead-link" data-placement="top" data-toggle="tooltip">
                <svg class="arrows">
                <path class="a1" stroke-linecap="round" stroke-linejoin="round" d="M0 0 L30 32 L60 0"></path>
                <path class="a2" stroke-linecap="round" stroke-linejoin="round" d="M0 20 L30 52 L60 20"></path>
                <path class="a3" stroke-linecap="round" stroke-linejoin="round" d="M0 40 L30 72 L60 40"></path>
                </svg>
            </a>
        </div>
    </div>

    <div id="media_block">
        <div class="topheader" id="madeByNature"><img src="mobile/images/made_by_nature_header.png"/></div>
        <div id="mbn_image"><img src="mobile/images/Garcinia_cluster_2.png"></div>
        <div id="mbn_content">
            <h1 class="header_content" id="mbn">What's the Secret Ingredient?</h1>
            <p class="info_content" id="mbn">Garcinia Cambogia Extract, is miraculous fat-burning 
            fruit that contains the breakthrough extract that has taken the dieting 
             world by storm —  hydroxycitcric acid, or HCA. This secret ingredient is
             scientifically proven to help maximize your weight loss program!</p>
        </div>
    </div>

    <div id="holy_grail_block">
        <div class="topheader" id="holyGrailBlock"><img src= "mobile/images/burn_fat_header.png"/></div>
        <div class="learnMoreSections" id="firstSection">
             <div class="burnFatContent" id="fatBlockerContent">
                  <img class="" src="mobile/images/fat_blocker_bg.png"/>
                  <div class="copyContainer txt1">
                      <h1 class="bfc_header" id="fatBlocker">Act as a Fat Blocker</h1>
                      <p class="fatBlockerCopy">It helps your liver burn fat instead of storing it.</p>
                    
                  </div>
             </div>
        </div>
      
        <div class="space_shadow"></div>
        <div class="learnMoreSections" id="secondSection">
            <div class="burnFatContent" id="increaseSerotonin">
                <img class="" src="mobile/images/setoronin_bg.png"/>
                <div class="copyContainer txt1">
                    <h1 class="bfc_header" id="fatBlocker">Increase Serotonin</h1>
                    <p class="fatBlockerCopy">Helps you feel full for longer and reduces cravings.</p>
                 
                </div>
            </div>
        </div>
        
        <div class="space_shadow"></div>
        <div class="learnMoreSections" id="thirdSection">
            <div class="burnFatContent" id="balanceStress">
                <img class="" src="mobile/images/balance_bg.png"/>
                <div class="copyContainer txt2">
                    <h1 class="bfc_header" id="fatBlocker">Balance Stress Hormones</h1>
                    <p class="fatBlockerCopy">Reduces cortisol levels helps you accumulate less fat.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="real_results_block">
        <div class="topheader" id="realResultsBlock">
            <img src= "mobile/images/benefits_header.png"/>
        </div>
        <div class="benefitsImage"><img src="mobile/images/benfits_bg1.jpg" /></div>
    </div>

    <div id="garcinia_work_block">
        <div class="topheader" id="garciniaWorkBlock">
            <img src= "mobile/images/how_to_header.png"/>
        </div>
        <div id="rrbList">
            <div class="benefits" id="firstStep">
                <img src="mobile/images/uno.png" alt=""/>
                <div class="rrbCopy">
                    <h1>Take the Pills</h1>
                    <p>Take one (1) capsule of Nutriherbs Garcinia Cambogia
                        <br>2-3 times a day.</p>
                </div>
            </div>
            <div class="benefits" id="secondStep">
                <img src="mobile/images/dos.png" alt=""/>
                <div class="rrbCopy">
                    <h1>Start Torching Fat</h1>
                    <p>Unleash the fat-burning power of your metabolism.</p>
                </div>
            </div>
            <div class="benefits" id="thirdStep">
                <img src="mobile/images/tres.png" alt=""/>
                <div class="rrbCopy">
                    <h1>Transform Your Body</h1>
                    <p>Get a flat belly, a firmer butt and leaner legs.</p>
                </div>
                  <img src="mobile/images/leafs.png" alt="" style="margin:-30px 0 0 0;"/>
            </div>
        </div>
    </div>

    <div id="garcinia_work_block2">
        <div class="topheader" id="garciniaWorkBlock2">
            <img src= "mobile/images/testies_header.png"/>
        </div>
        <div class="carousel">
            <div class="carousel-inner">
                <input class="carousel-open" type="radio" id="carousel-1" name="carousel" aria-hidden="true" hidden="" checked="checked">
              <div class="quotes carousel-item" id="firstImage">
                    <img src="mobile/images/before_after_1.png"/>
                    <div class="quotations_left"><img src="mobile/images/1.png"/></div>
                    <div class="quotations_right"><img src="mobile/images/2.png"/></div>
                    <!--<p class="quoteContent" id="yasmin">Happy wife and mommy!</p>-->
                <p class="slid-txt">After only 2 weeks, I started noticing a big difference! I lost my cravings and inches off of my belly!</p>
                <center><img src="mobile/images/stars.png" alt="" class="stars"> </center>
                   <p class="slid-txt2">Navya K.</p>
                </div>
                <input class="carousel-open" type="radio" id="carousel-2" name="carousel" aria-hidden="true" hidden="">
                <div class="quotes carousel-item" id="secondImage">
                    <img src="mobile/images/before_after_2.png"/>
                    <div class="quotations_left"><img src="mobile/images/1.png"/></div>
                    <div class="quotations_right"><img src="mobile/images/2.png"/></div>
                    <!--<p class="quoteContent" id="jessica">Happy wife and mommy!</p>-->
                <p class="slid-txt">I combined my bottle with some simple exercises and lost over 
15 lbs so far!</p>
                <center><img src="mobile/images/stars.png" alt="" class="stars"> </center>
                   <p class="slid-txt2">Sonali</p>
                </div>
                <input class="carousel-open" type="radio" id="carousel-3" name="carousel" aria-hidden="true" hidden="">
                <div class="quotes carousel-item" id="thirdImage">
                    <img src="mobile/images/before_after_3.png"/>
                    <div class="quotations_left"><img src="mobile/images/1.png"/></div>
                    <div class="quotations_right"><img src="mobile/images/2.png"/></div>
                    <!--<p class="quoteContent" id="tiffany">Happy wife and mommy!</p>-->
                <p class="slid-txt">I already lost over 4 inches in 1 month and I'm on my second bottle. 
I can't wait for summer to come!</p>
                <center><img src="mobile/images/stars.png" alt="" class="stars"> </center>
                   <p class="slid-txt2">Barkha M.</p>
                </div>
                <label for="carousel-3" class="carousel-control prev control-1">
                    <div class="leftside"><img src="mobile/images/left-indicator.jpg"/></div>
                </label>
                <label for="carousel-2" class="carousel-control next control-1">
                    <div class="rightside"><img src="mobile/images/right-indicator.jpg"/></div>
                </label>
                <label for="carousel-1" class="carousel-control prev control-2">
                    <div class="leftside"><img src="mobile/images/left-indicator.jpg"/></div>
                </label>
                <label for="carousel-3" class="carousel-control next control-2">
                    <div class="rightside"><img src="mobile/images/right-indicator.jpg"/></div>
                </label>
                <label for="carousel-2" class="carousel-control prev control-3">
                    <div class="leftside"><img src="mobile/images/left-indicator.jpg"/></div>
                </label>
                <label for="carousel-1" class="carousel-control next control-3">
                    <div class="rightside"><img src="mobile/images/right-indicator.jpg"/></div>
                </label>
            </div>
        </div>
       

    <div id="final_cta_block">
        <div id="Closure"><img src="mobile/images/Closure_pod.jpg"/></div>
    </div>
    
   <div id="stick_sell">
        <div class="stick_bar">
            <a target="_top" href="<?php echo $url_link; ?>"><img class="portrait" src="mobile/images/CTA_STicky.png" id="lpCTA"/></a>
            <a target="_top" href="<?php echo $url_link; ?>"><img class="landscape" src="mobile/images/CTA_STicky_landscape.png" id="lpCTA1"/></a>
            <div><a target="_top" href="<?php echo $url_link;?>"><img src="mobile/images/504.png" id="lpCTAbottle"/></a></div>
        </div>
    </div><!-- -->

 </div>

<script src="js/jquery-1.11.0.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script>
$(document).ready(function(){
	modalOnClick();
});
function modalOnClick() {
    $('.modalClick').each(function() {
        var url = $(this).attr('href');
        $(this).magnificPopup({
            closeOnContentClick: false,
            type: 'ajax',
            ajax: {
                settings: null,
                cursor: 'mfp-ajax-cur', // CSS class that will be added to body during the loading (adds "progress" cursor)
                tError: '<a href="%url%">The content</a> could not be loaded.' //  Error message, can contain %curr% and %total% tags if gallery is enabled
            },
            callbacks: {
                parseAjax: function(mfpResponse) {
                    mfpResponse.data = $(mfpResponse.data).closest('.content');
                },
                ajaxContentAdded: function() {
                    modalOnClick();
                }
            }
        });

    }).click(function(event) {
        event.preventDefault();
    });
}
</script>
<script>
	$(document).ready(function () {
		$("#first_show_dropdown").click(function () {
			$("#fatBlocker_s").slideDown("slow");
		});
		$("#first_hide_dropdown").click(function () {
			$("#fatBlocker_s").slideUp("fast");
		});
		$("#second_hide_dropdown").click(function () {
			$("#supressYourAppetite").slideUp("fast");
		});
		$("#second_show_dropdown").click(function () {
			$("#supressYourAppetite").slideDown("slow");
		});
		$('a[href="#media_block"]').click(function () {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
					&& location.hostname == this.hostname) {
				var $target = $(this.hash);
				$target = $target.length && $target
						|| $('[name=' + this.hash.slice(1) + ']');
				if ($target.length) {
					var targetOffset = $target.offset().top;
					$('html,body')
							.animate({scrollTop: targetOffset}, 1000);
					return false;
				}
			}
		});
		$('.legal_trigger').click(function () {
			var type = $(this).attr('rel');

			if (!$('#' + type).is(':visible')) {
				$('.legal_popover').hide();
				$('#' + type).fadeIn();
			}

		});

		$('.close_legal').click(function () {
			$('.legal_popover').fadeOut();
		});
	});
	$(document).scroll(function () {
		var y = $(this).scrollTop();
		if (y > 5200) {
			$('.legal').slideDown("fast");
			//            $('.legal').display("block");
		} else {
			$('.legal').slideUp("fast");
		}
	});
</script>
<?php 
 	echo $footer_scripts;
?>
</body>
</html>
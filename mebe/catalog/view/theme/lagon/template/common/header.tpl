<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->

<head>
    <meta charset="UTF-8" />    
    <title><?php echo $title; ?></title>    
    <base href="<?php echo $base; ?>" />    
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <?php } ?>
    
    <?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon" />
    <?php } ?>
    
    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php } ?>
    
    <?php foreach ($styles as $style) { ?>
    <link rel="<?php echo $style['rel']; ?>" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>
    
    <script src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
  <script src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
    <link rel="stylesheet" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
    <script src="catalog/view/javascript/common.js"></script>
     <!-- <script src="catalog/view/javascript/jquery/jquery.jcarousel.min.js"></script>-->
    <?php foreach ($scripts as $script) { ?>
    <script src="<?php echo $script; ?>"></script>
    <?php } ?>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <!-- ///////////// IF RTL ///////////////// -->
    
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/rtl/gallery.css" />
    
  <script src="catalog/view/javascript/jquery/todo.js"></script>
    
<script type="text/javascript">
todo.onload(function(){
    todo.gallery('gallery');
    //console.log({gallery});
});
</script>
   
    <?php 
    if ($direction == 'rtl') { ?>
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/rtl/stylesheet.css" />
    <!--<link href="catalog/view/theme/lagon/stylesheet/rtl/cloud-zoom.css" />-->
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/rtl/livesearch.css" />
    <link href='http://fonts.googleapis.com/css?family=Lobster&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <!--<script src="catalog/view/javascript/jquery/cloud-zoom.1.0.2.min-rtl.js"></script>-->
    <!-- 960 GRID SYSTEM 
    =================-->
    <noscript><link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/rtl/grid/mobile.css" /></noscript>
    <script>
    var ADAPT_CONFIG = {
      path: 'catalog/view/theme/lagon/stylesheet/rtl/grid/',
      dynamic: true,
      range: [
       // '0px    to 760px  = mobile.css',
        '0px    to 760px  = 1200.css',
		'760px  to 980px  = 1200.css',
		'980px  to 1280px = 1200.css',
		'1280px to        = 1200.css'
      ]
    };
    </script>
    
    <!-- ///////////// IF LTR ///////////////// -->
    <?php } else { ?>
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/stylesheet.css" />
    <!-- cloud zoom -->
   <link href="catalog/view/theme/lagon/stylesheet/cloud-zoom.css" />
    <script src="catalog/view/javascript/jquery/cloud-zoom.1.0.2.js"></script>

    <noscript><link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/grid/mobile.css" /></noscript>
    <script>
    var ADAPT_CONFIG = {
      path: 'catalog/view/theme/lagon/stylesheet/grid/',
      dynamic: true,
      range: [
       // '0px    to 760px  = mobile.css',
        '0px    to 760px  = 1200.css',
		'760px  to 980px  = 1200.css',
		'980px  to 1280px = 1200.css',
		'1280px to        = 1200.css'
      ]
    };
    </script>
    <?php } ?>
    
    <script src="catalog/view/javascript/jquery/adapt.min.js"></script>
    
   <!--
	<script src="catalog/view/javascript/jquery/jquery.carouFredSel-6.1.0-packed.js"></script>
    <script src="catalog/view/javascript/jquery/jquery.touchSwipe.min.js"></script>
    <script src="catalog/view/javascript/jquery/jquery.ba-throttle-debounce.min.js"></script>
    <script>
	$(window).load(function() {
	$('.foo3').carouFredSel({
		auto: false,
		width: '100%',
		height: 'auto',
		pagination: ".pager2",
		items: {
			height: 'auto',
			visible: {
				min: 1,
				max: 4
			}
		}
	});
	});
	</script>
    -->
   
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/flexslider.css" media="screen" />
    
	<script defer src="catalog/view/javascript/jquery/jquery.flexslider.min.js"></script>
	<script src='catalog/view/javascript/jquery/jquery.cookie.js'></script>
	
   <!--  
 <script src="catalog/view/javascript/jquery/jquery.easing.js"></script>
    <script src="catalog/view/javascript/jquery/jquery.mousewheel.js"></script>
	<script src="catalog/view/javascript/jquery/twitter/jquery.tweet.min.js"></script>
   <?php     
    $_SESSION['consumer_keyy']=$this->config->get('consumer_keyy');
    $_SESSION['consumer_secrett']=$this->config->get('consumer_secrett');
    $_SESSION['access_token']=$this->config->get('access_token');
    $_SESSION['token_secret']=$this->config->get('token_secret');
    ?>
    

    <script src="catalog/view/javascript/jquery/jquery.ui.totop.js"></script>
    <script>
	$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
	});
	</script>
    -->

	<!--<script src='catalog/view/javascript/jquery/jquery.hoverIntent.minified.js'></script>-->
    <script src='catalog/view/javascript/jquery/jquery.dcjqaccordion.2.7.min.js'></script>
    <script>
	$(document).ready(function($){
	$('#accordion-1').dcAccordion({
		eventType   : 'click',
		autoClose   : true,
		saveState   : true,
		disableLink : false,
		speed       : 'slow',
		showCount   : false,
		autoExpand  : false,
		cookie	  : 'dcjq-accordion-1',
		classExpand : 'dcjq-current-parent'
	});
	});
	</script>
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/livesearch.css" />
    <script src="catalog/view/javascript/jquery/livesearch.js"></script>

	<script>
    function SimpleSwap(el,which){
      el.src=el.getAttribute(which || "origsrc");
    }
    function SimpleSwapSetup(){
      /*var x = document.getElementsByTagName("img");
      for (var i=0;i<x.length;i++){
        var oversrc = x[i].getAttribute("oversrc");
        if (!oversrc) continue;
        x[i].oversrc_img = new Image();
        x[i].oversrc_img.src=oversrc;
        x[i].onmouseover = new Function("SimpleSwap(this,'oversrc');");
        x[i].onmouseout = new Function("SimpleSwap(this);");
        x[i].setAttribute("origsrc",x[i].src);
      }*/
    }
    var PreSimpleSwapOnload =(window.onload)? window.onload : function(){};
    window.onload = function(){PreSimpleSwapOnload(); SimpleSwapSetup();}
    </script>
    
    <!--[if IE 7]> 
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/ie7.css" />
    <![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" href="catalog/view/theme/lagon/stylesheet/ie6.css" />
    <script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('#logo img');
    </script>
    <![endif]-->
   
    <?php     echo $google_analytics; ?>
    <link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic&subset=latin,cyrillic' rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="top">
    
        <div class="container_12">
        
        	<div class="grid_4">
                <div id="welcome">
                    <?php if (!$logged) { ?>
                    <?php echo $text_welcome; ?>
                    <?php } else { ?>
                    <?php echo $text_logged; ?>
                    <?php } ?>
                </div>
            </div>
            <div class="grid_8">
              <div id="search">
                <div class="button-search"></div>
                <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
            </div>  
            	<?php echo $language; ?>
               
                <div class="links">
    
                    <a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a>
                    <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
                    <a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a>
                   
                </div>
               
            </div>
        </div>
    </div><!--/top-->
    
    <div class="container_12">
    
        <header>
          <?php if ($logo) { ?>
          <div class="grid_5">
          	<div id="logo">
          	<a href="<?php echo $home; ?>">
          	<img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
          	</div>
          	<div id=cmail>
 <a href="mailto:nfo@mebelrubleff.ru">info@mebelrubleff.ru</a><br>
 <a href="mailto:zakaz@mebelrubleff.ru">zakaz@mebelrubleff.ru</a></div>
          </div>
          <?php } ?>
          <div class="grid_7">
          	<?php echo $cart; ?>
            
            <?php if($this->config->get('lagon_hotline') != '') { ?>
          	<div class="hotLine">
            	<img src="catalog/view/theme/lagon/image/hotline.png" alt="Hot line">  
            	<span style="font-size: 14px;">+7-499-713-96-96<br> +7(916)093-58-68 МТС <br>+7(965)163-30-08 БИЛАЙН
                 </span><br/>
				<div class="worktime"><img src="catalog/view/theme/lagon/image/worktime.png" alt="Время работы">работаем с 9:00 до 21:00 ежедневно<br/>
               </div>
            </div>
            <?php } ?>
            
          </div> 
   		</header>
        
        <div class="clearfix"></div>
        
        <div class="menuWrap" >
            
            <?php if ($categories) { 
            	$page = $_REQUEST['route'];
            	$TPL['categories'] = array();
            	foreach ($categories as $i=>$category){
            	     if($i=='0') continue;
            	    
            	     $TPL['categories'][$category['category_id']] = $category;
            	}
            	//var_dump($page);
            	?>
            <div id='cssmenu'>

			<div id="menu">
            <ul> 
               <li class='<?=!$page?'active':""?>'><a href='#'><span>Главная</span></a></li> 
             
                <?php foreach ($categories as $i=>$category) { 
                    if($i==0) continue;
                     if($i==1) continue;
                      //if($i==2)continue;
                		/*//$class = !$page?'active':""              	
                       
                        echo '<li >';                            
                       	echo '<a href="'.$category['href'].'">'.$category['name'].'</a>'; 
                       	if (!empty($category['children'])) {
	                 		echo '<div><ul>';
	                        foreach ($category['children'] as $category_level2) {
		                         echo '<li><a href="'.$category_level2['href'].'">'.$category_level2['name'].'</a>';      
		                                   
		                         if (!empty($category_level2['children'])) {   
		                         	echo '<span class="arro">&rsaquo;</span>';                 
		                             echo '<ul>';                     
		                             foreach ($category_level2['children'] as $category_level3) {                         
		                             	echo '<li><a href="'.$category_level3['href'].'">'.$category_level3['name'].'</a></li>';                    
		            				 }                    
		                             echo '</ul>';
		                         }                
		                         echo '</li>';                         
		                     }  
	                         echo '</ul></div>'; 
                         }        
                      
                    /* 
                    //<img style="width:70px;height: 70px" src="'.$category['thumb'].'" border="0"><br/>
                    */

            	echo '<li><a href="'.$category['href'].'">'.$category['name'].'</a>'; 
                    if (!empty($category['children'])) : 
                     echo '<div>';
                        
                        if ($category['thumb']) :
                        echo '<div class="imageMenu"><img src="'.$category['thumb'].'"></div>';endif;  
                        
                         echo '<ul>'; 
                             foreach ($category['children'] as $category_level2) : echo 
                             '<li><a href="'.$category_level2['href'].'">'.$category_level2['name'].'</a>';      
                                       
                             if (!empty($category_level2['children'])) :    
                             echo '<span class="arro">&rsaquo;</span>';                 
                                 echo '<ul>';                     
                                 foreach ($category_level2['children'] as $category_level3) :                         
                                 echo '<li><a href="'.$category_level3['href'].'">'.$category_level3['name'].'</a></li>';                    
                                 endforeach;                     
                                 echo '</ul>';endif;                 
                             echo '</li>'; endforeach;             
                         echo '</ul>';
                     echo '</div>'; endif;       
                 echo '</li>'; 
                } 
             ?>
              <!--<li class='<?=($page=='catalog/special')?'active':""?> aksii' ><a href='/index.php?route=catalog/special'><span>Акции</span></a></li>-->
              <li class='<?=($page=='nformation/information')?'active':""?>'><a href='/index.php?route=information/information&information_id=6'><span>Доставка</span></a></li>
              <li class='<?=($page=='nformation/information')?'active':""?>'><a href='/index.php?route=information/information&information_id=5'><span>Оплата</span></a></li>
              <!--<li class='<?=($page=='information/contact')?'active':""?>'><a href='/index.php?route=information/contact'><span>Контакты</span></a></li> -->
            </ul>
            
            
            </ul>
            </div>
</div>
            <?php } ?>
            
            <!--***** MENU FOR MOBILE DEVICES RETURNS INTO SELECT ****-->
            <?php if ($categories) { ?>
            <div class="menuDevices" style="display:none">
              <div class="select_outer">
                  <select onchange="location=this.value">
                        <option>MENU</option>
                        <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></option>
                        <?php } ?>    
                  </select>
              </div><!--/select_outer-->
            </div>
            <?php } ?>
            
           
            
        </div><!--/menuWrap-->
        <div class="clearfix"></div>
        <div id="notification" class="grid_12"></div>
        <div class="clearfix"></div>

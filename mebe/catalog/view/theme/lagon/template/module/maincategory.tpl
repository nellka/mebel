<?php if(!empty($categories)){ ?>
        <div class="topcategories">
        <? $i=0;
         foreach ($categories as $categori) { 
           if($categori["category_id"]==69) continue;?>

    	<div class="mp_catblock<?=$i==0?'left':'right'?> " style="position: relative;">
    		<div class="mp_zagol">
    			<a href="<?=$categori["href"]?>"><?=$categori["name"]?></a></div>
    		<div class="wk-slideshow" id="slideshow-6-55126a5d89b74" style="visibility: visible; position: relative; width: 390px;">
    			<div class="slides-container">
    				<ul class="slides" style="position: relative; overflow: hidden; height: 300px; width: 100%;">
    					<li>
    						<a href="<?=$categori["href"]?>">
    						<img alt="spslide1hitek" src="<?=$categori["image"]?>" /> </a>
    					</li>
    				</ul>
    				<div class="caption" style="display: block;">
    					<?=$categori["name"]?></div>
    			</div>
    		</div>
    	</div>		
    	
    	
          <?php 
          $i++;
          if($i>1)$i=0;
          } ?>
          </div>
<?php } ?>
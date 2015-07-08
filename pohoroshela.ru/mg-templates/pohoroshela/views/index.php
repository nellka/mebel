<?php mgSEO($data); ?>

<div class="js_index"></div>  
  
<div class="cat-desc" style="text-align:left">
    <?php echo $data['cat_desc'] ?>
</div>
<img border="0" src="mg-templates/pohoroshela/images/logo3.jpg" style="">   
 <!-- <div class="top3">
  <div class="tovar-catalog">
      <div class=main>
    	  <div class="title">Кокетливая юбка по косой с молнией </div>
    	  	<img border="0" src="mg-templates/pohoroshela/images/ubka-1.jpg" style=""> 
    		Изюминка этой юбки в складках на поясе. Она излучает спокойную красоту. 
    	  </div>
    	 <div class="details"><div class="title">Наши ткани</div>
    		 <div class=tkani>
    		  <img border="0" src="mg-templates/pohoroshela/images/tkani2.jpg"> 
    		Стоимость ткани включена 
    		</div>
    		<div class="sub-details">
    			<div class="sub"><img src="http://pohoroshela.ru/uploads/korobka.jpg">Упако- вочная коробка</div>
    			<div class="sub"><img src="http://pohoroshela.ru/uploads/pugovici.jpg">Пуговицы</div>
    			<div class="sub"><img src="http://pohoroshela.ru/uploads/tkani.jpg">Ткань</div>
    			
    			<div class="sub"><img src="http://pohoroshela.ru/uploads/molnii.jpg">Молнии</div>
    			<div class="sub"><img height="60" src="http://pohoroshela.ru/uploads/vikroyki.jpg" style="margin: 0 9px">Выкройки деталей</div>
    		</div>              
    	</div>
  </div>
  <div class="tovar-catalog">
      <div class=main>
    	  <div class="title">Кокетливая юбка по косой с молнией </div>
    	  	<img border="0" src="mg-templates/pohoroshela/images/ubka-1.jpg" style=""> 
    		Изюминка этой юбки в складках на поясе. Она излучает спокойную красоту. 
    	  </div>
    	 <div class="details"><div class="title">Наши ткани</div>
    		 <div class=tkani>
    		  <img border="0" src="mg-templates/pohoroshela/images/tkani2.jpg"> 
    		Стоимость ткани включена 
    		</div>
    		<div class="sub-details">
    			<div class="sub"><img src="http://pohoroshela.ru/uploads/korobka.jpg">Упако- вочная коробка</div>
    			<div class="sub" style="line-height: 50px;"><img src="http://pohoroshela.ru/uploads/pugovici.jpg">Пуговицы</div>
    			<div class="sub" style="line-height: 30px;"><img src="http://pohoroshela.ru/uploads/tkani.jpg">Ткань</div>
    			
    			<div class="sub" style="line-height: 40px;"><img src="http://pohoroshela.ru/uploads/molnii.jpg">Молнии</div>
    			<div class="sub" style="line-height: 20px;"><img height="60" src="http://pohoroshela.ru/uploads/vikroyki.jpg" style="margin: 0 9px">Выкройки деталей</div>
    		</div>              
    	</div>
   </div>-->
<?php if(!empty($data['newProducts'])): ?>

<div class="m-p-products latest  js_indexProductSlide">
    <div id='sep'>  
        <a class="js_indexProductSlideTitle" href="<?php echo SITE; ?>/group?type=latest">Новые поступления</a>
     </div>
     <div class="top3">
      <?php foreach($data['newProducts'] as $item){
           $description = explode('.',strip_tags($item['description']));
          ?>
        <div class="tovar-catalog">
      <div class=main>
    	  <div class="title">
    	   <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>"><?php echo $item["title"] ?></a>
         </div>
    	  	<div class="product-image">
              <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">
                <?php echo mgImageProduct($item); ?>
              </a>          
            </div>
    		<?=$description?($description[0].'.'):'';?>
    	  </div>
    	 <div class="details"><div class="title">Наши ткани</div>
    		 <div class=tkani>
    		  <img border="0" src="mg-templates/pohoroshela/images/tkani2.jpg"> 
    		Стоимость ткани включена 
    		</div>
    		 <div class="sub-details">
    			<div class="sub"><img src="http://pohoroshela.ru/uploads/korobka.jpg">Упако- вочная коробка</div>
    			<div class="sub" style="line-height: 50px;"><img src="http://pohoroshela.ru/uploads/pugovici.jpg">Пуговицы</div>
    			<div class="sub" style="line-height: 30px;"><img src="http://pohoroshela.ru/uploads/tkani.jpg">Ткань</div>
    			
    			<div class="sub" style="line-height: 40px;"><img src="http://pohoroshela.ru/uploads/molnii.jpg">Молнии</div>
    			<div class="sub" style="line-height: 20px;"><img height="60" src="http://pohoroshela.ru/uploads/vikroyki.jpg" style="margin: 0 9px">Выкройки деталей</div>  
    		 </div> 
    		</div>           
    	</div>
      <?}?>
      </div>
<?/*
     <!--
      <div class="m-p-products-slider catalog">
      <div class="">
            <?php foreach($data['newProducts'] as $item): ?>
           <div class="product-wrapper catalog">
            <div class="product-stickers">
                <?php
                echo $item['new']?'<span class="sticker-new"></span>':'';
                echo $item['recommend']?'<span class="sticker-recommend"></span>':'';
                ?>
            </div>
           <div class="product-right">
            <div class="product-image">
              <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">
                <?php echo mgImageProduct($item); ?>
              </a>          
            </div>
            <div class="product-footer">
              <div class="product-price">
                <span class="product-old-price" <?php echo (!$item['old_price'])?'style="display:none"':'style="display:block"' ?>>
                  <?php echo $item["old_price"] ?> <?php echo $data['currency']; ?>
                </span>
                <span class="product-default-price">
                  <?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?>
                </span>
              </div>
    
              <div class="product-buttons">               
                <?php echo $item['buyButton']; ?>
                 <?php echo $item['actionCompare'] ?>
    
              </div>
            </div>
        </div>
         <div class="product-left">
             <div class="product-name">
              <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">Комплект для пошива своими руками <br><?php echo $item["title"] ?></a>
            </div>
            <div class="info">
             <div class="in-complect"><b> В комплекте:</b></div>
             <div style="background: #fff;height:140px;padding: 10px">
                 <div class="info-img">
                  <div style="width: 175px;" class="sub"><div class="im"><img src="<?=SITE?>/uploads/korobka.jpg"/></div><div class="txt">Упаковочная коробка</div></div>
                  <div style="width: 130px;"  class="sub"><div class="im"><img src="<?=SITE?>/uploads/tkani.jpg"/></div><div class="txt">Ткань</div></div>
                  <div style="width: 120px;"  class="sub"><div class="im"><img src="<?=SITE?>/uploads/vikroyki.jpg"/></div><div class="txt">Выкройки деталей</div></div>
                   <div class="clear"></div>
                  <div style="width: 170px; clear: both; float: left;" class="sub"><div class="im" style="width: 80px;" ><img src="<?=SITE?>/uploads/pugovici.jpg" /></div><div class="txt">Пуговицы</div></div>
                  <div style=" width: 210px;"  class="sub"><div class="im"><img src="<?=SITE?>/uploads/molnii.jpg"/></div><div class="txt">Молнии</div></div>
                </div>
                </div>
              </div>
         </div>
       

            <div class="js_clear"></div>

          </div>
        <?php endforeach; ?>
      </div>
    </div>-->*/?>
      <div class="js_clear"></div>
  </div>
<?php endif; ?> 

<?php if(!empty($data['recommendProducts'])): ?>
<div class="m-p-products recommend js_indexProductSlide">
    <div id='sep'><a class="js_indexProductSlideTitle" href="<?php echo SITE; ?>/group?type=recommend">Самые продаваемые</a> </div>
    
    <div class="top3">
      <?php foreach($data['recommendProducts'] as $item){
          $description = explode('.',strip_tags($item['description']));
          ?>
        <div class="tovar-catalog">
      <div class=main>
    	  <div class="title">
    	   <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>"><?php echo $item["title"] ?></a>
         </div>
    	  	<div class="product-image">
              <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">
                <?php echo mgImageProduct($item); ?>
              </a>          
            </div>
    		<?=$description?($description[0].'.'):'';?>
    	  </div>
    	 <div class="details"><div class="title">Наши ткани</div>
    		 <div class=tkani>
    		  <img border="0" src="mg-templates/pohoroshela/images/tkani2.jpg"> 
    		Стоимость ткани включена 
    		</div>
    		 <div class="sub-details">
    			<div class="sub"><img src="http://pohoroshela.ru/uploads/korobka.jpg">Упако- вочная коробка</div>
    			<div class="sub" style="line-height: 50px;"><img src="http://pohoroshela.ru/uploads/pugovici.jpg">Пуговицы</div>
    			<div class="sub" style="line-height: 30px;"><img src="http://pohoroshela.ru/uploads/tkani.jpg">Ткань</div>
    			
    			<div class="sub" style="line-height: 40px;"><img src="http://pohoroshela.ru/uploads/molnii.jpg">Молнии</div>
    			<div class="sub" style="line-height: 20px;"><img height="60" src="http://pohoroshela.ru/uploads/vikroyki.jpg" style="margin: 0 9px">Выкройки деталей</div>  
    		 </div> 
    		</div>           
    	</div>
      <?}?>
      </div>
    
    <? /*
    <!--<div class="m-p-products-slider catalog">
      <div class="">
          <?php foreach($data['recommendProducts'] as $item): ?>
         <div class="product-wrapper catalog">
            <div class="product-stickers">
                <?php
                echo $item['new']?'<span class="sticker-new"></span>':'';
                echo $item['recommend']?'<span class="sticker-recommend"></span>':'';
                ?>
            </div>
           <div class="product-right">
            <div class="product-image">
              <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">
                <?php echo mgImageProduct($item); ?>
              </a>          
            </div>
            <div class="product-footer">
              <div class="product-price">
                <span class="product-old-price" <?php echo (!$item['old_price'])?'style="display:none"':'style="display:block"' ?>>
                  <?php echo $item["old_price"] ?> <?php echo $data['currency']; ?>
                </span>
                <span class="product-default-price">
                  <?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?>
                </span>
              </div>
    
              <div class="product-buttons">
                <?php echo $item['buyButton']; ?>
                 <?php echo $item['actionCompare'] ?>
    
              </div>
            </div>
        </div>
         <div class="product-left">
             <div class="product-name">
              <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">Комплект для пошива своими руками <br><?php echo $item["title"] ?></a>
            </div>
            <div class="info">
             <div class="in-complect"><b> В комплекте:</b></div>
             <div style="background: #fff;height:140px;padding: 10px">
                 <div class="info-img">
                  <div style="width: 175px;" class="sub"><div class="im"><img src="<?=SITE?>/uploads/korobka.jpg"/></div><div class="txt">Упаковочная коробка</div></div>
                  <div style="width: 130px;"  class="sub"><div class="im"><img src="<?=SITE?>/uploads/tkani.jpg"/></div><div class="txt">Ткань</div></div>
                  <div style="width: 120px;"  class="sub"><div class="im"><img src="<?=SITE?>/uploads/vikroyki.jpg"/></div><div class="txt">Выкройки деталей</div></div>
                   <div class="clear"></div>
                  <div style="width: 170px; clear: both; float: left;" class="sub"><div class="im" style="width: 80px;" ><img src="<?=SITE?>/uploads/pugovici.jpg" /></div><div class="txt">Пуговицы</div></div>
                  <div style=" width: 210px;"  class="sub"><div class="im"><img src="<?=SITE?>/uploads/molnii.jpg"/></div><div class="txt">Молнии</div></div>
                </div>
                </div>
              </div>
         </div>
       

            <div class="js_clear"></div>

          </div>
        <?php endforeach; ?> 
      </div>
    </div>-->*/?>
    <div class="js_clear"></div>
  </div>
  <br>
<?php endif; ?> 

<?php if(!empty($data['saleProducts'])): ?>
<div class="m-p-products sale js_indexProductSlide">
    <a class="js_indexProductSlideTitle" href="<?php echo SITE; ?>/group?type=sale">Распродажа</a>
    <div class="m-p-products-slider">
    <div class="<?php echo count($data['saleProducts'])>3?"m-p-products-slider-start":"" ?>">
        <?php foreach($data['saleProducts'] as $item): ?>
        <div class="product-wrapper">
          <div class="product-stickers">
            <?php
                echo $item['new']?'<span class="sticker-new"></span>':'';
                echo $item['recommend']?'<span class="sticker-recommend"></span>':'';
            ?>
          </div>
          <div class="product-image">
            <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo htmlspecialchars($item["product_url"]) ?>">
               <?php echo mgImageProduct($item); ?>
            </a>
          </div>

          <div class="product-name">
            <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo htmlspecialchars($item["product_url"]) ?>"><?php echo $item["title"] ?></a>
          </div>
          <div class="product-footer">
            <span class="product-price">
              <span class="product-old-price"><?php echo $item["old_price"] ?> <?php echo $data['currency']; ?></span>
              <?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?>
            </span>
            <div class="product-buttons">
              <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
              <?php echo $item[$data['actionButton']] ?>
              <?php echo $item['actionCompare'] ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="js_clear"></div>
  </div>
<?php endif; ?> 

<?php mgAddMeta('<script type="text/javascript" src="'.SCRIPT.'jquery.bxslider.min.js"></script>'); ?>
<script>
    $(document).ready(function(){
        $('.slider-home ul').bxSlider({
            mode: 'fade',
  			auto: true
        });
        
        $('.m-p-products-slider-start').bxSlider({
            minSlides: 3,
            maxSlides: 3,
            slideWidth: 270,
            slideMargin: 15,
            moveSlides: 1,
            pager: false,
            auto: false,
            useCSS: false,
            touchEnabled: true,
            easing: 'linear',
            speed: 200
        });
    }); // end ready
</script>

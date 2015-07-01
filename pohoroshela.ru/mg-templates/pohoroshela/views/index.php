<?php mgSEO($data); ?>

<div class="js_index"></div>

<div class="cat-desc">
    <?php echo $data['cat_desc'] ?>
</div>

<?php if(!empty($data['newProducts'])): ?>

<div class="m-p-products latest  js_indexProductSlide">
    <div id='sep'>  <a class="js_indexProductSlideTitle" href="<?php echo SITE; ?>/group?type=latest">Новые поступления</a>
     </div>
      <div class="m-p-products-slider">
      <div class="<?php echo count($data['newProducts'])>3?"m-p-products-slider-start":"" ?>">
            <?php foreach($data['newProducts'] as $item): ?>
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
              <span class="product-price"><?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?></span>
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

<?php if(!empty($data['recommendProducts'])): ?>
<div class="m-p-products recommend js_indexProductSlide">
    <div id='sep'><a class="js_indexProductSlideTitle" href="<?php echo SITE; ?>/group?type=recommend">Самые продаваемые</a> </div>
    <div class="m-p-products-slider">
      <div class="<?php echo count($data['recommendProducts'])>3?"m-p-products-slider-start":"" ?>">
          <?php foreach($data['recommendProducts'] as $item): ?>
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
              <span class="product-price"><?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?></span>
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

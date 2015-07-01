<?php
mgSEO($data);

?>
<div class="product-details-block" itemscope itemtype="http://schema.org/Product">
  
  <?php if(class_exists('BreadCrumbs')): ?>
    [brcr]
  <?php endif; ?>
    
  <?php mgGalleryProduct($data); ?>
    
    <h1 class="product-title" itemprop="name"><?php echo $data['title'] ?></h1>
  <div class="product-status">
    <div class="buy-block">
      <div class="buy-block-inner">
        <ul class="product-status-list">
          <!--если не установлен параметр - старая цена, то не выводим его-->
            <li>Остаток: <span class="label-black count"><?php echo $data['count'] ?></span> <span>шт.</span> <?php echo $data['remInfo'] ?></li>
            <li <?php echo (!$data['weight'])?'style="display:none"':'style="display:block"' ?>>Вес: <span class="label-black weight"><?php echo $data['weight'] ?></span> <span>кг.</span> </li>
        </ul>
          

        <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
        <?php echo $data['propertyForm'] ?>
        <div class="product-price mobile">
          <ul class="product-status-list">
            <li>
              <div class="old-price" <?php echo (!$data['old_price'])?'style="display:none"':'style="display:block"' ?>>
                <span class="old"><?php echo MG::numberFormat($data['old_price'], '1 234,56')." ".$data['currency']; ?></span>
              </div>
            </li>
            <li>
              <div class="normal-price">
                <span class="price"><?php echo $data['price'] ?> <?php echo $data['currency']; ?></span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div><!-- End product-status-->

  <div class="clear"></div>

  <div class="product-details-wrapper">
    <ul class="product-tabs">
      <li><a href="#tab1">Описание</a></li>
       <!-- <li><a href="#tab2">Отзывы (<span class="js_commentsCount"></span>)</a></li>-->
    </ul>
    <div class="product-tabs-container">
      <div id="tab1" itemprop="description"><?php echo $data['description'] ?></div>
      <div id="tab2" itemscope itemtype="http://schema.org/Review">
          [comments]
      </div>
    </div>
  </div>

  <?php
  /* Следующая строка для вывода свойств в таблицу характеристик */
  /* $data['stringsProperties'] */
  ?>  
    [recently-viewed count=5 random=1]

</div><!-- End product-details-block-->




<?php
mgSEO($data);

?>

<h1 class="new-products-title <?php echo $data['class_title'] ?>" ><?php echo $data['titeCategory'] ?></h1>
<div class="products-wrapper  catalog">
  <?php
  if (!empty($data['items']))
    foreach ($data['items'] as $item):
      ?>

        <div class="product-wrapper">
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
                <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
                <?php echo $item['buyButton']; ?>
    
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
              <? 

               if( file_exists(URL::getDocumentRoot().'/pdf/'.$item['id'].".zip")){?>
        <div class="product-name"><br><br><a class="product-name" href = "<?php echo SITE.'/pdf/'.$item['id'].".zip" ?>">Скачать выкройку</a></div>
        <? }?>
         </div>
       

            <div class="js_clear"></div>
        </div>

    <?php endforeach; ?>

  <div class="clear"></div>
  <?php echo $data['pager']; ?>
  <!-- / Верстка каталога -->
</div>

<!-- Все группы -->

<?php if (!empty($data['newProducts'])): ?>

  <div class="m-p-products">
    <h2 class="m-p-new-products-title"><a href="<?php echo SITE; ?>/group?type=latest" class="text-decoration-none">Новые поступления</a></h2>
    <div class="m-p-products-slider">
      <div class="<?php echo count($data['newProducts']) > 3 ? "m-p-products-slider-start" : "" ?>">
        <?php foreach ($data['newProducts'] as $item): ?>
            <div class="product-wrapper">
                <div class="product-stickers">
                    <?php
                    echo $item['recommend']?'<span class="sticker-recommend"></span>':'';
                    echo $item['new']?'<span class="sticker-new"></span>':'';
                    ?>
                </div>
                <div class="product-image">
                    <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">
                        <?php echo mgImageProduct($item); ?>
                    </a>
                    <div class="product-code">Код: <?php echo $item["code"] ?></div>
                    <?php if(class_exists('Rating')): ?>
                        [rating id = "<?php echo $item['id'] ?>"]
                    <?php endif; ?>
                </div>
                <div class="product-name">
                    <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>"><?php echo $item["title"] ?></a>
                </div>
                <div class="product-description">
                    <?php echo MG::textMore($item["description"], 240) ?>
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
                        <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
                        <?php echo $item['buyButton']; ?>

                    </div>
                    <? 

               if( file_exists(URL::getDocumentRoot().'/pdf/'.$item['id'].".zip")){?>
        <div class="product-name"><br><br><a class="product-name" href = "<?php echo SITE.'/pdf/'.$item['id'].".zip" ?>">Скачать выкройку</a></div>
        <? }?>
                </div>
                <div class="clear"></div>
            </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
<?php endif; ?>

<?php if (!empty($data['recommendProducts'])): ?>
  <div class="m-p-recommended-products">
    <h2 class="m-p-recommended-products-title"><a href="<?php echo SITE; ?>/group?type=recommend" class="text-decoration-none">Рекомендуемые товары</a></h2>
    <div class="m-p-products-slider">
      <div class="<?php echo count($data['recommendProducts']) > 3 ? "m-p-products-slider-start" : "" ?>">
        <?php foreach ($data['recommendProducts'] as $item): ?>

            <div class="product-wrapper">
                <div class="product-stickers">
                    <?php
                    echo $item['recommend']?'<span class="sticker-recommend"></span>':'';
                    echo $item['new']?'<span class="sticker-new"></span>':'';
                    ?>
                </div>
                <div class="product-image">
                    <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">
                        <?php echo mgImageProduct($item); ?>
                    </a>
                    <div class="product-code">Код: <?php echo $item["code"] ?></div>
                    <?php if(class_exists('Rating')): ?>
                        [rating id = "<?php echo $item['id'] ?>"]
                    <?php endif; ?>
                </div>
                <div class="product-name">
                    <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>"><?php echo $item["title"] ?></a>
                </div>
                <div class="product-description">
                    <?php echo MG::textMore($item["description"], 240) ?>
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
                        <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
                        <?php echo $item['buyButton']; ?>

                    </div>
                </div>
                <div class="clear"></div>
            </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
<?php endif; ?>

<?php if (!empty($data['saleProducts'])): ?>
  <div class="m-p-products">
    <h2 class="m-p-sale-products-title"><a href="<?php echo SITE; ?>/group?type=sale" class="text-decoration-none">Распродажа</a></h2>
    <div class="m-p-products-slider">
      <div class="<?php echo count($data['saleProducts']) > 3 ? "m-p-products-slider-start" : "" ?>">
        <?php foreach ($data['saleProducts'] as $item): ?>
            <div class="product-wrapper">
                <div class="product-stickers">
                    <?php
                    echo $item['recommend']?'<span class="sticker-recommend">Хит!</span>':'';
                    echo $item['new']?'<span class="sticker-new">Новинка</span>':'';
                    ?>
                </div>
                <div class="product-image">
                    <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>">
                        <?php echo mgImageProduct($item); ?>
                    </a>
                    <div class="product-code">Код: <?php echo $item["code"] ?></div>
                    <?php if(class_exists('Rating')): ?>
                        [rating id = "<?php echo $item['id'] ?>"]
                    <?php endif; ?>
                </div>
                <div class="product-name">
                    <a href="<?php echo SITE ?>/<?php echo isset($item["category_url"])?$item["category_url"]:'catalog' ?>/<?php echo $item["product_url"] ?>"><?php echo $item["title"] ?></a>
                </div>
                <div class="product-description">
                    <?php echo MG::textMore($item["description"], 240) ?>
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
                        <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
                        <?php echo $item['buyButton']; ?>

                    </div>
                </div>
                <div class="clear"></div>
            </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
<?php endif; ?>

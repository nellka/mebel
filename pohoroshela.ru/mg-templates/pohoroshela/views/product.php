<?php
mgSEO($data);

?>
<div class="product-details-block" itemscope itemtype="http://schema.org/Product">
  
  <?php if(class_exists('BreadCrumbs')): ?>
    [brcr]
  <?php endif; ?>

<div style="width:50%;float:left">    
  <?php mgGalleryProduct($data); ?>

</div>
 
    <h1 class="product-title" itemprop="name"><?php echo $data['title'] ?></h1>
     </div>
      <div id="tab1" itemprop="description" style="padding: 0 20px 0 0;text-align: justify;"><?php echo $data['description']?></div>
       <div class="clear"></div>
       <div class="product-status-desc">Если вы хотите <font color="Red">легко</font> и <font color="Red">без проблем</font> сшить эту модель, <br>купите <font color="Red" class="italic">готовый комплект</font> для ее пошива.<br>
       В набор входит:        
       <div class="tk">* Ткань на выбор (<font class="italic">3 метра стандартной ширины, цена комплекта зависит от ткани</font>):</div>
       </div>
      
  <div class="product-status">
    <div class="buy-block">
      <div class="buy-block-inner">
        <ul class="product-status-list">
          <!--если не установлен параметр - старая цена, то не выводим его-->
           <!-- <li>Остаток: <span class="label-black count"><?php echo $data['count'] ?></span> <span>шт.</span> <?php echo $data['remInfo'] ?></li>-->
            <li <?php echo (!$data['weight'])?'style="display:none"':'style="display:block"' ?>>Вес: <span class="label-black weight"><?php echo $data['weight'] ?></span> <span>кг.</span> </li>
        </ul>
          

        <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
        <?php echo $data['propertyForm'] ?>
          <div class="product-status">
       
   <div class="status-desc">
   <div class="sub-l">
<ul><li>* инструкция по выкройке и пошиву этой модели
<li>* склееная выкройка с размерами
<li>* пуговицы в цвет ткани
<li>* нитки в цвет ткани
<li>* молнии в цвет ткани
<li>* подарочная упаковка
</ul>
<img src="http://pohoroshela.ru/uploads/korbig.jpg" width="300">

<div class="product-status-desc">Так же такой набор - отличный <font color="Red">Подарок!</font></div>
</div>
<div class="sub-r">
<img src="http://pohoroshela.ru/uploads/instruc2.jpg" width="300">Пример инструкции из набора</div>
</div>
</div>
 <div class="clear"></div>

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
<div class="product-status-desc" style="padding: 20px 0 0;">
А если вы <font color="Red">уверены в своих силах</font> - можете просто <font color="Red">скачать выкройку!</font><br><br>
          <?      
     if( file_exists(URL::getDocumentRoot().'/pdf/'.$data['id'].".zip")){?>
        <a class = "vikroika_url_pr" href = "<?php echo SITE.'/pdf/'.$data['id'].".zip" ?>">Скачать выкройку</a>
        <? }?>
</div>
 <div class="clear"></div>
  <?php /*
  ?>  
   <div class="product-details-wrapper">    
    <div class="product-tabs-container">
      <div id="tab2" itemscope itemtype="http://schema.org/Review">
          [comments]
      </div>
    </div>
  </div>
    [recently-viewed count=5 random=1]

</div><!-- End product-details-block-->

*/?>


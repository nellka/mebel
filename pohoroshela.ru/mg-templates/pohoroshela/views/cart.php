<?php mgSEO($data); ?>

<?php mgTitle('Корзина'); ?>

<h1 class="new-products-title">Корзина</h1>

<div class="product-cart" style="display:<?php echo!$data['isEmpty']?'none':'block'; ?>">
  <div class="cart-wrapper">
    <form method="post" action="<?php echo SITE ?>/cart">
      <table class="cart-table">
          <tr>
              <th>Товар</th>
              <th>Артикул</th>
              <th>Кол-во</th>
              <th>Цена</th>
              <th>Cумма</th>
          </tr>
        <?php $i = 1;
        foreach($data['productPositions'] as $product): ?>
          <tr>
            <td class="img-cell">
                <a class="deleteItemFromCart delete-btn" href="<?php echo SITE ?>/cart" data-delete-item-id="<?php echo $product['id'] ?>" data-property="<?php echo $product['property'] ?>" data-variant="<?php echo $product['variantId'] ?>" title="Удалить товар">X</a>
                
                <a href="<?php echo $product["link"] ?>" target="_blank" class="cart-img">
                    <img src="<?php echo $product["image_url"]?SITE.'/uploads/thumbs/30_'.$product["image_url"]:SITE."/uploads/no-img.jpg" ?>" alt="">
                </a>
                
                <a class="js_titleProductCart" href="<?php echo SITE ?>/<?php echo isset($product["category_url"])?$product["category_url"]:'catalog' ?>/<?php echo $product["product_url"] ?>" target="_blank">
                    <?php echo $product['title'] ?>
                </a>
                <br/><?php echo $product['property_html'] ?>
            </td>
            
            <td class="code-cell">
              <span class="code"><?php echo $product['code'] ?></span>
            </td>
 
            <td class="count-cell">
              <input type="text" class="amount_input zeroToo"  name="item_<?php echo $product['id'] ?>[]" value = "<?php echo $product['countInCart'] ?>"/>
              <input type="hidden"  name="property_<?php echo $product['id'] ?>[]" value = "<?php echo $product['property'] ?>"/>
              <button type="submit" name="refresh" class="refresh" title="Пересчитать" value="Пересчитать"></button>
            </td>

            <td>
                <?php echo MG::numberFormat($product['price']) ?> <?php echo $data['currency']; ?>
            </td>

            <td class="price-cell">
              <?php echo MG::numberFormat($product['countInCart'] * $product['price']) ?>  <?php echo $data['currency']; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </form>
    <div class="total-sum">
      <span>Сумма:</span>
      <strong> <?php echo priceFormat($data['totalSumm']) ?> <?php echo $data['currency']; ?></strong>
    </div>
  </div>


  <?php if(class_exists('PromoCode')): ?>
    [promo-code] 
  <?php endif; ?>

  <form action="<?php echo SITE ?>/order" method="post" class="checkout-form">
    <button type="submit" class="checkout-btn" name="order" value="Оформить заказ">Оформить заказ</button>
  </form>
  
  <div class="clear"></div>
 
</div>

<div class="empty-cart-block alert-info" style="display:<?php echo!$data['isEmpty']?'block':'none'; ?>">
  Ваша корзина пуста
</div>

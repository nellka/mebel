  <h1 style="margin-top: 5px;"><?php echo $heading_title; ?></h1>
  <div class="product-grid">
      <?php foreach ($products as $product) { ?>
      <div>
      <!--for swap image-->
        <?php if ($product['thumb_swap']) { ?>
          <div class="image">
              <a href="<?php echo $product['href']; ?>">
                 <img oversrc="<?php echo $product['thumb_swap']; ?>" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" style="border:none">
              </a>
          </div>

          <?php } else {?>

          <div class="image">
              <a href="<?php echo $product['href']; ?>">
                  <img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" style="border:none">
              </a>
          </div>

          <?php } ?>
        <!--/ swap img-->
      <div class="k_shortdesc">
           <div class="k_gabarity">
            Длина: <?php echo round($product['length'],0); ?> мм
            <br>
            Глубина: <?php echo round($product['width'],0); ?> мм
            <br>
            Высота: <?php echo round($product['height'],0); ?> мм
            <br>
          </div>
       </div>
       <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
          <div class="description"><?php echo $product['description']; ?></div>
          <?php if ($product['price']) { ?>
          <div class="price">
            <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
            <?php } else { ?>
            <span class="saleIcon">%</span>
            <span class="price-new"><?php echo $product['special']; ?></span>
            <span class="price-old"><br><?php echo $product['price']; ?></span>
            <?php } ?>
            <?php if ($product['tax']) { ?>
            <br />
            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
            <?php } ?>
          </div>
          <?php } /*?>
          
          <div class="rating">
          	<img src="catalog/view/theme/lagon/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" />
          </div>*/?>
          
          <!-- wish  //  compare  //  cart
            =============-->
            <div class="hover-options">
            <span class="cartt"><a class="cartImg" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');"></a></span>
            <span class="wishh"><a class="wish" onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $button_wishlist; ?>"></a></span>
            <span class="comparee"><a class="compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $button_compare; ?>"></a></span>
        </div>
        
    </div>
    <?php /*  <div class="normalView">
        
        <!-- image //
        =============-->
        <!--for swap image-->
        <?php if ($product['thumb_swap']) { ?>
          <div class="image">
              <a href="<?php echo $product['href']; ?>">
                 <img oversrc="<?php echo $product['thumb_swap']; ?>" src="<?php echo $product['thumb']; ?>" 
                 title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" style="border:none"/>
              </a>
          </div>

          <?php } else {?>

          <div class="image">
              <a href="<?php echo $product['href']; ?>">
                  <img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" 
                  alt="<?php echo $product['name']; ?>" style="border:none"/>
              </a>
          </div>

          <?php } ?>
        <!--/ swap img -->
        
        <!-- name //
        =============-->
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        
        <!-- price //
        =============-->
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="saleIcon">%</span>
          <span class="price-new"><?php echo $product['special']; ?></span>
          <span class="price-old"><br><?php echo $product['price']; ?></span> 
          <?php } ?>
        </div>
        <?php } ?>
        
        <!-- rate //
        =============-->
        <div class="rating">
        <img src="catalog/view/theme/lagon/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" />
        </div>
        
        <!-- wish  //  compare  //  cart
        =============-->
        <div class="hover-options">
            <a class="cartImg" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');"></a>
            <a class="wish" onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $button_wishlist; ?>"></a>
            <a class="compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $button_compare; ?>"></a>
        </div>

      </div>*/?>
      <?php } ?>
  </div>

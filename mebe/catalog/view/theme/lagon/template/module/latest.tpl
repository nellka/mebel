<div class="box">
  <div class="box-heading"><span><?php echo $heading_title; ?></span></div>
    <div class="box-content" id="carousel_f">
    <ul class="jcarousel-skin-opencart box-product">
      <?php foreach ($products as $product) { ?>
      <li>
	  
    <div class="box-product">
    
      <div class="normalView">
        
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
          <span class="price-old"><?php echo $product['price']; ?></span> 
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
 </div>
      </li>
      <?php } ?>
    </ul>
	
   
  </div>
</div>
<script type="text/javascript"><!--
$('#carousel_f ul').jcarousel({
	vertical: false,
	visible: 4,
	
	wrap: 'circular',
	scroll: 1
});
//--></script>

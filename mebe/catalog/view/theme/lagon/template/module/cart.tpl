<div id="cart">
  <div class="heading">
    <h4><?php echo $heading_title; ?></h4>
    <a><span id="cart-total"><?php echo $text_items; ?></span></a></div>
  <div class="content">
  
  <span class="sm"></span>
  
    <?php if ($products || $vouchers) { ?>
    <div class="mini-cart-info">
 
        <?php foreach ($products as $product) { ?>
      	<div class="one-product"> 
        
        
          <div class="image">
          	<?php if ($product['thumb']) { ?>
                <a href="<?php echo $product['href']; ?>">
                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
                </a>
            <?php } ?>
          </div>
            

          <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
            </div>
          </div>
            
            
            
          
          <div class="total"><?php echo $product['total']; ?>&nbsp;&nbsp; x &nbsp;<?php echo $product['quantity']; ?></div>
     
          
          <div class="remove">
          <img src="catalog/view/theme/lagon/image/close.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $product['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $product['key']; ?>' + ' #cart > *');" />
          </div>
          
          
          </div><!--/one-product-->
        <?php } ?>
        
        
        
        
        <?php foreach ($vouchers as $voucher) { ?>
          <div class="one-product"> 
          <div class="image"></div>
          <div class="name"><?php echo $voucher['description']; ?></div>
          <div class="total"><?php echo $voucher['amount']; ?> x&nbsp;1</div>
          <div class="remove">
          <img src="catalog/view/theme/lagon/image/remove.png" width="15" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $voucher['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $voucher['key']; ?>' + ' #cart > *');" />
          </div><!--/one-product-->
          </div>
          
          
        <?php } ?>

    </div>
    
    
    
    
    <div class="mini-cart-total">
      <table>
        <?php foreach ($totals as $total) { ?>
        <tr>
          <td class="right"><b><?php echo $total['title']; ?>:</b></td>
          <td class="right"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </table>
      
      
      <div class="checkout">
        <a class="ca" href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a>
        <a class="ch" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
      </div>
    </div>
    

    
    <?php } else { ?>
    <div class="empty"><?php echo $text_empty; ?></div>
    <?php } ?>
  </div>
</div>
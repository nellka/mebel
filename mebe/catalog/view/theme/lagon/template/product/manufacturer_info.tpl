<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($products) { ?>
  <!--product filter
  ==============================================================-->
  <div class="product-filter">
    
    <div class="limit"><b><?php echo $text_limit; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    
    <div class="sort"><b><?php echo $text_sort; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    
    <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
	
    
    <div class="display"><b><?php echo $text_display; ?></b> 
    	<?php echo $text_list; ?><a onclick="display('grid');"><?php echo $text_grid; ?></a>
    </div>
    
  </div><!--/product-filter-->

  <div class="product-list">
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
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      <div class="description"><?php echo $product['description']; ?></div>
      <?php if ($product['price']) { ?>
      <div class="price">
        <?php if (!$product['special']) { ?>
        <?php echo $product['price']; ?>
        <?php } else { ?>
        <span class="saleIcon">%</span>
        <span class="price-new"><?php echo $product['special']; ?></span>
        <span class="price-old"><?php echo $product['price']; ?></span>
        <?php } ?>
        <?php if ($product['tax']) { ?>
        <br />
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
        <?php } ?>
      </div>
      <?php } ?>
      
      <div class="rating">
      	<img src="catalog/view/theme/lagon/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" />
      </div>
      
      <!-- wish  //  compare  //  cart
        =============-->
        <div class="hover-options">
        <span class="cartt"><a class="cartImg" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');"></a></span>
        <span class="wishh"><a class="wish" onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $button_wishlist; ?>"></a></span>
        <span class="comparee"><a class="compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $button_compare; ?>"></a></span>
        </div>
    </div>
    <?php } ?>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php }?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.product-list > div').each(function(index, element) {
			<!-- ********************** right ********************** -->
			html  = '<div class="right">';
			
			<!-- price -->
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
			<!--/price-->
			
			<!-- rating -->
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
			<!-- /rating -->
			html += '  <div class="hover-options">';
				html += '  <span class="cartt">' + $(element).find('.cartt').html() + '</span>';
				html += '  <span class="wishh">' + $(element).find('.wishh').html() + '</span>';
				html += '  <span class="comparee">' + $(element).find('.comparee').html() + '</span>';
			html += '</div>';	
			html += '</div>';			
			
			
			<!-- ********************** left ********************** -->
			html += '<div class="left">';
			
			<!-- image -->
			var image = $(element).find('.image').html();
			
			if (image != null) { 
				html += '<div class="image">' + image + '</div>';
			}
			<!-- /image -->
			
			html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
			html += '  <div class="description">' + $(element).find('.description').html() + '</div>';
			
			html += '</div>';
						
			$(element).html(html);
		});		
		
	$('.display').html('<b><?php echo $text_display; ?></b> <div class="display_list"><?php echo $text_list; ?></div> <div class="display_grid"><a  onclick="display(\'grid\');" title="<?php echo $text_grid; ?>"></a></div>');
		
		$.totalStorage('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.product-grid > div').each(function(index, element) {
			html = '';
			
			var image = $(element).find('.image').html();
			
			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '<div class="name">' + $(element).find('.name').html() + '</div>';
			html += '<div class="description">' + $(element).find('.description').html() + '</div>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
						
			html += '  <div class="hover-options">';
				html += '  <span class="cartt">' + $(element).find('.cartt').html() + '</span>';
				html += '  <span class="wishh">' + $(element).find('.wishh').html() + '</span>';
				html += '  <span class="comparee">' + $(element).find('.comparee').html() + '</span>';
			html += '</div>';	
			
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo $text_display; ?></b> <div class="display_list"><a onclick="display(\'list\');"  title="<?php echo $text_list; ?>"></a></div> <div class="display_grid"><?php echo $text_grid; ?></div>');
		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script> 
<?php echo $footer; ?>
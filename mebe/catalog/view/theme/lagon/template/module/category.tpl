<div class="box">
  <div class="box-heading"><span><?php echo $heading_title; ?></span></div>
  <div class="box-content">
    <div class="box-category  category">
      <ul class="accordion" id="accordion-1">
        <?php foreach ($categories as $category) { ?>
		<?php if ($category['category_id'] != 69) { ?> <!-- Тут id категории-->
        <li class="dcjq-current-parent">
          <?php if ($category['category_id'] == $category_id) { ?>
          <a href="<?php echo $category['href']; ?>" class="active maincategory"><?php echo $category['name']; ?></a>
          <?php } else { ?>
          <a href="<?php echo $category['href']; ?>" class="maincategory"><?php echo $category['name']; ?></a>
          <?php } ?>
          <?php if ($category['children']) { ?>
      
              <ul>
                <?php foreach ($category['children'] as $child) { ?>
                <li>
                  <?php if ($child['category_id'] == $child_id) { ?>
                  <a href="<?php echo $child['href']; ?>" class="active"> - <?php echo $child['name']; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $child['href']; ?>"> - <?php echo $child['name']; ?></a>
                  <?php } ?>
                </li>
                <?php } ?>
              </ul>
    
          <?php } ?>
        </li>
        <?php } ?>
		<?php } ?>
      </ul>
    </div>
  </div>
</div>


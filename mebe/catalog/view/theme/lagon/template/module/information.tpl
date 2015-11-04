<div class="box">
  <div class="box-heading"><span><?php echo $heading_title; ?></span></div>
  <div class="box-content box-category">
    <ul class='menu menu-sidebar'>
      <?php foreach ($informations as $information) { 
          if($information['hide']) continue;
          ?>
        <li class="<?=$information['css']?>">
        <a href="<?php echo $information['href']; ?>">
        <span><span class="icon" style="background-image: url('/catalog/view/theme/lagon/image/<?=$information['css']?>.jpg');"> </span>
            <?php echo $information['title']; ?>
        </span></a>
        </li>
      <?php } ?>
      <!--<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
      <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>-->
    </ul>
  </div>
</div>

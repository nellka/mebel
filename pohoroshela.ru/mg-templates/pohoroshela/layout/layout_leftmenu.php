<ul class="js_pro-accordion-menu"> 
    <?php 
    
    $clear_url_array = explode("/",URL::getClearUri());
    $clear_url = $clear_url_array[0]?$clear_url_array[0]:$clear_url_array[1];

    foreach ($data['categories'] as $category){ ?>
        <?php if ($category['invisible'] == "1") { continue;} ?>

        <?php if (SITE.'/'.$clear_url === $category['link']) {
            $active = 'active js_minus' ;
        } else {
            $active = '';
        } 
        ?>

        <?php if (isset($category['child'])){ ?>
            <?php 
             $slider = 'slider';
             $noUl = 1; 
             foreach($category['child'] as $categoryLevel1){
                 $noUl *= $categoryLevel1['invisible']; } if($noUl){$slider='';
              }?>

            <li class="<?php echo $active ?> <?php if(!empty($category['image_url'])): ?>cat-img<?php endif; ?>">
                <a href="<?php echo $category['link']; ?>">
                    <?php if(!empty($category['image_url'])): ?>
                      <span class="mg-cat-img">
                        <img src="<?php echo SITE.$category['image_url'];?>">
                      </span>
                    <?php endif; ?>
                    <?php echo MG::contextEditor('category', $category['title'], $category["id"], "category"); ?>
                    <?php echo $category['insideProduct']?'('.$category['insideProduct'].')':''; ?>
                </a>

                <?php  if($noUl){$slider=''; continue;}/*?>
                <ul class="submenu">

                    <?php foreach ($category['child'] as $categoryLevel1){ ?>
                        <?php if ($categoryLevel1['invisible'] == "1") { continue; } ?>

                        <?php if (SITE.URL::getClearUri() === $categoryLevel1['link']) {
                            $active = 'active';
                        } else {
                            $active = '';
                        } ?>

                        <?php if (isset($categoryLevel1['child'])){ ?>
                            <?php  $slider = 'slider'; $noUl = 1; foreach($categoryLevel1['child'] as $categoryLevel2){$noUl *= $categoryLevel2['invisible']; } if($noUl){$slider='';}?>

                            <li class="<?php echo $active ?>">
                                <?php if(!empty($categoryLevel1['image_url'])){ ?>
                                    <div class="mg-cat-img">
                                        <img src="<?php echo SITE.$categoryLevel1['image_url'];?>">
                                    </div>
                                <?php } ?>
                                <div class="mg-cat-name">
                                    <a href="<?php echo $categoryLevel1['link']; ?>">
                                        <?php echo MG::contextEditor('category', $categoryLevel1['title'], $categoryLevel1["id"], "category"); ?>
                                        <?php echo $categoryLevel1['insideProduct']?'('.$categoryLevel1['insideProduct'].')':''; ?>
                                    </a>
                                </div>

                                <?php  if($noUl){$slider=''; continue;} ?>
                                <ul>
                                    <?php foreach ($categoryLevel1['child'] as $categoryLevel2){ ?>
                                        <?php if ($categoryLevel2['invisible'] == "1") {
                                            continue;
                                        } ?>
                                        <?php if (SITE.URL::getClearUri() === $categoryLevel2['link']) {
                                            $active = 'active';
                                        } else {
                                            $active = '';
                                        } ?>
                                        <?php if (isset($categoryLevel2['child'])){ ?>
                                            <?php $slider = 'slider'; $noUl = 1; foreach($categoryLevel2['child'] as $categoryLevel3){$noUl *= $categoryLevel3['invisible']; } if($noUl){$slider='';}?>

                                            <li class="<?php echo $active ?>">
                                                <a href="<?php echo $categoryLevel2['link']; ?>">
                                                    <?php echo MG::contextEditor('category', $categoryLevel2['title'], $categoryLevel2["id"], "category"); ?>
                                                    <?php echo $categoryLevel2['insideProduct']?'('.$categoryLevel2['insideProduct'].')':''; ?>
                                                </a>
                                                <?php  if($noUl){$slider=''; continue;} ?>
                                            </li>

                                        <?php } else { ?>

                                            <li class="<?php echo $active ?>">
                                                <a href="<?php echo $categoryLevel2['link']; ?>">
                                                    <?php echo MG::contextEditor('category', $categoryLevel2['title'], $categoryLevel2["id"], "category"); ?>
                                                    <?php echo $categoryLevel2['insideProduct']?'('.$categoryLevel2['insideProduct'].')':''; ?>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    <?php } ?>
                                </ul>
                            </li>

                        <?php } else { ?>
                            <li class="<?php echo $active ?>">
                                <?php if(!empty($categoryLevel1['image_url'])){ ?>
                                    <div class="mg-cat-img">
                                        <img src="<?php echo SITE.$categoryLevel1['image_url'];?>">
                                    </div>
                                <?php }; ?>
                                <div class="mg-cat-name ll">
                                    <a href="<?php echo $categoryLevel1['link']; ?>">
                                        <?php echo MG::contextEditor('category', $categoryLevel1['title'], $categoryLevel1["id"], "category"); ?>
                                        <?php echo $categoryLevel1['insideProduct']?'('.$categoryLevel1['insideProduct'].')':''; ?>
                                    </a>
                                </div>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </li>
        <?php */} else{
        	//if(URL::getClearUri() == '/group'||URL::getClearUri() == '/recommend') continue;
        	?>
            <li class="<?php echo $active ?> <?php if(!empty($category['image_url'])): ?>cat-img<?php endif; ?>">
                <a href="<?php echo $category['link']; ?>">
                    <?php if(!empty($category['image_url'])): ?>
                        <span class="mg-cat-img">
                        <img src="<?php echo SITE.$category['image_url'];?>">
                    </span>
                    <?php endif; ?>
                    <?php //echo MG::contextEditor('category', $category['title'], $category["id"], "category"); ?>
                    <?php //echo $category['insideProduct']?'('.$category['insideProduct'].')':''; ?>
                </a>
            </li>
        <?php }; ?>
    <?php }?>
    <li><a href="<?php echo SITE; ?>/group?type=latest">Новые поступления</a></li>
    <li><a href="<?php echo SITE; ?>/group?type=recommend">Самые продаваемые</a></li>
</ul>
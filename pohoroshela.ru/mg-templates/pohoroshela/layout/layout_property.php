<?php 
echo $data['blockVariants']; ?>
<?php echo $data['addHtml']; ?>
<div class="buy-container">
  <?php if(!$data['noneAmount']){ ?>
    <div class="hidder-element" <?php echo ($data['maxCount']=="0"?'style="display:none"':'') ?> >
      
      <div class="cart_form">
        <input type="text" name="amount_input" class="amount_input" data-max-count="<?php echo $data['maxCount'] ?>" value="1" />
        <div class="amount_change">
          <a href="#" class="up">+</a>
          <a href="#" class="down">-</a>
        </div>
      </div>
    </div>
  <?php } ?>


    
  <div class="hidder-element" <?php echo ($data['noneButton']?'style="display:none"':'') ?> >
    <input type="hidden" name="inCartProductId" value="<?php echo $data['id'] ?>">

    <?php
    $model = new Models_Product();
    $variants = $model->getVariants($data['id']);
    $count = $data['maxCount'];
    if($variants){
      $count = 0;
      // вычисляем общее число вариантов
      foreach($variants as $variant){
        $count += $variant['count'];
      }
    }
    ?>

    <?php if(!$data['noneButton']||($count>0||$count<0)){ ?>
      <?php if($data['ajax']){
        if($data['buyButton']){
          ?>
          <?php echo $data['buyButton']; ?>
         <?php }
         else{ ?>

          <a class = "<?php echo $data['classForButton'] ?>"
             href = "<?php echo SITE.'/catalog?inCartProductId='.$data['id'] ?>"
             data-item-id="<?php echo $data['id'] ?>">

          <?php echo $data['titleBtn']; ?>

          </a>

          <input type="submit" name="buyWithProp" onclick="return false;" style="display:none">
        <?php
        }
      }
      else{
        ?>

        <input type="submit" name="buyWithProp">

        <?php } ?>
        <?php if($data['printCompareButton']=='true'){ ?>

        <a href="<?php echo SITE.'/compare?inCompareProductId='.$data['id'] ?>" data-item-id="<?php echo $data['id'] ?>" class="addToCompare" >
        <?php echo MG::getSetting('buttonCompareName'); ?>
        </a>

        <?php if(class_exists('BuyClick')): ?>
          [buy-click id="<?php echo $data['id'] ?>"]
        <?php endif; ?>

        <?php } ?>
        <?php } ?>

  </div>
</div>
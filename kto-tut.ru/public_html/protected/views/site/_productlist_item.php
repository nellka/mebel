<?
$quantityArray =  array();
for ($i=1;$i<=$data->quantity;$i++ ){
$quantityArray[$i] = $i;
}
?>

<div class="view">
    <div class="mchkbox"><?php echo CHtml::checkBox('id[]',false,array('value'=>$data->product_id,'style'=>'float:left')) ?></div>
     <div class="smallimg">
        <?php echo CHtml::image($data->image,$data->model,array('style'=>'max-wight: 70px;max-height:70px;float:left')); ?>
    </div>
    <b><?php  echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b>Покупаю:</b>
	<? if (!$data->quantity) { ?>
           <b>Товара нет в наличии</b><br/>
  
    <? } else echo CHtml::DropDownList('quantity'.$data->product_id,1,$quantityArray);?>	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
</div>

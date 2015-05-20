<?
$quantityArray =  array();
for ($i=1;$i<=$data->quantity;$i++ ){
$quantityArray[$i] = $i;
}
?>

<div class="view">
    <div class="mchkbox"><?php echo CHtml::checkBox('id[]',false,array('value'=>$data->product_id,'style'=>'float:left', 'disabled'=>!$data->quantity?'disabled':false)) ?></div>
     <div class="smallimg">
        <?php echo CHtml::image($data->image,$data->model); ?>
    </div>
    <b><?php  echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?><br>
	 <b>Категория:</b>
	<?php echo CHtml::encode($data->ct->title); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity) ?>
	<br />

	<b>Покупаю:</b>
	<? if (!$data->quantity) { ?>
           <b>Товара нет в наличии</b>  
    <? } else {
        echo CHtml::DropDownList('quantity'.$data->product_id,1,$quantityArray);       
    }?>
 <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?=round(CHtml::encode($data->price),0)?> р.
</div>

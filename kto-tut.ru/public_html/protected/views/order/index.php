<?php
/* @var $this SiteController */
$me = Yii::app()->user->me;
$this->pageTitle=$me->username;
?>

<h3>Сформировать заказ</h3>
<b><i>Логин: </i></b><?=$me->username?><br>
<b><i>Email: </i></b><?=$me->email?><br>
<b><i>Телефон:</i></b> <?=$me->phone?><br><br>


<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

<h3>Список товаров</h3>

<?php
foreach ($products as $data){ 

?>

<div class="view">
    <div class="smallimg">
        <?php echo CHtml::image($data->image,$data->model,array('style'=>'max-wight: 70px;max-height:70px;float:left')); ?>
    </div>
    
	<b><?php //  echo $form->checkBox('product'.$data->product_id,'', array ('checked'=>'checked',	'value'=>'on',	)); ?>	


	<b><?php  echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b>Покупаю:</b>
	<?php //$form->textField(null,'quant'.$data->product_id,array('style'=>'width:400px;'));?>	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	
	<br />

	<?php 
?>
</div>
<?php 
}?>
<div class="row">
	Комментарий к заказу
	<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
	<?php echo $form->error($model,'body'); ?>
</div>	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>
<?	
$this->endWidget(); ?>

</div><!-- form -->
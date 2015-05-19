<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Заказы'=>array('admin'),
	'Изменение',
);

$this->menu=array(
	array('label'=>'Управление заказами', 'url'=>array('admin')),
);
?>
    <?php if(Yii::app()->user->hasFlash('error')):?>
    	<div  class="flash-error">
    		<?php echo Yii::app()->user->getFlash('error'); ?>
    	</div>
    <?php endif; ?>
    
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

<h3>Заказ № <?=$model->order_id?></h3>
<div class="row">
	<b>Создан:</b> <?=$model->date?>
</div>	
<div class="row">
	<b>Пользователь:</b> <?=CHtml::link($model->us->username,"/cp/user/view/id/$model->user_id",array("target"=>"_blank"));?>
</div>	
<div class="row">
	<b>Email:</b> <?=$model->us->email;?>
</div>	
<div class="row">
	<b>Телефон:</b> <?=$model->us->phone;?>
</div>	
<b>Товары в заказе:</b>

<div id="message-list-sort">
<?php
$i = 1;
foreach ($products->getData() as $data){ 
    $product = Product::model()->findByPk($data->product_id);?>
    
    <div class="view">   
    <?=$i?>. <b><?php echo CHtml::encode($product->model); ?></b>(Цена: <?php echo CHtml::encode($product->price); ?>) - <?php echo CHtml::encode($data->quantity); ?> шт.	
</div>

    <?
    $i++;
} ?>
<div class="row">
	<i>Комментарий к заказу:</i> <?=trim($model->comment)?trim($model->comment):"-"?>
</div>	
<div class="row">
	<?php echo $form->labelEx($model,'order_status_id')?>
	<?php echo $form->DropDownList($model,'order_status_id',Order::$getStatus); ?>
	<?php //echo $form->error($model,'order_status_id'); ?>
</div>

</div>
	<?php echo $form->errorSummary($model); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
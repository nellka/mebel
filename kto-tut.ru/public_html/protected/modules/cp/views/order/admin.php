<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array('Заказы');


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление заказами</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">

</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'order_id',		
		array(
	        'name'=>'order_id',
	        'type'=>'raw',	        
	        'value'=>'CHtml::link("Заказ №".$data->order_id,"/cp/order/update/id/$data->order_id")',
        ),	
        
        array(
	        'header'=>'Пользователь',
	        'type'=>'raw',	        
	        'value'=>'CHtml::link($data->us->username,"/cp/user/view/id/$data->user_id",array("target"=>"_blank"))',
        ),	
        array(
	        'name'=>'order_status_id',
	        'type'=>'raw',	        
	        'value'=>'ORDER::$getStatus[$data->order_status_id]',
        ),	
        'ip',
        'date',	
		
	),
)); ?>

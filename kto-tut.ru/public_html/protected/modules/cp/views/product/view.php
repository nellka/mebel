<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Товары'=>array('admin'),
	$model->product_id,
);

$this->menu=array(
    array('label'=>'Создать товар', 'url'=>array('create')),
	array('label'=>'Изменить товар', 'url'=>array('update', 'id'=>$model->product_id)),
	array('label'=>'Удалить товар', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->product_id),'confirm'=>'Вы уверены, что хотите удалить этот элемент?')),
	array('label'=>'Управление товарами', 'url'=>array('admin')),
);
?>

<h1>Просмотр товара #<?php echo $model->product_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'product_id',
		'model',
		'ct.title',
		'sku',
		'quantity',
		'image',
		'price',
		'status',
		'date_added',
		'viewed',
	),
)); ?>

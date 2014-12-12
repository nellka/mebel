<?php
$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('admin')),
	array('label'=>'Создать', 'url'=>array('create')),	
	array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить элемент?')),
);
?>

<h1>Просмотр City #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'alias',
		'name',
		'status',
		'order',
	),
)); ?>

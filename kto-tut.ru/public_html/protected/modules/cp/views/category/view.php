<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->category_id,
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('create')),
	array('label'=>'Изменить категорию', 'url'=>array('update', 'id'=>$model->category_id)),
	array('label'=>'Удалить категорию', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->category_id),'confirm'=>'Вы уверены, что хотите удалить этот элемент?')),
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<h1>Просмотр категории #<?php echo $model->category_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'category_id',
		array(
	        'name'=>'parent_id',
	        'type'=>'raw',	        
	        'value'=>$model->parent_id?$model->getTitle($model->parent_id):0,
        ),
		'title',
		array(
	        'name'=>'disabled',
	        'type'=>'raw',	        
	        'value'=>$model->disabled?"Да":"Нет",
        )
	),
)); ?>

<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Категории',
);

$this->menu=array(
	array('label'=>'Создание категории', 'url'=>array('create')),
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<h1>Категории</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

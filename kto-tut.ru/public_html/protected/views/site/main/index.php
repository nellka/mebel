<?php
/* @var $this ProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Товары',
);

$this->menu=array(
	array('label'=>'Создание товара', 'url'=>array('create')),
	array('label'=>'Управление товарами', 'url'=>array('admin')),
);
?>

<h1>Товары</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

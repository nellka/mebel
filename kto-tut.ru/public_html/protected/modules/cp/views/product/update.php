<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Товары'=>array('admin'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Сисок товаров', 'url'=>array('index')),
	array('label'=>'Создать товар', 'url'=>array('create')),
	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->product_id)),
	array('label'=>'Управление товаром', 'url'=>array('admin')),
);
?>

<h1>Редактирование товара <?php echo $model->product_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
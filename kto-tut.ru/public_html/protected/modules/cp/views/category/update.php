<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Категории'=>array('admin'),
	'Изменение',
);

$this->menu=array(
	array('label'=>'Создание категории', 'url'=>array('create')),
	array('label'=>'Просмотр категорий', 'url'=>array('view', 'id'=>$model->category_id)),
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<h1>Изменение категории <?php echo $model->category_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
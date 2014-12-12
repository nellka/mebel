<?php
$this->breadcrumbs=array(
	'Cities'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('admin')),
	array('label'=>'Создать', 'url'=>array('create')),
);
?>

<h1>Создать</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
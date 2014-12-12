<?php
$this->breadcrumbs=array(
	'Анкеты'=>array('index'),
	'Новая',
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать анкету</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
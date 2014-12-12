<?php
$this->breadcrumbs=array(
	'Анкеты'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('index')),
);
?>

<h1>Создать</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
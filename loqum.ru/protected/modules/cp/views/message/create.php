<?php
$this->breadcrumbs=array(
	'Сообщения'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('admin')),
);
?>

<h1>Создать сообщение</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
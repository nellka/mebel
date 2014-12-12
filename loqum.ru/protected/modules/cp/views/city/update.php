<?php
$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

    $this->renderPartial('_menu');
?>

<h1>Редактировать </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
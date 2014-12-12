<?php
$this->breadcrumbs=array(
	'Анкеты'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
);
$this->renderPartial('_menu',compact('model'));
?>

<h1>Редактировать Анкету № <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
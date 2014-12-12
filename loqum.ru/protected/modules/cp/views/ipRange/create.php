<?php
/* @var $this IpRangeController */
/* @var $model IpRange */

$this->breadcrumbs=array(
	'Диапазоны IP'=>array('index'),
	'Создать',
);

$this->renderPartial('_menu');
?>

<h1>Создать диапазон IP</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
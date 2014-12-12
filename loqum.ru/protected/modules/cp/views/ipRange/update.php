<?php
/* @var $this IpRangeController */
/* @var $model IpRange */

$this->breadcrumbs=array(
    'Диапазоны IP'=>array('index'),
    'Редактировать',
);

$this->renderPartial('_menu');
?>

<h1>Редактировать диапазон <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this IpRangeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ip Ranges',
);

$this->menu=array(
	array('label'=>'Create IpRange', 'url'=>array('create')),
	array('label'=>'Manage IpRange', 'url'=>array('admin')),
);
?>

<h1>Ip Ranges</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

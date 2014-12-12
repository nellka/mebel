<?php
/* @var $this IpRangeController */
/* @var $model IpRange */

$this->breadcrumbs=array(
	'Ip Ranges'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List IpRange', 'url'=>array('index')),
	array('label'=>'Create IpRange', 'url'=>array('create')),
	array('label'=>'Update IpRange', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete IpRange', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IpRange', 'url'=>array('admin')),
);
?>

<h1>View IpRange #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ip_from',
		'ip_to',
		'timestamp',
		'description',
	),
)); ?>

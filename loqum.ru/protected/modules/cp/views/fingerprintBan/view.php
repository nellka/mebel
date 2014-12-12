<?php
/* @var $this FingerprintBanController */
/* @var $model FingerprintBan */

$this->breadcrumbs=array(
	'Fingerprint Bans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FingerprintBan', 'url'=>array('index')),
	array('label'=>'Create FingerprintBan', 'url'=>array('create')),
	array('label'=>'Update FingerprintBan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FingerprintBan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FingerprintBan', 'url'=>array('admin')),
);
?>

<h1>View FingerprintBan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'value',
		'status_bad',
		'status',
		'time_start',
	),
)); ?>

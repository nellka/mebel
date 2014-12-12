<?php
/* @var $this FingerprintBanController */
/* @var $model FingerprintBan */

$this->breadcrumbs=array(
	'Fingerprint Bans'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FingerprintBan', 'url'=>array('index')),
	array('label'=>'Create FingerprintBan', 'url'=>array('create')),
	array('label'=>'View FingerprintBan', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FingerprintBan', 'url'=>array('admin')),
);
?>

<h1>Update FingerprintBan <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
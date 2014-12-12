<?php
/* @var $this FingerprintBanController */
/* @var $model FingerprintBan */

$this->breadcrumbs=array(
	'Fingerprint Bans'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FingerprintBan', 'url'=>array('index')),
	array('label'=>'Manage FingerprintBan', 'url'=>array('admin')),
);
?>

<h1>Create FingerprintBan</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
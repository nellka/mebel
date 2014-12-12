<?php
/* @var $this FingerprintBanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fingerprint Bans',
);

$this->menu=array(
	array('label'=>'Create FingerprintBan', 'url'=>array('create')),
	array('label'=>'Manage FingerprintBan', 'url'=>array('admin')),
);
?>

<h1>Fingerprint Bans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
$this->breadcrumbs=array(
	'Cities',
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('admin')),
	array('label'=>'Создать', 'url'=>array('create')),
);
?>

<h1>Cities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

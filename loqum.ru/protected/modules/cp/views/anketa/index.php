<?php
$this->breadcrumbs=array(
	'Anketas',
);

$this->menu=array(
	array('label'=>'Create Anketa', 'url'=>array('create')),
	array('label'=>'Manage Anketa', 'url'=>array('admin')),
);
?>

<h1>Anketas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

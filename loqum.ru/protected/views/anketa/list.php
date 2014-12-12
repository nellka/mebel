<?php
$this->layout='//layouts/column1';
$this->breadcrumbs=array(
	'Анкеты',
);?>
<h1>Анкеты</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'ajaxUpdate' => false
)); ?>



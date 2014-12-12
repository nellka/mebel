<?php $this->renderPartial('_menu');
$this->breadcrumbs=array(
	'Разное'=>array('/admin/other'),
	'Статистика',
);?>
<h1>Статистика переходов</h1>

<?php $i = 0; $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
//	'filter'=>$model,
    'columns' => array(

        array(
            'name' => '#пп',
            'value' => '$row+1',

        ),
        'page',

        array(
            'name' => 'дата и время',
            'value' => 'date(\'d.m.Y H:i\',$data["timestamp"])',
        ),
	),
)); ?>
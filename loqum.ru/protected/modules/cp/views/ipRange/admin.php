<?php
/* @var $this IpRangeController */
/* @var $model IpRange */

$this->breadcrumbs=array(
	'Диапазоны Ip'=>array('index'),
);

$this->renderPartial('_menu');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ip-range-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Диапазоны IP</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ip-range-grid',
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
    'filter'=>null,
	'columns'=>array(
		array(
            'name'=>'id',
            'filter'=>false
        ),
        array(
            'name'=>'ip_from',
            'value'=>'CHtml::link($data->ip1,"http://www.nic.ru/whois/?query={$data->ip1}",array("target"=>"_blank"))',
            'type'=>'raw',
            'filter'=>false,
        ),
        array(
            'name' => 'ip_to',
            'value'=>'CHtml::link($data->ip2,"http://www.nic.ru/whois/?query={$data->ip2}",array("target"=>"_blank"))',
            'type'=>'raw',
            'filter'=>false,
        ),
        array(
            'name' =>         'timestamp',
            'value'=>'date("d.m.Y H:i",$data->timestamp)',
            'filter'=>false,
        ),

		'description',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
		),
	),
)); ?>

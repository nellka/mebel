<?php
$this->breadcrumbs=array(
	'Сообщения',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('message-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление сообщениями</h1>

<p>
Можно использовать операции сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>)
</p>

<?php /* echo CHtml::link('','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form --> */ ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'message-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'id_from',
        array(
            'value' => '$data->from->name',
            'header' => 'От кого',
            'filter' => '',
        ),
		'id_to',
        array(
            'value' => '$data->to->name',
            'header' => 'Кому',
            'filter' => '',
        ),
        array(
            'value' => 'date("d.m.Y H:i:s",$data->datestamp)',
            'header' => 'Когда',
//            'filter' => '',
        ),
		//'datestamp',
        array(
            'value' => '$data->viewed',
            'header' => $model->getAttributeLabel('viewed'),
            'filter' => CHtml::activeDropDownList($model, 'viewed',array(0,1),array('empty'=>'Все')),
        ),
        array(
            'value' => '$data->deleted',
            'header' => $model->getAttributeLabel('deleted'),
            'filter' => CHtml::activeDropDownList($model, 'deleted',array(0,1),array('empty'=>'Все')),
        ),
        'message',

        /*
          */
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

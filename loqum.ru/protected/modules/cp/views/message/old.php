<?php
$this->breadcrumbs=array(
	'Переписки'=>array('/cp/message'),
);
if ($model->id_from) {
    $this->breadcrumbs[$model->from->name]=array('message/list','id'=>$model->id_from);
    $params = array('model'=>$model->from);
}
$this->renderPartial('_menu',isset($params)?$params:array());

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

<h1>Переписки</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'message-grid',
    'dataProvider'=>$dataProvider,
//    'filter'=>$model,
    'columns'=>array(
//        'id_from',
        array(
            'value' => 'CHtml::link($data->from->name. " ,".$data->from->age,array("message/list","id"=>$data->id_from))',
            'header' => 'От кого',
            'filter' => '',
            'type'=>'raw',
        ),
//        'id_to',
        array(
            'value' => 'CHtml::link($data->to->name. " ,".$data->to->age,array("message/list","id"=>$data->id_to))',
            'header' => 'Кому',
            'filter' => '',
            'type'=>'raw',
        ),
        array(
            'value' => 'date("d.m.Y H:i:s",$data->datestamp)',
            'header' => 'Последнее',
        ),
//        array(
//            'value' => '$data->viewed',
//            'header' =>'[@]',
//            'filter' => CHtml::activeDropDownList($model, 'viewed',array(0,1),array('empty'=>'Все')),
//        ),
        array(
            'name'=>'cnt',
            'value'=>'CHtml::link($data->cnt,array("message/show","l"=>$data->id_from."-".$data->id_to))',
            'type'=>'raw',
        ),

        //'message',
    ),
)); ?>

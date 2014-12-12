<?php
$this->pageTitle ='Переписки';
$this->renderPartial('_menu',compact('model'));
?>
<h1>Переписки</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'message-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        array(
            'value' => 'CHtml::link($data->from->name. " ,".$data->from->age,array("message/list","id"=>$data->id_from))',
            'header' => 'От кого',
            'filter' => '',
            'type'=>'raw',
        ),
        array(
            'value' => 'CHtml::link($data->to->name. " ,".$data->to->age,array("message/list","id"=>$data->id_to))',
            'header' => 'Кому',
            'filter' => '',
            'type'=>'raw',
        ),
        array(
            'value' => 'date("d.m.Y H:i:s",$data->last_time)',
            'header' => 'Последнее',
        ),

        array(
            'name'=>'cnt',
            'value'=>'CHtml::link($data->cnt,array("message/show","l"=>$data->id_from."-".$data->id_to))',
            'type'=>'raw',
        ),
    ),
)); ?>


<?php

$this->menu=array(
    array('label'=>'К списку', 'url'=>array('index')),
    array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Переписка', 'url'=>array('/cp/message/list', 'id'=>$model->id)),
    array('label'=>'IP', 'url'=>array('zombie', 'id'=>$model->id)),
    array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Удалить?')),
);
?>
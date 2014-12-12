<?php

$this->menu=array(
    array('label'=>'К списку', 'url'=>array('index')),
    array('label'=>'Создать', 'url'=>array('create')),
//    array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->id),'visible'=>isset ($model)),
    array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Удалить?'),'visible'=>isset ($model)),
);
?>
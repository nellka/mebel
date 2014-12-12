<?php

$this->menu=array(
    array('label'=>'Переписки', 'url'=>array('index')),
    array('label'=>'Статистика', 'url'=>array('stat')),
);
if (isset($model) && !empty($model))
    $this->menu[] = array('label'=>'К анкете', 'url'=>array('/cp/anketa/view', 'id'=>$model->id));
?>
<?php
$actions = array(
//    'searches'=>'Архив поиска',
    'stat'=>'Статистика',

);
foreach ($actions as $action=>$title)
    //echo CHtml::link($action,$title);
$this->menu[]= array('label'=>$title, 'url'=>array($action));
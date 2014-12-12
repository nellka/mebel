<?php
$this->widget('MyListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => !isset($itemview)?'_simplesmall':$itemview, // refers to the partial view named '_post'
    'emptyText' => 'Ничего не найдено',
    'ajaxUpdate'=>false, // отключаем ajax поведение
    'summaryText' => ''//'Всего: {count}',
));

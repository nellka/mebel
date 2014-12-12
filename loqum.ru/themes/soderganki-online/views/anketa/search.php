<?php
$this->pageTitle = 'Поиск';
if (!empty($model->location))
    $this->pageTitle = "Знакомства с богатыми мужчинами в г. {$model->location} . Поиск спонсоров и содержанок. Любовницы и любовники в г {$model->location}.";

$this->breadcrumbs=array(
	'Поиск',
);?>


    <h2 class="result-header">Результаты поиска</h2>
    <?php $this->renderPartial('_list', array('dataProvider' => $model->search(), 'itemview' => '_simplerow'));?>

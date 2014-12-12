<?php
$this->layout='column1';
$mode = 'dislike';
$this->breadcrumbs=array(
	'Анкеты'=>array('/anketa'),
	'Не очень',
);?>
<h1>Не очень...</h1>
<?php if ($models) foreach ($models as $model) {
$this->renderPartial('_simplesmall',compact('model','mode'));
} else echo 'Анкет не найдено',CHtml::link('Поискать?',array('search'));?>

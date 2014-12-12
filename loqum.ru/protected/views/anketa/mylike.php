<?php
$this->layout='column1';
$mode = 'mylike';
$this->breadcrumbs=array(
	'Анкеты'=>array('/anketa'),
	'Мне нравятся',
);?>
<h1>Мне нравятся</h1>
<?php if (Yii::app()->user->isGuest) {
    echo '<p>Вам ответят взаимностью только после ', CHtml::link('регистрации', array('register/register')),'.</p>';
} ?>
<?php if ($models) foreach ($models as $model) {
$this->renderPartial('_simplesmall',compact('model','mode'));
} else echo 'Вам ещё никто не понравился ',CHtml::link('Поискать?',array('search'));?>

<?php
$this->layout='column1';
$mode = 'welike';
$this->breadcrumbs=array(
	'Анкеты'=>array('/anketa'),
	'Мы нравимся',
);?>
<h1>Мы нравимся друг другу</h1>
<?php
if (Yii::app()->user->isGuest) {
    echo 'Чтобы понравиться, нужно  ', CHtml::link('Зарегистрироваться?', array('register/register'));
} else {
    if ($models)
        foreach ($models as $model) {
    $this->renderPartial('_simplesmall',compact('model','mode'));
    } else echo 'Взаимных симпатий нет. ',CHtml::link('Поискать?',array('search'));
}

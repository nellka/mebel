<?php
$this->layout='column1';
$mode = 'melike';
$this->breadcrumbs=array(
	'Анкеты'=>array('/anketa'),
	'Я нравлюсь',
);?>
<h1>Я нравлюсь</h1>
<?php
if (Yii::app()->user->isGuest) {
    echo 'Чтобы понравиться, нужно  ', CHtml::link('Зарегистрироваться?', array('register/register'));
} else {
    if ($models)
        foreach ($models as $model) {
            $this->renderPartial('_simplesmall', compact('model','mode'));
        } else echo 'Вы ещё никому не понравились. ', CHtml::link('Поискать?', array('search'));
}
<?php
$this->pageTitle = 'Подъем анкеты';
//$this->layout = '//layouts/column2left';
$this->renderPartial('_menu');

$this->breadcrumbs=array(
    'Профиль'=>array('/profile'),
    'Подъем анкеты',
);?>
<h1>Подъем анкеты</h1>
<?php $this->renderPartial('_serviceup',array('anketa'=>$me)); ?>

<p>Стоимость подъема анкеты - 100 рублей.</p><p>
    Поднятие сделает вашу анкету в поиске первой после анкет из раздела "ТОП".</p><p>
    Также поднятие анкеты сделает вашу анкету в категории "ТОП" первой, если вы уже оплатили "ТОП"</p><p>
</p>
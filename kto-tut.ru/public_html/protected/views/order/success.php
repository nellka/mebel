<?php
/* @var $this SiteController */
$me = Yii::app()->user->me;
$this->pageTitle=$me->username;
?>

Уважаемый <b><?=$me->username?></b>!<br><br>
Ваш заказ успешно сформирован. <br>
Копия заказа отправлена к Вам на email <b><?=$me->email?></b>.<br>
В ближайшее время мы обязательно свяжемся с Вами.<br><br>

Список своих заказов вы можете упосмотреть в <a href="/order/my">личном кабинете.</a><br><br>

С уважением, администрация сайта <a href="http://kto-tut.ru">http://kto-tut.ru</a>


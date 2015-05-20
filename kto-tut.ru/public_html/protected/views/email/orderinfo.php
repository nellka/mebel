<?php
/* @var $this SiteController */
$me = Yii::app()->user->me;
$this->pageTitle=$me->username;

if($for_admin){?>
    Здравствуйте!<br>
    На сайте <a href="http://kto-tut.ru">http://kto-tut.ru</a> создан новый заказа от пользователя <?=$me->username?>.<br><br>
    <b>Информация о пользователе: </b><br>
    Логин: <?=$me->username?><br>
    Email: <?=$me->email?><br>
    Телефон: <?=$me->phone?><br><br>
    
    
<?} else {?>
    Уважаемый <b><?=$me->username?></b>!<br>
    Ваш заказ на сайте <a href="http://kto-tut.ru">http://kto-tut.ru</a> успешно сформирован. <br><br>
<?}?>

<b>Список товаров в заказе:</b><br>
<?
$i = 1;
foreach ($products as $pid=>$quantity){ 
    $product = Product::model()->findByPk($pid);?>
    <?=$i?>. <b><?php echo CHtml::encode($product->model); ?></b>(Цена: <?php echo CHtml::encode($product->price); ?>) - <?=$quantity ?> шт.<br>	
    <?  $i++;
} ?>

<br>Комментарий к заказу: <?=$comment?><br>

<?if(!$for_admin){?>
<br>В ближайшее время мы обязательно свяжемся с Вами.<br><br>
С уважением, администрация сайта <a href="http://kto-tut.ru">http://kto-tut.ru</a>
<?}?>
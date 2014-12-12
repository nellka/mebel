<?php
$this->menu=array(
//    array('label'=>'', 'url'=>array('')),
    array('label'=>'Мой профиль', 'url'=>'/profile/profile'),
    array('label'=>'Уведомления на почту', 'url'=>'/profile/notify'),
    array('label'=>'Фотографии', 'url'=>array('profile/photos')),
    array('label'=>'Сменить пароль', 'url'=>array('profile/changePassword')),
//    array('label'=>'Кошелек', 'url'=>array('/profile/wallet')),
////    array('label'=>'Премиум-аккаунт', 'url'=>array('profile/premium')),
//    array('label'=>'Топ(закрепление анкеты)', 'url'=>array('profile/top')),
//    array('label'=>'Поднятие анкеты', 'url'=>array('profile/up')),
////    array('label'=>'Пополнить контакты', 'url'=>array('profile/contacts')),
    array('label'=>'Удалить анкету', 'url'=>array('profile/delete'),'linkOptions'=>array('style'=>'color:#ccc;')),
);
$this->layout = '//layouts/column2left';

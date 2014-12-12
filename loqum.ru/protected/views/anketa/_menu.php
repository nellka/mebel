<?php
$this->menu=array(
//    array('label'=>'', 'url'=>array('')),
    array('label'=>'Мой профиль', 'url'=>'/profile/profile'),
    array('label'=>'Уведомления на почту', 'url'=>'/profile/notify'),
    array('label'=>'Фотографии', 'url'=>array('profile/photos')),
    array('label'=>'Сменить пароль', 'url'=>array('profile/changePassword')),
    array('label'=>'Кошелек', 'url'=>array('/profile/wallet')),
//    array('label'=>'Платные возможности', 'url'=>array('profile/')),
);
//    с кошелек платные возможности
<h1>Регистрация успешно завершена</h1>
<?php //if(Yii::app()->user->hasFlash('registered')): ?>
	<div class="flash-success">
        Ваша регистрация прошла успешно.<br/>
        Вам на почту ушло письмо с паролем на случай, если вы его забудете.<br/>
        Вы можете дополнить свою анкету на странице <a href="/profile">профиля</a><br/>
        Или приступить к <a href="/anketa/search">поиску</a>
	</div>
<?php //endif ?>
<?php //$this->renderPartial('application.views.site.pages.howto');?>
<?php
$disallowMessage = Yii::app()->user->isGuest ?
    Anketa::DISALLOW_MESSAGE_IS_GUEST:
    Yii::app()->user->me->disallowMessageTo($anketa);
// special for Yndex
//if ($disallowMessage==Anketa::DISALLOW_MESSAGE_IS_GUEST)
//    $disallowMessage = Anketa::DISALLOW_MESSAGE_NONE;
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-_message-form',
	'enableAjaxValidation'=>false,
)); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('cols'=>50,'rows'=>'5')); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить',array('disabled'=>0!=$disallowMessage)); ?>
	</div>

    <?php
    switch($disallowMessage) {
        case Anketa::DISALLOW_MESSAGE_NOCONTACTS:
            $msg = <<<HTML
У вас закончились контакты.<br>
Возможность начать новую переписку <span class="pink">отключена</span>.<br>
Для возможности написать пополните <a href="/profile/contacts" class="orange">контакты</a>.<br>
<a href="/profile/contacts">Что такое контакты?</a><br>
HTML;
                break;
        case Anketa::DISALLOW_MESSAGE_NOPREMIUM:
            $msg = <<<HTML
У вас закончился пробный аккаунт. <br>
Возможность переписки с девушками <span class="pink">отключена</span>. <br>
Для возможности писать необходимо приобрести <a href="/profile/premium" class="orange">премиум-аккаунт</a>
HTML;
                break;
        case Anketa::DISALLOW_MESSAGE_WOMAN2WOMAN:
            $msg = <<<HTML
Возможность переписки между девушками по умолчанию  <span class="pink">отключена</span>.<br>
Для включения переписки с девушками подключите <a href="/profile/premium" class="orange">премиум-аккаунт</a>.
HTML;
                break;
        case Anketa::DISALLOW_MESSAGE_IS_GUEST:
            $msg = <<<HTML
            Чтобы отправить сообщение - войдите под своим логином. <a href="/site/login">Вход</a>.<br>
            Нет анкеты на нашем сайте? <a href="/register/register">Бесплатная регистрация</a>
HTML;
                break;
        case Anketa::DISALLOW_MESSAGE_BAN:
            $msg = <<<HTML
        Переписка отключена.Ваш аккаунт заблокирован за нарушение <a href="/rules">правил</a>.<br>
        Если вы считаете, что произошла ошибка – <a href="/feedback">напишите нам</a>.
HTML;
                break;
        case Anketa::DISALLOW_MESSAGE_CLONE:
            $msg = Yii::app()->user->me->gender == Anketa::GENDER_MAN ?
<<<HTML
Переписка отключена т.к. ваша анкета определена как повторная. Ранее с вашего компьютера уже пользовались другой анкетой.<br>
Подключите <a href="/profile/premium">премиум-аккаунт</a> чтобы активировать переписку.
HTML
:
<<<HTML
Переписка отключена т.к. ваша анкета определена как повторная. Ранее с вашего компьютера уже пользовались другой анкетой.<br>
Чтобы включить переписку сделайте <a href="/profile/up">поднятие анкеты</a>.
HTML;
                break;
        case Anketa::DISALLOW_MESSAGE_IGNORE_I:
            $msg = <<<HTML
            Вы добавили вашего собеседника в «черный список»
HTML;
            break;
        case Anketa::DISALLOW_MESSAGE_IGNORE_ME:
            $msg = <<<HTML
            Ваш собеседник не хочет получать ваши сообщения.
HTML;
                break;
    }
?>
<?php if (isset($msg)) echo $msg ;?>

<?php $this->endWidget(); ?>

</div><!-- form -->
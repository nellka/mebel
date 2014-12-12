<?php  /** @var Anketa $me */

$me = Yii::app()->user->me;
$disallowMessage = $me->disallowMessageTo($me);
?>
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'request-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <h2>Оставить заявку </h2>
        <?php
        if (!$model->isNewRecord) echo "<p class=green>Заявка размещена до " . date('H:i d.m.Y', $model->time_end) . "</p>";
        else echo "<p class='pink red'>Заявка сейчас не активна</p>";
        ?>
        Ваше сообщение увидят все посетители из Вашего города на сайте<br/>
        <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'text'); ?>
    </div>

    <div class="row checkbox" style="vertical-align: middle;">
        <?php echo $form->checkBox($model,'isvisible',array('style'=>'vertical-align:middle;')); ?> <label style="display:inline;font-weight: normal; vertical-align: middle;" for="Request_isvisible"> показывать заявку</label>
        <?php echo $form->error($model,'isvisible'); ?>
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
Возможность переписки  <span class="pink">отключена</span>. <br>
Для возможности писать необходимо приобрести <a href="/profile/premium" class="orange">премиум-аккаунт</a>
HTML;
            break;
        case Anketa::DISALLOW_MESSAGE_WOMAN2WOMAN:
            $msg = <<<HTML
Возможность переписки * по умолчанию  <span class="pink">отключена</span>.<br>
Для включения переписки подключите <a href="/profile/premium" class="orange">премиум-аккаунт</a>.
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
//        case Anketa::DISALLOW_MESSAGE_INACTIVE:
//            $msg = <<<HTML
//        Ваша анкета <span class="red pink">не активирована</span>, возможность переписки <span class="red pink">отключена</span>.
//        <br/><a href="/profile/activate">Активируйте анкету</a>.
//HTML;
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
Чтобы включить переписку <a href="/profile/unblock">разблокируйте анкету</a>.
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
        case Anketa::DISALLOW_MESSAGE_BUG_1:
            $msg = <<<HTML
            Баг поправили. <a href="/profile/premium">Денег на месяц закинули</a>. Удачи в поисках.<br/>
            Администрация сервиса.
HTML;
            break;
//        case Anketa::DISALLOW_MESSAGE_LOCK_MAN:
//            $msg = <<<HTML
//Обмен контактами возможен только после подключения <a href='/profile/premium'>премиум-аккаунта</a>.<br>
//Переписка с собеседником <b>{$anketa->publicName}</b> отключена.<br>
//Подключите <a href="/profile/premium">премиум-аккаунт</a> для снятия всех ограничений.
//HTML;
//            break;
//        case Anketa::DISALLOW_MESSAGE_LOCK_WOMAN:
//            $msg = <<<HTML
//
//HTML;
            break;


    }
?>
    <?php if (isset($msg)) echo $msg ;?>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Оставить заявку' : 'Изменить текст заявки', array('disabled'=>0!=$disallowMessage)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
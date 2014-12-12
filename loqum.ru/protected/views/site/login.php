<?php
$this->pageTitle='Как войти';
$this->breadcrumbs=array(
	'Вход',
);
?>

<h1>Вход</h1>

<?php /* if (!empty($_POST)) { ?>

<div class="flash-notice">
    <b>Уважаемые пользователи!</b><br><br>
    Вечером 16.03.2012 на сервере произошёл технический сбой.
    Нам удалось восстановить большую часть информации, однако часть данных безвозвратно утеряна.<br>
    Если Вы не можете войти под своими учётными данными - попробуйте пройти регистрацию заново.
    Если регистрация прошла успешно, к сожалению, Вашу анкету восстановить не удалось.<br><br>
    По результатам инцидента приняты меры, чтобы в дальнейшем исключить возможность таких последствий<br>
    Приносим извинения.
</div>
<?php } */ ?>

<p>Войдите под своим именем и паролем:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('onchange'=>"",'encode' => false,)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
    <div class="row">
       Нет логина? <?php echo CHtml::link('Зарегистрироваться', array('register/register'));?> |
        <?php echo CHtml::link('Забыли пароль?', array('register/remember'));?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Войти'); ?>
	</div>


<?php $this->endWidget(); ?>
</div><!-- form -->

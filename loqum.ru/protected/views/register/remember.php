<?php
$this->breadcrumbs=array(
	'Регистрация'=>array('/register'),
	'Восстановление пароля',
);?>
<h1>Восстановление пароля</h1>
<?php if (Yii::app()->user->hasFlash('remember')) { ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('registered'); ?>
        <p> На Ваш почтовый ящик было отправлено письмо с информацией о восстановлении пароля.<br/>
             <?php echo CHtml::link('Перейти к форме входа', array('/site/login'))?></p>
    </div>
<?php } else { ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'anketa-register-form',
	'enableAjaxValidation'=>false,
));/** @var $form CActiveForm */ ?>

	<p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения</p>

	<div style="float:none;"><?php echo  $form->errorSummary($model); ?></div>
    <div class="row">
   		<?php echo $form->labelEx($model,'email'); ?>
   		<?php echo $form->textField($model,'email'); ?>
   		<?php echo $form->error($model,'email'); ?>
   	</div>
    <?php if(CCaptcha::checkRequirements()): ?>
   	<div class="row">
   		<?php echo $form->labelEx($model,'verifyCode'); ?>
        <?php echo $form->textField($model,'verifyCode'); ?>

   		<?php $this->widget('CCaptcha'); ?>

   		<div class="hint">
               Для подтверждения вашей "человечности", введите, пожалуйста, символы, изображенные на рисунке.
   		<br/><br/>Регистр значения не имеет.</div>
   		<?php echo $form->error($model,'verifyCode'); ?>
   	</div>
   	<?php endif; ?>
    <div class="row buttons">
   		<?php echo CHtml::submitButton('Сбросить пароль'); ?>
   	</div>

   <?php $this->endWidget(); ?>
</div>
<? } ?>
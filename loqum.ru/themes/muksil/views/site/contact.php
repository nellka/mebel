<?php
$this->pageTitle='Обратная связь';
$this->breadcrumbs=array(
	'Обратная связь',
);
?>

<h1>Обратная связь</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
Напишите <?= CHtml::link('администратору',array('anketa/view','id'=>503894)) ?>  или заполните форму:
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); /** @var $form CActiveForm */?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
    <div class="row">
   		<?php echo $form->labelEx($model,'departament'); ?>
   		<?php echo $form->dropDownList($model,'departament',ContactForm::getDepartments(),array('empty'=>'Выберите отдел...')); ?>
   		<?php echo $form->error($model,'departament'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
        <?php echo $form->textField($model,'verifyCode',array('style'=>'float:left;margin-right:10px;')); ?>
        <div class="hint">Введите символы, изображенные на рисунке.
            <br/>Регистр значения не имеет.</div>
        <div class="vmiddle">
            <?php $this->widget('CCaptcha'); ?>
		</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php  echo CHtml::submitButton('Отправить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
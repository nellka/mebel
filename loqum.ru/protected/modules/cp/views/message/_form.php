<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_from'); ?>
		<?php echo $form->textField($model,'id_from',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'id_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_to'); ?>
		<?php echo $form->textField($model,'id_to',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'id_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datestamp'); ?>
		<?php echo $form->textField($model,'datestamp',array('size'=>11,'maxlength'=>11,'default'=>time())); ?>
		<?php echo $form->error($model,'datestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'viewed'); ?>
		<?php echo $form->textField($model,'viewed'); ?>
		<?php echo $form->error($model,'viewed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
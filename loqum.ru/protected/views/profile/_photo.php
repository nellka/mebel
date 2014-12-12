<?php
$mainphoto = $user->mainphoto;
$this->breadcrumbs=array(
	'Профиль'=>array('/profile'),
	'Мои фото'=>array('/profile/photos'),
	'Загрузить',
);?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'photo-photo-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); /** @var $form CActiveForm
 * @var $model Photo
 */ ?>

	<p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<div><?php echo $form->errorSummary($model); ?></div>
<?php if ($model->isNewRecord) { ?>
    <div class="row">
   		<?php echo $form->labelEx($model,'file'); ?>
   		<?php echo $form->fileField($model,'file',array('maxsize'=>8000)); ?>  &nbsp; (не больше 8Мб, Аватары запрещены)
   		<?php echo $form->error($model,'file'); ?>
   	</div>
<? } ?>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'intim'); ?>
		<?php echo $form->checkBox($model,'intim'); ?>
		<?php echo $form->error($model,'intim'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton('Добавить фотографию'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
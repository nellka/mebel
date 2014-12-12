<?php $this->renderPartial('_menu'); ?>
<?php
$this->breadcrumbs = array(
    'Профиль' => array('/profile'),
    'Сменить пароль',
);?>
<h1>Сменить пароль</h1>
<?php $this->renderPartial('_flash'); ?>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'anketa-changepassword-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'oldPassword'); ?>
        <?php echo $form->passwordField($model, 'oldPassword', array('value' => '')); ?>
        <?php echo $form->error($model, 'oldPassword'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'verifyPassword'); ?>
        <?php echo $form->passwordField($model, 'verifyPassword'); ?>
        <?php echo $form->error($model, 'verifyPassword'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php // print_r ( Yii::app()->user->getState('AnketaFingerprint'));?>
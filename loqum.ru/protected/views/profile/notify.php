<?php $this->renderPartial('_menu'); ?>
<?php
$this->breadcrumbs = array(
    'Профиль' => array('/profile'),
    'Настройка уведомлений',
);?>
<h1>Настройка уведомлений</h1>
<?php $this->renderPartial('_flash'); ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'anketa-notify-form',
    'enableAjaxValidation' => false,
)); /** @var $form CActiveForm */ ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'n_vwd'); ?>
        <?php echo $form->checkBox($model, 'n_vwd'); ?>
        <?php echo $form->error($model, 'n_vwd'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'n_msg'); ?>
        <?php echo $form->checkBox($model, 'n_msg'); ?>
        <?php echo $form->error($model, 'n_msg'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
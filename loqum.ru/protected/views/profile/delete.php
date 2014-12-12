<?php
$mainphoto = $user->mainphoto;
$this->renderPartial('_menu');
$this->breadcrumbs=array(
    'Профиль'=>array('/profile'),
    'Удалить профиль',
);?>
<h1>Удалить профиль</h1>

<div class="form">
<p class="pink">Вы действительно хотите удалить профиль?</p>
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'photo-photo-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onsubmit'=>"js:return confirm('Вся информация будет удалена БЕЗВОЗВРАТНО. Продолжить?')",
    ),
)); /** @var $form CActiveForm
 * @var $model Anketa
 */ ?>
    <div class="row">
        <?php echo $form->labelEx($model,'oldPassword'); ?>
        <?php echo $form->passwordField($model,'oldPassword',array('value'=>'')); ?>
        <?php echo $form->error($model,'oldPassword'); ?>
    </div>

<div>
    <p class="red bold"><b>Важно!</b></p>

<p>    Если вы решите в будущем вернуться и создать новую анкету – она будет <span class="red">«платной»</span>. Сайт попросит для женских анкет –
    оплаты «поднятие анкеты», для мужских – «оплата премиум-аккаунта». До этих оплат анкета не будет участвовать <span class="red">в
    поиске</span> и будет отключена вся <span class="red">переписка</span>.
</p>
</div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Удалить'); ?>
    </div>

<?php $this->endWidget();?>
</div>

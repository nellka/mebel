<?php $this->pageTitle = 'Регистрация'; ?>
<h1>Регистрация на Loqum.ru – знакомства для геев</h1>
<?php if(Yii::app()->user->hasFlash('registered')): ?>
	<div class="flash-success">
		<?php echo Yii::app()->user->getFlash('registered'); ?>
        <p> Вы можете <?php echo CHtml::link('войти',array('/site/login'))?>, указав email и пароль</p>
	</div>
<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'anketa-register-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
//    'clientOptions' => array(
//        'validateOnSubmit' => false,
//    ),
));/** @var $form CActiveForm */ ?>

	<p class="note">Только для совершеннолетних!</p>
	<p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения</p>

	<div style="float:none;"><?php echo  $form->errorSummary($model); ?></div>
    <div class="row">
   		<?php echo $form->labelEx($model,'email'); ?>
   		<?php echo $form->textField($model,'email'); ?>
   		<?php echo $form->error($model,'email'); ?>
   	</div>
    <div class="row">
   		<?php echo $form->labelEx($model,'password'); ?>
   		<?php echo $form->passwordField($model,'password'); ?>
   		<?php echo $form->error($model,'password'); ?>
   	</div>
    <div class="row">
   		<?php echo $form->labelEx($model,'verifyPassword'); ?>
   		<?php echo $form->passwordField($model,'verifyPassword'); ?>
   		<?php echo $form->error($model,'verifyPassword'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

<?php if (Yii::app()->user->hasState('registerPhoto')) { ?>
<div class="row">
<?php echo Chtml::image($model->getRegisterPhotoPath(),'Изображение',array('id'=>'registerPhoto')) ?><br clear="all"/>
<?php echo CHtml::link('Удалить изображение',array('deletePhoto'),array('confirm'=>'Удалить?')) ?>
<?=$form->checkBox($model,'intimPhoto')?> Интим
</div>
<?php } else { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
		<?php echo $form->fileField($model,'file'); ?> &nbsp; <?=$form->checkBox($model,'intimPhoto')?> Интим <!-- (не больше 8Мб) -->
		<?php echo $form->error($model,'file'); ?>
	</div>
<?php } ?>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
        <?php echo $form->radioButtonList($model,'gender',Anketa::$getGenders,array('empty'=>'Надо выбрать',)); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>
*/ ?>

    <div class="row">
   		<?php echo $form->labelEx($model,'birthday'); ?>
   		<?php// echo $form->textField($model,'birthday',array('size'=>7)); ?>

        <?php
        if (1) {//83.149.9.137
            echo '<div id="anketa-register-birthday" class="birthDay">';
            $months = array(1 => 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
            $days = range(1, 31);
            $days = array_combine($days, $days);
            $years = range(1950, 2000);
            $years = array_combine($years, $years);
            echo $form->dropDownList($model,'birthDay',$days,array('empty'=>'День'));
            echo $form->dropDownList($model,'birthMonth',$months,array('empty'=>'Месяц'));
            echo $form->dropDownList($model,'birthYear',$years,array('empty'=>'Год'));
            echo '<br clear="all"/></div>';
        } else {
        ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(

            'attribute'=>'birthday',
            'model'=>$model,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                //              'dateFormat'=>'dd.mm.yy', // <== формат
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'stayOpen' => 'true',
                'yearRange' => "1950:".(date('Y')-17),
                'onSelect' => 'js:function(dateText, inst) {$(inst).attr("title",parseInt(dateText));$(this).datepicker("setDate",dateText);return 0;}',
                'onChangeMonthYear' => 'js:function(year, month, inst) {$(this).datepicker("setDate",($(inst).attr("title")?$(inst).attr("title"):"01")+"."+month+"."+year);}',
                //            'beforeShow'=> 'js:function(dateText, inst) {inst.inline = false; }',
                //              'beforeShowDay'=> 'js:function(date) {if ($("#birthday").hasClass("hasDatepicker")) $("#birthday").datepicker("option","inline",false);return [true,"",""]; }',
    //                'onClose'=> 'js:function(dateText, inst) {$(this).datepicker( "show" );return false; }',
                'closeText' => 'Готово',
                'showButtonPanel' => 'true',
                'defaultDate' => '-18y',
            ), //*/
        //    'i18nScriptFile'=>'jquery.ui.datepicker-ru.js',
            'language'=>'ru',
            'htmlOptions'=>array(
                //'style'=>'height:20px;',
                'id'=>'birthday',
            ),
        ));
        ?>
<? } ?>
        <?php echo $form->error($model,'birthday'); ?>
   	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'heigth'); ?>
		<?php echo $form->textField($model,'heigth',array('size'=>3)); ?>
		<?php echo $form->error($model,'heigth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>3)); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>
    <? /*

	<div class="row">
		<?php echo $form->labelEx($model,'marital_status'); ?>
		<?php echo $form->textField($model,'marital_status'); ?>
		<?php echo $form->error($model,'marital_status'); ?>
	</div>
*/ ?>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'sexual_orientation'); ?>
		<?php echo $form->dropDownList($model,'sexual_orientation',Anketa::$getSexOr,array('empty'=>'Выбрать..')); ?>
		<?php echo $form->error($model,'sexual_orientation'); ?>
	</div>
*/ ?>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
 */ ?>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
        <?php echo $form->dropDownList($model,'location',Anketa::getCities(), array('empty'=>'выберите город')) ?>
		<?php echo $form->error($model,'location'); ?>
	</div>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'icq'); ?>
		<?php echo $form->textField($model,'icq'); ?>
		<?php echo $form->error($model,'icq'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone'); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>
*/ ?>
<div class="row">
    <?php echo $form->labelEx($model,'find_from'); ?>
    <span style="float:left;line-height:25px"> от:&nbsp;&nbsp; </span> <?php echo $form->textField($model,'find_from',array('size'=>3)); ?>
    <span style="float:left;line-height:25px;">&nbsp;&nbsp;&nbsp;&nbsp; до:&nbsp;&nbsp; </span> <?php echo $form->textField($model,'find_to',array('size'=>3)); ?>
    <?php echo $form->error($model,'find_from'); ?>
    <?php echo $form->error($model,'find_to'); ?>
</div>

    <div class="row">
        <?php $model->description = explode ("\n",$model->description); ?>
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->checkBoxList($model,'description',array_combine(Anketa::goalsArray(),Anketa::goalsArray())); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <?php $model->sex_role = explode (",",$model->sex_role); ?>
    <div class="row"><br>
        <?php echo $form->labelEx($model,'sex_role'); ?>
        <?php echo $form->checkBoxList($model,'sex_role',Anketa::$getSexRoles); ?>
        <?php echo $form->error($model,'sex_role'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'about'); ?>
        <?php echo $form->textArea($model,'about',array('rows'=>5,'cols'=>40)); ?>
        <?php echo $form->error($model,'about'); ?>
    </div>

    <div class="row vmiddle" style="display:none;">
        <?php echo $form->checkBox($model,'agree',array('checked'=>'checked')); ?>
        <span class="vmiddle">&nbsp; Я прочитал и согласен с <a href="/oferta" target="_blank">договором оферты</a>
            и <a href="/rules" target="_blank">правилами сайта</a></span>
        <?php echo $form->error($model,'agree'); ?>
    </div>

    <?php if (0 && $model->isNewRecord) { ?>
        <div class="row">
       		<?php echo $form->labelEx($model,'file'); ?>
       		<?php echo $form->fileField($model,'file',array('maxsize'=>6000)); ?>
       		<?php echo $form->error($model,'file'); ?>
       	</div>
    <? } ?>
    
    <?php if(CCaptcha::checkRequirements()): ?>
   	<div class="row">
   		<?php echo $form->labelEx($model,'verifyCode'); ?>
        <?php echo $form->textField($model,'verifyCode'); ?>

   		<?php $this->widget('CCaptcha'); ?>
           <?php echo $form->error($model,'verifyCode'); ?>
   		<div class="hint">
               Для подтверждения вашей "человечности", введите, пожалуйста, символы, изображенные на рисунке.
   		<br/>Регистр значения не имеет.</div>

   	</div>
   	<?php endif; ?>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>

<?php $this->endWidget(); ?>
<script>
    $("label[for=Anketa_gender_1]").css('color','red');
</script>

</div><!-- form -->
<?php endif; ?>
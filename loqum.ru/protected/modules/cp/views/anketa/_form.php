<div style="float:right;width:150px;">

    <?php if (1 & $model->status_bad) { ?>
        <form method="post" action="/cp/anketa/setbad">
            <span class="brown status_bad"><?php echo Anketa::$bad_statuses[$model->status_bad] ?></span>
            <?php echo CHtml::submitButton(Anketa::$bad_statuses_reset[$model->status_bad],array('name'=>'unbad')); ?>
            <?php echo CHtml::hiddenField('id',$model->id); ?>
        </form>
        <?php } else { ?>
        <span class="brown status_bad"><?php echo Anketa::$bad_statuses[$model->status_bad] ?></span>
        <form method="post" action="/cp/anketa/setbad">
            <?php echo CHtml::submitButton('Клон!',array('name'=>'setclone')); ?>
            <?php echo CHtml::submitButton('Бан!',array('name'=>'setban')); ?>
            <?php echo CHtml::hiddenField('id',$model->id); ?>
        </form>
        <?php } ?>
    <br/>
    <?php if ($_SERVER['REMOTE_ADDR']=='89.169.186.44' && $model->getTop()) { ?>
    <form method="post" action="/cp/anketa/untop" onsubmit="return confirm('Действительно отключить ТОП?');">
        <?php echo CHtml::hiddenField('id',$model->id); ?>
        <input type="submit" name="untop" value="Отключить TOP"/>
    </form>
    <?php } ?>
    <form method="post" action="/cp/anketa/addBalance/<?=$model->id?>">
        <p>Баланс: <b><?=  $model->balance ?></b> руб.</p>
        <input type="text" size="4" name="balance" value="100"/> руб.
        <input type="submit" class="blue-button" value="Пополнить" />
    </form>
    <hr>
    <form method="post" action="/cp/anketa/addContacts/<?=$model->id?>">
        <p>Контактов: <b><?=  $model->contact_count ?></b> шт.</p>
        <input type="text" size="4" name="contacts" value="10"/> шт.
        <input type="submit" class="blue-button" value="Пополнить" />
    </form>
</div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'anketa-form',
	'enableAjaxValidation'=>false,
)); /** @var $form CActiveForm */?>

	<p class="note">Поля, помеченные <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
   		<?php echo $form->labelEx($model,'name'); ?>
   		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
   		<?php echo $form->error($model,'name'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>55,'maxlength'=>55)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>33,'maxlength'=>33)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
*/ ?>

    <div class="row">
   		<?php echo $form->labelEx($model,'gender'); ?>
        <?php echo $form->DropDownList($model,'gender',Anketa::$getGenders,array('empty'=>'Надо выбрать')); ?>
   		<?php echo $form->error($model,'gender'); ?>
   	</div>

    <div class="row">
        <?php if (strpos($model->birthday,'-')) $model->birthday = anketa::dateconvert($model->birthday) ?>
   		<?php echo $form->labelEx($model,'birthday'); ?>
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
                'onSelect' => 'js:function(dateText, inst) {$(inst).attr("title",parseInt(dateText));$(this).datepicker("setDate",dateText);return fаlse;}',
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
   		<?php echo $form->error($model,'birthday'); ?>
   	</div>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php echo $form->textField($model,'age'); ?>
		<?php echo $form->error($model,'age'); ?>
	</div>
*/ ?>
<? /**	<div class="row">
		<?php echo $form->labelEx($model,'zodiac'); ?>
		<?php echo $form->textField($model,'zodiac'); ?>
		<?php echo $form->error($model,'zodiac'); ?>
	</div>*/ ?>

	<div class="row">
		<?php echo $form->labelEx($model,'heigth'); ?>
		<?php echo $form->textField($model,'heigth'); ?>
		<?php echo $form->error($model,'heigth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight'); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'about'); ?>
		<?php echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'about'); ?>
	</div>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'marital_status'); ?>
		<?php echo $form->textField($model,'marital_status',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'marital_status'); ?>
	</div>*/ ?>

    <div class="row">
   		<?php echo $form->labelEx($model,'sexual_orientation'); ?>
           <?php echo $form->dropDownList($model,'sexual_orientation',Anketa::$getSexOr,array('empty'=>'Выбрать..')); ?>
   		<?php echo $form->error($model,'sexual_orientation'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'icq'); ?>
		<?php echo $form->textField($model,'icq',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'icq'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

<? /*	<div class="row">
		<?php echo $form->labelEx($model,'mainphoto'); ?>
		<?php echo $form->textField($model,'mainphoto',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mainphoto'); ?>
	</div>*/ ?>

<? /*	<div class="row">
		<?php echo $form->labelEx($model,'last_visit'); ?>
		<?php echo $form->textField($model,'last_visit'); ?>
		<?php echo $form->error($model,'last_visit'); ?>
	</div>*/?>

	<div class="row">
		<?php echo $form->labelEx($model,'isdeleted'); ?>
		<?php echo $form->checkBox($model,'isdeleted'); ?>
		<?php echo $form->error($model,'isdeleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isinactive'); ?>
		<?php echo $form->checkBox($model,'isinactive'); ?>
		<?php echo $form->error($model,'isinactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать ' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
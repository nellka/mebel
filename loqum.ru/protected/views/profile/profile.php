<?php $this->pageTitle='Профиль - '.Yii::app()->name; ?>
<?php $this->renderPartial('_menu'); ?>
<?php
$this->breadcrumbs=array(
	'Профиль'=>array('/profile'),
);?>

<?php $this->renderPartial('_flash'); ?>

<h1>Профиль</h1>

<?php Yii::app()->clientScript->registerPackage('lightbox'); ?>

    <?php $anketa = $model; ?>

<?php $this->renderPartial('_serviceup',array('anketa'=>$model));?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'anketa-_profile-form',
    'enableAjaxValidation'=>false,
)); /** @var $form CActiveForm */ ?>

    <br/>
    <? /* // объявление в профиле //* / ?>
    <div class="flash-success" style="margin-right:400px;">
 С 15:00 до 20:00 23 февраля  возможны перебои в работе сервера.
    </div>
<? //* */ ?>
    <p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php  if(empty($model->email)) { ?>
    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    <?php } ?>
    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
<? /*
    <div class="row">
        <?php echo $form->labelEx($model,'gender'); ?>
        <?php echo $form->DropDownList($model,'gender',Anketa::$getGenders,array('empty'=>'Надо выбрать')); ?>
        <?php echo $form->error($model,'gender'); ?>
    </div>
*/ ?>
    <div class="row">
        <?php if (strpos($model->birthday,'-')) $model->birthday = anketa::dateconvert($model->birthday) ?>
        <?php echo $form->labelEx($model,'birthday'); ?>

        <?php
        if (1) {//83.149.9.137
            echo '<div id="profile-birthday" class="birthDay">';
            $months = array(1 => 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
            $days = range(1, 31);
            $days = array_combine($days, $days);
            $years = range(1950, 2000);
            $years = array_combine($years, $years);
            echo $form->dropDownList($model,'birthDay',$days,array('empty'=>'День'));
            echo $form->dropDownList($model,'birthMonth',$months,array('empty'=>'Месяц'));
            echo $form->dropDownList($model,'birthYear',$years,array('empty'=>'Год'));
            echo '<br clear="left"/></div>';
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
        <?php echo $form->textField($model,'heigth'); ?>
        <?php echo $form->error($model,'heigth'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'weight'); ?>
        <?php echo $form->textField($model,'weight'); ?>
        <?php echo $form->error($model,'weight'); ?>
    </div>
<? /*
    <div class="row">
        <?php echo $form->labelEx($model,'sexual_orientation'); ?>
        <?php echo $form->dropDownList($model,'sexual_orientation',Anketa::$getSexOr,array('empty'=>'Выбрать..')); ?>
        <?php echo $form->error($model,'sexual_orientation'); ?>
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
        <?php echo $form->labelEx($model,'isinactive'); ?>
        <?php echo $form->checkBox($model,'isinactive'); ?>
        <?php echo $form->error($model,'isinactive'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'find_from'); ?>
        <span style="float:none;line-height:25px"> от:&nbsp;&nbsp; </span> <?php echo $form->textField($model,'find_from',array('size'=>3)); ?>
        <span style="float:none;line-height:25px;">&nbsp;&nbsp;&nbsp;&nbsp; до:&nbsp;&nbsp; </span> <?php echo $form->textField($model,'find_to',array('size'=>3)); ?>
        <?php echo $form->error($model,'find_from'); ?>
        <?php echo $form->error($model,'find_to'); ?>
    </div>

    <div class="row">
<? /*
        <?php $model->description = preg_split ("$",$model->description);
        foreach($model->description as $k=>$v) {
            $model->description[$k] = preg_replace( "/(^\s+)|(\s+$)/us", "", $v );
            if (empty($model->description[$k])) unset($model->description[$k]);
        }

        if (Yii::app()->user->id ==4932797 ) print_r ($model->description);
        ?>

  */ ?>

        <?php $model->description = explode ("\n",$model->description); ?>
<?php   // преобразование целей знакомства от старого формата к новому
        //if ($_SERVER['REMOTE_ADDR']=='89.169.186.44') {}
        $description =  $model->description;
        foreach($description as $k=>$v) {
            $description[$k] = trim($v);
            if (empty($description[$k])) unset($description[$k]);
            $model->description = $description;
        }
        //if ($_SERVER['REMOTE_ADDR']=='89.169.186.44') {}
        ?>
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->checkBoxList($model,'description',array_combine(Anketa::goalsArray(),Anketa::goalsArray())); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <?php $model->sex_role = explode (",",$model->sex_role); ?>
    <div class="row">
        <?php echo $form->labelEx($model,'sex_role'); ?>
        <?php echo $form->checkBoxList($model,'sex_role',Anketa::$getSexRoles); ?>
        <?php echo $form->error($model,'sex_role'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'about'); ?>
        <?php echo $form->textArea($model,'about',array('rows'=>'10','cols'=>80,)); ?>
        <?php echo $form->error($model,'about'); ?>
    </div>




    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function(){
        set2biglightbox();
    });


    function rescroll() {
        // $('#big2foto.photos').each( function(index,el) {
        //var lastLi[index] = ul.find('li:last-child');
        // });
        var div1 = $('div.photos').eq(0),
                div2 = $('div.photos').eq(1),
                ulPadding = 10;


        /*div1.css('border','solid 1px #ccc');*/
        var div1Width = div1.width();
        var div2Width = div2.width();

        //Remove scrollbars
        //div.css({overflow: 'hidden'});

        //Find last image container
        var lastLi1 = div1.find('a:last-child img');
        var lastLi2 = div2.find('a:last-child img');

        //When user move mouse over menu

        div1.mousemove(function(e){
            if (lastLi1.data()==null) return;
            var ulWidth = lastLi1[0].offsetLeft + lastLi1.outerWidth() + ulPadding;
            var left = (e.pageX - div1.offset().left) * (ulWidth-div1Width) / div1Width;
            div1.scrollLeft(left);
        })
        div2.mousemove(function(e){
            if (lastLi2.data()==null) return;
            var ulWidth = lastLi2[0].offsetLeft + lastLi2.outerWidth() + ulPadding;
            var left = (e.pageX - div2.offset().left) * (ulWidth-div2Width) / div2Width;
            div2.scrollLeft(left);
        })
    }
    var leftlast;
    var rightlast;
    function reimage () {
        set2biglightbox();
    }

    $(document).ready (function() {
        rescroll() ;
        reimage ();
    });

</script>
<!--p align="right"><a class="gray" href="/profile/delete">Удалить анкету</a></p-->
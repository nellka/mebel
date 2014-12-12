<?php

if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) {
    function mb_ucfirst($string,$enc='utf-8') {
        $string = mb_strtoupper(mb_substr($string, 0, 1, $enc),$enc) . mb_substr($string, 1,100,$enc);
        return $string;
    }
}

$desc1 = explode("\n",$model->description);
$desc1 = array_intersect($desc1,array('ищу спонсора','стану спонсором'));
$desc1 = implode (' ',$desc1);
setlocale(LC_ALL, "ru_RU.UTF-8");
if ($desc1) $desc1 = mb_ucfirst ($desc1,'utf-8') . '.';

$pageTitle = '';
if (strpos($model->description,'дружба'))
    $pageTitle = $model->name.'  Гей знакомства - '.$model->location;
else if (strpos($model->description,'постоянные'))
    $pageTitle = 'Сайт гей знакомств. '.$model->name.'.';
else
    $pageTitle = $model->name. '. Гей ищет гея, сайт гей объявлений.';

$this->pageTitle = $pageTitle;
if ($model->about) {
    $about = trim($model->about);
    $pos = min(mb_strpos($about,"\n",'utf-8'),mb_strpos($about,".",'utf-8'));
    if ($pos <=0 ) $pos = 250;
    $about = mb_substr($about,0,$pos,'utf-8');
    if ($about)
        $this->pageTitle .= '. '. $about;//strpos($this->pageTitle,"\n")
    $this->pageTitle = mb_substr($this->pageTitle,0,120,'utf-8');
}
//' - просмотр анкеты';
?>
<?php Yii::app()->clientScript->registerPackage('lightbox'); ?>
<div style="position:relative;">
<div style="float:left; width:350px;">
    <table id="big2foto" width="350" align="center" style="text-align:center;">
        <tr>
            <td align="center">
                <?php $this->renderPartial('/anketa/_simplebig',array('model'=>$model,'hidebuttons'=>true)); ?>
            </td>
        </tr>
    </table>
</div>


<h1><?php echo $model->name; ?></h1>
<div>
    <p><?=$model->countryCity;?></p>
    <p><? echo "<span>", $model->age, ' ', Yii::t('app', 'год|года|лет|года', $model->age) . "</span>, ".Anketa::$getZodiac[$model->zodiac]; ?></p>
    <p><span class="blue">Рост</span><br/><?=$model->heigth?></p>
    <p><span class="blue">Вес</span><br/><?=$model->weight?></p>
<?php if ($model->find_from) { ?><p><span class="blue">Ищу парня </span><br/>от <?=$model->find_from.' до '.$model->find_to;?></p><?php  } ?>
<?php if ($model->sex_role) {
        $model->sex_role = explode(',',$model->sex_role);
        echo "<p><span class='blue'>Роль в сексе</span><br>";
        foreach ($model->sex_role as $srole)
            echo $model::$getSexRoles[$srole],'<br>';
    echo "</p>";
}   ?>

    <p><span class="blue">Цели знакомства</span><br/><?=$model->description?nl2br($model->description):'Не указаны'?></p>
    <p><span class="blue">О себе</span><br/><?=$model->about?(nl2br(CHtml::encode($model->about))):'Информация отсутствует'?></p>
</div>

<script>
    var leftlast;
    var rightlast;
    function reimage () {
        set2biglightbox();
    }
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

    $(document).ready (function() {
        rescroll() ;
        reimage ();
    });
</script>
    <div id="last_visit">
<?php echo $model->getLastVisitInfo(); ?>
<? /*
        <?php if ($model->isOnline()) { ?>
        <span class="online">
    <?php echo CHtml::image('/images/status_online.png') ?> Сейчас на сайте
    </span>
        <? } else { ?>
        <span class="offline">
    <?php echo CHtml::image('/images/status_offline.png') ?>
            <?php if ($model->last_visit) { ?>
            Был<?= $model->gender ? '' : 'а' ?> на сайте
            <?= str_replace('г.,', 'в', Yii::app()->dateFormatter->formatDateTime($model->last_visit, 'long', 'short')); ?>
        <?php } else { ?>
            Нет на сайте
        <? } ?>
    </span>
        <? } ?>
  */ ?>
        <br/>
        <?php
        //if ($mode=='welike') // ссылка на переписку для взаимных
        if(1)
        if (Yii::app()->user->isGuest || Yii::app()->user->id != $model->id)
            echo CHtml::link(
                CHtml::image(Yii::app()->baseUrl . '/images/message.png', 'Написать сообщение',array('style'=>'vertical-align:middle;')).'Написать сообщение',
                array('anketa/messages/', 'id' => $model->id),
                array('style'=>'vertical-align:middle;')
            );
        //else echo 'чтобы связаться с пользователем следует оплатить ...';
        ?>

        <?php if(Yii::app()->user->hasFlash('contact')): ?>

            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('contact'); ?>
            </div>

            <?php else: ?>
        <? if (0) { //DIRECT MODERATION ?>
            <br/><a href="javascript:;" onclick="$('#messageForm').toggle()">Написать сообщение</a>
            <p>
                Вы можете связаться с пользователем сайта
            </p>

            <div class="form" id="messageForm" style="display:none;">

                <?php
                $model = $contactForm;
                $form=$this->beginWidget('CActiveForm', array(
                'id'=>'anketa-contact-form',
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
                    <?php echo $form->labelEx($model,'subject'); ?>
                    <?php echo $form->textField($model,'subject',array('size'=>30,'maxlength'=>128)); ?>
                    <?php echo $form->error($model,'subject'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model,'body'); ?>
                    <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>30)); ?>
                    <?php echo $form->error($model,'body'); ?>
                </div>

                <?php if(CCaptcha::checkRequirements()): ?>
                <div class="row">
                    <?php echo $form->labelEx($model,'verifyCode'); ?>
                    <div style="vertical-align:middle">
                        <?php $this->widget('CCaptcha'); ?><br/>
                        <?php echo $form->textField($model,'verifyCode'); ?>
                    </div>
                    <div class="hint">Введите символы, изображенные на рисунке.
                        <br/>Регистр значения не имеет.</div>
                    <?php echo $form->error($model,'verifyCode'); ?>
                </div>
                <?php endif; ?>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Отправить'); ?>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->
<? } ?>
        <div style="clear:both"></div>
            <?php endif; ?>

    </div>
<br clear="all"/>
</div>
<?php
$this->pageTitle = $city->metaTitle?:'Геи '.$city->name. ', знакомства с геями в городе '.$city->name.' - loqum.ru';
$this->metaDescription = 'Знакомства для геев ' . $city->name;
$this->metaKeywords = 'гей знакомства '.$city->name.', знакомства для геев, гей.ру, блю';
$seo_text = $city->seoText ? $city->seoText : "<p>На нашем сайте знакомятся геи города {$city->name}.</p>";

$this->breadcrumbs=array(
    $city->name,
);
echo CHtml::tag('h1',array(),'Геи '.$city->name); ?>

<?php if (Yii::app()->user->isGuest) : ?>
    <div id="addnstat">
        <a href="/register/register"><img id="addpage" src="/images/design/main-add-page.png" alt="Добавить свою страницу. Регистрация бесплатна"/></a>
    </div>

    <?php $model=$LoginForm;?>
    <div id="mainloginform">
        <img src="/images/design/main-enter.png" alt="Вход на сайт" class="mainimage" >
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'action'=>array('site/login'),
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )); ?>

            <div class="row">
                <?php echo $form->labelEx($model,'username'); ?>
                <?php echo $form->textField($model,'username',array('onchange'=>"",'encode' => false,)); ?>
                <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password'); ?>
                <?php echo $form->error($model,'password'); ?>

            </div>

            <div class="row rememberMe">
                <?php echo $form->checkBox($model,'rememberMe'); ?>
                <?php //echo $form->label($model,'rememberMe'); ?> <label>Запомнить</label>
                <?php echo $form->error($model,'rememberMe'); ?>
            </div>
            <div class="row " style="text-align:left;">
                <?php echo CHtml::submitButton('Войти',array('style'=>'margin-right:20px;')); ?>
                <?php echo CHtml::link('Забыли пароль?', array('register/remember'));?>
            </div>


            <?php $this->endWidget(); ?>
        </div><!-- form -->

    </div><!-- mainloginform -->
<?php endif; ?>

<div id="mainsearchform">
    <?php $model = $SearchForm; ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'search-form',
        'method'=>'get',
        'action'=>array('/anketa/search'),
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); /** @var $form CActiveForm */?>
    <table>
        <?php if (0 && Yii::app()->user->isGuest) { ?>
            <tr>
                <td>Я</td>
                <td><?php echo $form->radioButtonList($model,'mygender',Anketa::$getGenders) ?></td>
            </tr>
        <? } ?>
        <tr>
            <td>Возраст</td>
            <td>от <?php echo $form->textField($model,'agefrom',array('size'=>2)) ?> до <?php echo $form->textField($model,'ageto',array('size'=>2)) ?></td>
        </tr>
        <tr>
            <td>Откуда</td>
            <td>
                <?php echo $form->dropDownList($model,'location', Anketa::getCities(), array('empty'=>'выберите город', 'class'=>'mainselect')) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="Найти"/></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?><!-- searchform -->
</div>
<br clear="all"/>
<div style="clear:both"></div>
<div id="man">
    <h1>Наши парни г. <?=$city->name;?></h1>
    <?php $this->renderPartial('/anketa/_list', array('dataProvider' => $manProvider,'itemview'=>'/anketa/_simplemain')); ?>
</div>
<br clear="all"/>
<br/><br/>
<div class="text">
<?= $seo_text;?>
    </div>


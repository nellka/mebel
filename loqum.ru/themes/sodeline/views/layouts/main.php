<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php  $isIndex = '/' == $_SERVER['REQUEST_URI']; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$this->pageTitle;?></title>
    <?php Yii::app()->clientScript->registerPackage('jquery'); ?>
    <!--script type="text/javascript" language="javascript"
            src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script-->
    <link href="<?=Yii::app()->theme->baseUrl;?>/css/add.css" type="text/css" rel="stylesheet"/>
    <link href="<?=Yii::app()->theme->baseUrl;?>/css/template_css.css" type="text/css" rel="stylesheet"/>
    <link href="<?=Yii::app()->theme->baseUrl;?>/css/jqtransform.css" type="text/css" rel="stylesheet"/>

    <link href="<?=Yii::app()->theme->baseUrl;?>/css/jquery.ad-gallery.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/js/jquery.ad-gallery.min.js" ></script>

    <script type="text/javascript" src="/js/jquery.placeholder.min.js"></script>
    <script type="text/javascript" src="/js/jquery.jqtransform.js"></script>

    <script type="text/javascript" src="/js/func.js"></script>

</head>
<body<?if(Yii::app()->params['body_class']) echo ' class="inner-page"' ?>><!-- TODO  class="inner-page" -->
<div class="page">
    <!-- header -->
    <div class="header">
        <div class="hed-top nuclear">
            <a href="/" class="logo"><img src="<?=Yii::app()->theme->baseUrl;?>/images/logo.jpg" alt="На главную"/></a>
            <?php if(!Yii::app()->user->isGuest) : ?>
            <?php if (!Yii::app()->user->isGuest) $this->widget('RightTopWidget'); ?>
            <?php else: ?>
            <div class="slogan">
                <img src="<?=Yii::app()->theme->baseUrl;?>/images/sl.jpg" alt="" />
                <div class="slogan-in">
                    <span class="girls">девушек, ищущих спонсора</span>
                    <span class="boys">и мужчин, достигших успеха</span>
                </div>
            </div>
            <?php endif;?>


        </div>
        <div class="hed-mnu nuclear">
            <?php
            $new = $this->widget('NewMessages',array(),true);
            $this->widget('zii.widgets.CMenu',array(
                'htmlOptions'=>array('class'=>'naw'),
                'id'=>'topMenu',
            'items'=>array(
            array('label'=>'Главная', 'url'=>'/'),
            array('label'=>'Поиск', 'url'=>array('/anketa/search')),
            array('label'=>'Кто смотрел', 'url'=>array('/anketa/visitors'),'visible'=>!Yii::app()->user->isGuest),
            array('label'=>'Профиль', 'url'=>array('/profile/profile'),'visible'=>!Yii::app()->user->isGuest),
            //array('label'=>'Обратная связь', 'url'=>array('/site/contact'),'itemOptions'=>array('class'=>'pink')),
            array('label'=>'Сообщения'.$new
            ,'url'=>array('/anketa/messages'),'itemOptions'=>$new ? array('class'=>'pink'):null,'visible'=>!Yii::app()->user->isGuest),
            array('label'=>'Регистрация', 'url'=>array('/register/register'),'itemOptions'=>array('class'=>'right pink'),'visible'=>Yii::app()->user->isGuest),
            array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
            array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
            )); ?>
        </div>
    </div>
    <!--/ header -->

    <?php //if (!Yii::app()->params['body_class'])
    if ($this->action->id == 'search' || ($this->action->id=='index' && $this->id == 'anketa'))
    $this->renderPartial($isIndex && Yii::app()->user->isGuest ? '//common/_registration_main' : '//common/_registration_inner'); ?>

    <!-- content -->
    <div class="content">
        <?php $this->renderPartial('/common/_top_message'); ?>
        <?php echo $content;?>
    </div>
    <!--/ content -->

    <!-- footer -->
    <div class="footer nuclear">
        <a href="#" class="logo"><img src="<?=Yii::app()->theme->baseUrl;?>/images/f-logo.jpg" alt=""/></a>

        <div class="mdl-f">

            <ul class="f-mnu nuclear">
                <li><a href="/feedback">Обратная связь</a>|</li>
                <?php if (!Yii::app()->user->isGuest) { ?>
                <li><a href="/oferta">Договор оферта</a>|</li>
                <li><a href="/rules">Правила</a>|</li>

                <!--li><a href="#">Контакты</a></li-->
                <?php } ?>
            </ul>

            <span class="copy">© 2008-2013 www.sodeline.ru</span>
        </div>
        <div class="counter">
            <!--LiveInternet counter--><script type="text/javascript"><!--
        document.write("<a href='http://www.liveinternet.ru/click' "+
                "target=_blank><img src='//counter.yadro.ru/hit?t44.2;r"+
                escape(document.referrer)+((typeof(screen)=="undefined")?"":
                ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                        screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                ";"+Math.random()+
                "' alt='' title='LiveInternet' "+
                "border='0' width='31' height='31'><\/a>")
        //--></script><!--/LiveInternet-->
        </div>
    </div>
    <!--/ footer -->
</div>
<?php $this->renderPartial('//common/_fingerprints'); ?>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
    <script type="text/javascript" language="javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="keywords" content="<?=$this->metaKeywords?>" />
    <meta name="description" content="<?=$this->metaDescription?>" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
    <script type="text/javascript" language="javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css?v=0.5" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <? if (Yii::app()->user->role == 'admin') { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css"/>
    <? } ?>
</head>

<body>
<div id="flashcontent"></div>

<div class="container" id="page">

	<div id="header">
        <div id="rtop"><?php /*  if (Yii::app()->user->getId()) {
            $this->widget('NewMessages') ;
            echo ' ', CHtml::link('#'.Yii::app()->user->id,array('anketa/profile'));
}// */?><?php if (!Yii::app()->user->isGuest) $this->widget('RightTopWidget'); ?></div>
        <div id="logo"><a href="/" title="На главную"><img src="/images/logo.jpg" alt="На главную" /></a></div>

	</div><!-- header -->

	<div id="mainmenu">
		<?php
        $new = $this->widget('NewMessages',array(),true);
        $newVisitors = '';
        if (!Yii::app()->user->isGuest) {
            $user = Yii::app()->user->me;
            $newVisitors = $user->getNewVisitors();
            if ($newVisitors) $newVisitors = " ($newVisitors)";
            else $newVisitors = '';
        }
        $newRequests = '';
        if (!Yii::app()->user->isGuest) {
            $me = Yii::app()->user->me;
            if ($newRequests = $me->getNewRequestCount()) {
                $newRequests = " ($newRequests)";
            } else $newRequests = '';
            if ($newRequests == '') $newRequests = '!!';
        }

            $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Главная', 'url'=>'/'),
				array('label'=>'Поиск', 'url'=>array('/anketa/search')),
                array('label' => 'Кто смотрел' . $newVisitors, 'url' => array('/anketa/visitors'),
                    'itemOptions' => $newVisitors ? array('class' => 'pink') : null, 'visible' => !Yii::app()->user->isGuest),
                array('label'=>'Заявки'.$newRequests, 'url'=>array('/profile/request'),
                    'itemOptions' => $newRequests ? array('class' => 'pink') : null, 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Профиль', 'url'=>array('/profile/profile'),'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Сообщения'.$new
                ,'url'=>array('/anketa/messages'),'itemOptions'=>$new ? array('class'=>'pink'):null,'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Регистрация', 'url'=>array('/register/register'),'itemOptions'=>array('class'=>'right pink'),'visible'=>Yii::app()->user->isGuest),
//                array('label'=>'О сайте', 'url'=>array('/site/page','view'=>'about'),'itemOptions'=>array('class'=>'right')),
				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
<?php if (Yii::app()->user->role=='admin') { ?>
    <?php Yii::app()->clientScript->registerScriptFile('/js/admin.js'); ?>
<div id="adminmenu" style="border-top:solid 1px white;">
    <?php $this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Админка', 'url' => array('/cp/')),
        array('label' => 'Анкеты', 'url' => array('/cp/anketa')),
        array('label' => 'Клоны', 'url' => array('/cp/anketa/clones')),
        array('label' => 'Платные', 'url' => array('/cp/anketa/paid')),
        array('label' => 'Призраки', 'url' => array('/cp/anketa/ghosts')),
        array('label' => 'Переписка', 'url' => array('/cp/message')),
        array('label' => 'IP-IP', 'url' => array('/cp/ipRange')),
//        array('label' => 'Сообщения', 'url' => array('/cp/message')),
//        array('label' => 'Статистика', 'url' => array('/cp/tools/stat')),
//        array('label' => 'Сброс куки', 'url' => array('/anketa/resetCookie')),
        array('label' => 'Вход', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
        array('label' => 'Выход (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
    ),
)); ?>
   	</div><!-- mainmenu -->
    <? } ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink'=>'<a href="'. Yii::app()->request->baseUrl.'/">Главная</a>',
		)); ?><!-- breadcrumbs -->
	<?php endif?>
<?php if (!Yii::app()->user->isGuest) {
    $user = Anketa::model()->findByPk(Yii::app()->user->id);
    if (!$user) {
        /*
         * anketa( id, name, last_visit, isdeleted )
SELECT id_from, concat( 'Anketa ', id ) , datestamp, 0
         */
        $user = new Anketa();
        $user->id = Yii::app()->user->id;
        $user->name = 'Anketa '.Yii::app()->user->id;
        $user->last_visit = time();
        $user->isdeleted = 0;
        $user->save(false);
    }

    if ($user && $user->email =='') {
    ?>
<div align="center"><h1><span class="pink"> Система восстановлена после серьёзного сбоя.
    Пожалуйста, проверьте Ваши данные <a href="/profile">в профиле</a>
    и не забудьте <a href="/profile/changePassword">задать новый пароль</a>
</span></h1></div>
<? }} ?>
    <?php  if (!Yii::app()->user->isGuest) : ?>
    <?php if (Yii::app()->user->me->status_bad == Anketa::BAD_STATUS_BAN) { ?>
        <div class="flash-error">
        Аккаунт заблокирован за нарушение <a href="http://test.loqum.ru/rules">правил</a>.<br>
        Если вы считаете, что произошла ошибка – <a href="http://www.loqum.ru/feedback">напишите нам</a>.
        </div>
    <?php } else if (Yii::app()->user->me->status_bad == Anketa::BAD_STATUS_CLONE) { ?>
        <div class="flash-error">
            <?php if (Yii::app()->user->me->gender == Anketa::GENDER_MAN) { ?>
            <?php if (Yii::app()->user->me->balance >= ServiceManager::getPrice(ServiceManager::SERVICE_PREMIUM_SMALL)): ?>
                <p>
                <span class="red">Счет пополнен!</span> <a href="/profile/premium">Нажмите кнопку «Премиум»</a>. Переписка и показы в поиске включатся автоматически
                    <br/>
                </p>
                <?php endif; ?>

            Ваша страница определена как повторная.<br/>
            <?php  if ($clone = Yii::app()->user->me->lastClone) {
                if ($clone->isdeleted)
                    echo 'Ранее с вашего компьютера '.date ('d.m.Y',$clone->first_visit).' создавалась анкета';
                else
                    echo 'Ранее с вашего компьютера создана анкета с e-mail '. preg_replace('#^.{3}#','***',$clone->email);
            }  ?><br>
                По правилам сайта для продолжения использования этой анкеты подключите <a href="/profile/premium">премиум аккаунт</a><br/>
            <?php } else { ?>
            <?php if (Yii::app()->user->me->balance >= ServiceManager::getPrice(ServiceManager::SERVICE_UP)): ?>
                <p>
                <span class="red">Счет пополнен!</span>  Нажмите <a href="/profile/up">кнопку «Поднять анкету»</a>. Переписка и показы в поиске включатся автоматически.
                <br/><p>
                <?php endif; ?>
                Ваша страница определена как повторная.<br/>
                <?php  if ($clone = Yii::app()->user->me->lastClone) {
                if ($clone->isdeleted)
                    echo 'Ранее с вашего компьютера '.date ('d.m.Y',$clone->first_visit).' создавалась анкета';
                else
                    echo 'Ранее с вашего компьютера создана анкета с e-mail '. preg_replace('#^.{3}#','***',$clone->email);
                }  ?>
                <!--С вашего компьютера уже пользовались нашим сайтом ранее.--><br/>
                По правилам сайта для продолжения использования этой анкеты выполните <a href="/profile/up">поднятие анкеты</a> <br/>
            <?php } ?>
        </div>
    <?php } ?>
    <?php endif; ?>

    <?php  if (!Yii::app()->user->isGuest && (time() - Yii::app()->user->me->first_visit < 3 * 86400))
           if (!Yii::app()->user->me->isBad() && !Yii::app()->user->me->premium) { // ?>
<div style="margin:10px 40px">

</div>
    <? } //*/ ?>
	<?php echo $content; ?>

	<div id="footer">
<div style="float:right;display:none;">
    <a href="http://www.interkassa.com/" title="INTERKASSA" target="_blank"><img src="http://www.interkassa.com/img/ik_88x31_01.gif" alt="INTERKASSA" /></a>
    <!-- begin WebMoney Transfer : accept label -->
    <a href="http://www.megastock.ru/" target="_blank"><img src="/images/icon/acc_blue_on_white_ru.png" alt="www.megastock.ru" border="0"></a>
    <!-- end WebMoney Transfer : accept label -->

    <!-- begin WebMoney Transfer : attestation label -->
    <a href="https://passport.webmoney.ru/asp/certview.asp?wmid=996314240929" target="_blank"><img src="/images/icon/v_blue_on_white_ru.png" alt="Здесь находится аттестат нашего WM идентификатора 996314240929" border="0" /><br /><span style="font-size: 0,7em;">Проверить аттестат</span></a>
    <!-- end WebMoney Transfer : attestation label -->

</div>
        <!--LiveInternet counter--><script type="text/javascript"><!--
    document.write("<a href='http://www.liveinternet.ru/click' "+
            "target=_blank><img src='//counter.yadro.ru/hit?t44.1;r"+
            escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
            ";"+Math.random()+
            "' alt='' title='LiveInternet' "+
            "border='0' width='11' height='11'><\/a>")
    //--></script><!--/LiveInternet-->
		&copy; 2009-<?php echo date('Y'); ?> loqum.ru  <?//= CHtml::link('Контакты','/contact'); ?> | <?= CHtml::link('Обратная связь', array('/site/contact')); ?>
        <?php /* | <?= CHtml::link('Договор оферта','/oferta'); ?> | <?= CHtml::link('Правила','/rules'); ?> */
        //if ($_SERVER['REQUEST_URI'] == '/') echo ' | ',
               // CHtml::link('Контакты', array('site/page','view'=>'contact'));?><br/>
         Знакомства с мужчинами <? //=$_SERVER['REMOTE_ADDR'];?>
    </div><!-- footer -->

</div><!-- page -->
<?php if ($this->getModule()==null) $this->renderPartial('//common/_yandex_metrika'); ?>
<script>

</script>

<?php $this->renderPartial('//common/_fingerprints'); ?>
<?php if ($_SERVER['REMOTE_ADDR']=='89.169.186.44') echo CHtml::image('/images/0x0.gif'); ?>
<?php if ($_SERVER['REMOTE_ADDR']=='89.169.186.44') echo $GLOBALS['config']; ?>
</body>
</html>
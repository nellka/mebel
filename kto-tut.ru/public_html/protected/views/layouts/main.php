<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	    <script type="text/javascript" language="javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
	
</head>

<body>

<div class="container" id="page">
	<div id="mainmenu">
		<?php 
		if (in_array(Yii::app()->user->role,array('admin','manager'))) {
			$this->widget('zii.widgets.CMenu',array(		
			'items'=>array(
				array('label'=>'Магазин', 'url'=>array('/site/index')),
				array('label'=>'Мои заказы', 'url'=>array('/order/my')),
				array('label'=>'Пользователи', 'url'=>array('/cp/user/admin')),				
				array('label'=>'Товары', 'url'=>array('/cp/product/admin')),
				array('label'=>'Категории', 'url'=>array('/cp/category/admin')),
				array('label'=>'Заказы', 'url'=>array('/cp/order/admin')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
			));
		} else {
			$this->widget('zii.widgets.CMenu',array(		
			'items'=>array(
				array('label'=>'Магазин', 'url'=>array('/site/index')),
				array('label'=>'Мои заказы', 'url'=>array('/order/my'),'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
			)); 
		}?>
	</div><!-- mainmenu -->
	<div id='content'>
		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif?>
	
		<?php echo $content; ?>
	
		<div class="clear"></div>
    </div>

	<div id="footer">
		Copyright nellka.
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>

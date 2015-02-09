<?php function PrintHeader($title = "Сергей Дикий - Официальный Сайт", $menuItem = 0, $desc = "") { ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="description" content="<?php echo $desc; ?>" />
		<meta name="keywords" content="Сергей Дикий Официальный Сайт" />
		<meta name="robots" content="index, follow, all"> 
		
		<title><?php echo $title; ?> </title>

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800|Open+Sans+Condensed:300&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
		
		<link href='lib/css/styles.css' rel='stylesheet' type='text/css'>

		<script type="text/javascript" src="lib/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="lib/js/modernizr-1.7.min.js"></script>		
		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
		<script type="text/javascript" src="lib/js/scripts.js"></script>
		
		<link rel="stylesheet" type="text/css" href="lib/css/colorbox.css">
<script type="text/javascript" src="lib/js/jquery.lazyload.mini.js"></script>
<script type="text/javascript" src="lib/js/jquery.colorbox-min.js"></script>
<script src="lib/js/uppod.js" type="text/javascript"></script>
<script>
     $(document).ready(function () {
     $("img").lazyload({effect:"fadeIn"});
     $("a[rel='colorbox']").colorbox({current:"Фото {current} из {total}"});
     });
</script>
	</head>
	<body>
		<div class="header">
			<div class="left">
				<div class="logo">
					<a href="./"><img src="lib/img/logo.png" alt="" /></a>
				</div>
			</div>
			<div class="right">
				<ul class="menu">  
					<!--<li><a href="./" <?php if ($menuItem == 1) { echo "class='active'"; }?>>Главная</a></li>-->
					<li><a href="./?биография" <?php if ($menuItem == 2) { echo "class='active'"; }?>>Биография</a></li>
					<li><a href="./?фотоальбом" <?php if ($menuItem == 3) { echo "class='active'"; }?>>Фотоальбом</a></li>
					<li><a href="./?музыка" <?php if ($menuItem == 4) { echo "class='active'"; }?>>Музыка</a></li>
					<li><a href="./?видео" <?php if ($menuItem == 5) { echo "class='active'"; }?>>Видео</a></li>
					<li><a href="./?продюсирование" <?php if ($menuItem == 8) { echo "class='active'"; }?>>Продюсирование</a></li>
					<li><a href="./?афиша" <?php if ($menuItem == 7) { echo "class='active'"; }?>>Организаторам</a></li>
					<li><a href="./?гостевая" <?php if ($menuItem == 6) { echo "class='active'"; }?>>Гостевая</a></li>
				</ul>
			</div>
		</div>
	

<?php } function PrintFooter() { ?>	
		<div class="footer">© <?php echo date("Y"); ?> Сергей Дикий</div>
	</body>
</html>
<?php } ?>
<?php


include('functions.php');

require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$isMobile = $detect->isMobile() ? true : false;
$mod = $_REQUEST['mod'];

$mHome = 1;
$mBio = 2;
$mPhoto = 3;
$mMusic = 4;
$mVideo = 5;
$mGuestbook = 6;
$mPromo = 7;
$mProduction = 8;

$pageTitle = "Сергей Дикий - Официальный Сайт";
$pageActiveMenu = 0;
$desc = "Сергей Дикий - Официальный Сайт";
$pageContent = "";

if (isset($_GET['биография'])||$mod=='biography'||$mod=='биография') 
{
	$pageTitle = "Биография - Сергей Дикий";
	$pageActiveMenu = $mBio;
	$pageContent = file_get_contents("lib/data/bio.htm");
	$desc = $pageTitle;
}
elseif (isset($_GET['фотоальбом'])||$mod=='фотоальбом'||$mod=='photo') 
{
	$pageTitle = "Фотоальбом - Сергей Дикий";
	$pageActiveMenu = $mPhoto;
	$pageContent = file_get_contents("lib/data/photo.htm");
	$desc = $pageTitle;
}
elseif (isset($_GET['музыка'])||$mod=='музыка'||$mod=='mymusic') 
{
	$pageTitle = "Музыка - Сергей Дикий";
	$pageActiveMenu = $mMusic;
	$pageContent = file_get_contents("lib/data/music.htm");
	$desc = $pageTitle;
} 
elseif (isset($_GET['видео'])||$mod=='видео'||$mod=='myvideo') 
{
	$pageTitle = "Видео - Сергей Дикий";
	$pageActiveMenu = $mVideo;
	$pageContent = file_get_contents("lib/data/video.htm");
	$desc = $pageTitle;
} 
elseif (isset($_GET['гостевая'])||$mod=='гостевая'||$mod=='guest')
{
	$pageTitle = "Гостевая - Сергей Дикий";
	$pageActiveMenu = $mGuestbook;
	$pageContent = file_get_contents("lib/data/guest.htm");
	$desc = $pageTitle;
} 
elseif (isset($_GET['афиша'])||$mod=='афиша'||$mod=='promo') 
{
	$pageTitle = "Афиша - Сергей Дикий";
	$pageActiveMenu = -1;
	$pageContent = file_get_contents("lib/data/promo.htm");
	$desc = $pageTitle;
}
elseif (isset($_GET['лесоповал'])||$mod=='lesopoval'||$mod=='лесоповал') 
{
	header('Content-type: text/html; charset=utf-8');
	$pageTitle = "Лесоповал";
	$pageActiveMenu = -1;
	/*$pageContent = file_get_contents("lib/data/lesopoval.htm");*/
	$desc = $pageTitle;
	header('Content-type: text/html; charset=utf-8'); 
	PrintHeader($pageTitle, $pageActiveMenu, $desc);
	include("lib/data/lesopoval.tpl.php");
	//echo $pageContent;
	PrintFooter();
	die();
} 
elseif (isset($_GET['продюсирование'])||$mod=='продюсирование'||$mod=='production') 
{
	$pageTitle = "Продюсирование - Сергей Дикий";
	$pageActiveMenu = $mProduction;
	$pageContent = file_get_contents("lib/data/production.htm");
	$desc = $pageTitle;
} 
else 
{
	$pageTitle = "Сергей Дикий - Официальный Сайт";
	$pageActiveMenu = $mHome;
	$pageContent = file_get_contents("lib/data/main.htm");
	$desc = $pageTitle;
}

header('Content-type: text/html; charset=utf-8'); 
PrintHeader($pageTitle, $pageActiveMenu, $desc);
echo $pageContent;
PrintFooter();

?>
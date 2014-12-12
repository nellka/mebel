<? /** @var Anketa $model */?>
<?php
$anketa = $model;
$site = $anketa->last_site;
?>

<p>Здравствуйте, <?php echo $model->name?>.<br/>
<br/>
Благодарим Вас за регистрацию на нашем ресурсе.<br/>
Логин: <?php echo $model->email ;?><br/>
Пароль: <?php echo $model->password ;?>

<br/><br/>
    Ваша анкета на «<?=$site;?>»: <a href="<?=$anketa->getAbsoluteLink()?>"><?=$anketa->getAbsoluteLink()?></a>

<br/><br/>
С Уважением, <br/>
Администрация сайта<br/>
<?=$_SERVER['HTTP_HOST']?>
</p>
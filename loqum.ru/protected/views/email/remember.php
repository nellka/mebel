<? /** @var Anketa $model */?>
Здравствуйте, <?php echo $model->name?>,<br/>
<br/>
Вы или кто-то другой запросили восстановление пароля:<br/>
Логин: <?php echo $model->email ;?><br/>
Ваш новый пароль: <?php echo $model->password ;?>

<br/><br/>
Ваша анкета на «Loqum»: <a href="http://www.loqum.ru/anketa/<?=$model->id?>">http://www.loqum.ru/anketa/<?=$model->id?></a>

<br/><br/>
С Уважением, <br/>
Администрация сайта<br/>
<?=$_SERVER['HTTP_HOST']?>

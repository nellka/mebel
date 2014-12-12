<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1>Админ-панель: сводка</h1>
    <p>По идее нужно разместить статистику какую-нибудь.
<div style="width:200px;">
    Пользователей:
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$count,
	'attributes'=>array(
		'total',
		'active',
        'woman',
        'man',
        'premium',
	),
)); ?></div>
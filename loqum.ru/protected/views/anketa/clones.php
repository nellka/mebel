<?php
$this->breadcrumbs=array(
	'Анкеты'=>array('index'),
	'Клоны',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('anketa-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Анкеты, имеющие клонов (Cookie)</h1>

<p>
Работают операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) перед значением переменной (==1).
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'anketa-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'name',
		'email',
		'gender',
		'age',
		'zodiac',
		'heigth',
        'sexual_orientation',
        /*
          'weight',
          'about',
          'marital_status',
          'description',
          'location',
          'icq',
          'phone',
          'last_visit',
          */
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

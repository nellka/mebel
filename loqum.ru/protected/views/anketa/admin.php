<?php
$this->breadcrumbs=array(
	'Анкеты'=>array('index'),
	'Управление',
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

<h1>Управление анкетами</h1>

<p>
Работают операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) перед значением переменной (==1).
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'anketa-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
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

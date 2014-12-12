<?php
$this->breadcrumbs=array(
	'Cities'=>array('index'),
	'Manage',
);

$this->renderPartial('_menu');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('city-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<?php
$domain = isset($_GET['d']) ? $_GET['d'] : preg_replace('#^www\.#is', '', $_SERVER['HTTP_HOST']);
$sites = array('atolin.ru','soderganki-online.ru','sodeline.ru');
foreach ($sites as $site) echo CHtml::link($site, array('admin', 'd' => $site)), '&nbsp;&nbsp; '; ?><br/><br/>

<h1>Управление Городами <?=$domain?> </h1>

<p>
Можно использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) перед значением.
</p>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'city-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'alias',
		array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link($data->name,array("update","id"=>$data->id,"d"=>$_GET["d"]),array("target"=>"_blank"))'
        ),
        array(
            'name' => 'metaTitle'
        ),
		'status',
		'order',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

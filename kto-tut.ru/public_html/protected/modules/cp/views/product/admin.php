<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Товары',
);

$this->menu=array(
	array('label'=>'Добавить товар', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление товарами</h1>


<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'product_id',
		'model',
		'sku',
		'quantity',
		'image',
		'price',
		array(
	        'name'=>'status',
	        'type'=>'raw',	        
	        'value'=>'$data->status?"Да":"Нет"',
        ),
		
		/*'date_added',
		'viewed',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

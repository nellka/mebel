<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Категории',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление категориями</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'category_id',
		'title',
		array(
	        'name'=>'parent_id',
	        'type'=>'raw',	        
	        'value'=>'$data->parent_id?$data->getTitle($data->parent_id):0',
        ),		
		array(
	        'name'=>'disabled',
	        'type'=>'raw',	        
	        'value'=>'$data->disabled?"Да":"Нет"',
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php /** @var $model Message  */
$this->breadcrumbs=array(
	'Сообщения'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Удалить?')),
);
?>

<h1>Просмотр сообщения #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            'value' => $model->id_from . " ({$model->from->name}) "
            . ' ' . CHtml::link('Анкета', array('/anketa/view', 'id' => $model->id_from))
            . ' ' . CHtml::link('Профиль', array('anketa/update', 'id' => $model->id_from)),
            'label' => $model->getAttributeLabel('id_from'),
            'type' => 'raw',
        ),
        array(
            'value' => $model->id_to . " ({$model->to->name}) "
            . ' ' . CHtml::link('Анкета', array('/anketa/view', 'id' => $model->id_to))
            . ' ' . CHtml::link('Профиль', array('anketa/update', 'id' => $model->id_to)),
            'label' => $model->getAttributeLabel('id_to'),
            'type' => 'raw',
        ),

        array(
            'value' => date('d.m.Y H:i:s',$model->datestamp)." ({$model->datestamp})",
            'label'=>$model->getAttributeLabel('datestamp'),
        ),

		'viewed',
		'deleted',
		'message',
	),
)); ?>

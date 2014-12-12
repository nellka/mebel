<?php
$this->breadcrumbs=array(
	'Анкеты'=>array('index'),
	$model->name,
);

$this->renderPartial('_menu',compact('model'));
?>

<h1>Просмотр анкеты #<?php echo $model->id; ?></h1>
<?php Yii::app()->clientScript->registerPackage('lightbox'); ?>
<div id="photos">
<?php
foreach ($model->photos as $photo) { /** @var $photo Photo  */
	echo CHtml::link(CHtml::image($photo->path,$model->name .' '.(++$i)), $photo->path,array('title'=>$model->name .' '.(++$i)));
    echo CHtml::checkBox('intim['.$photo->id_photo.']',$photo->intim,array('class'=>'intim-photo'));
}
?></div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
//		'password',
		'name',
        array(
            'value' => Anketa::$getGenders[$model->gender],
            'label'=>$model->getAttributeLabel('gender'),
        ),
//        'gender',
		'birthday',
		'age',
		'zodiac',
		'heigth',
		'weight',
		'about',
//		'marital_status',
		'sexual_orientation',
		'description',
		'location',
		'icq',
		'phone',
        'last_site',
//		'mainphoto',
		array(
            'label' => $model->getAttributeLabel('first_visit'),
            'value'=>date('d.m.Y H:i:s',$model->first_visit)
        ),
		array(
            'label' => $model->getAttributeLabel('last_visit'),
            'value'=>date('d.m.Y H:i:s',$model->last_visit)
        ),
		'isdeleted',
		'isinactive',
	),
)); ?>

<br clear="all"/>
<div style="width:47%;float:left;"><h2 style="margin-bottom: 0;">Поступления</h2>
    <?php
    $transaction = new Btransaction;
    $transaction->id_user = $model->id;
    $transaction->amount = '>0';
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'transaction-grid',
        'dataProvider'=>$transaction->searchFront(),
        'ajaxVar' => false,
        'emptyText'=>'Поступлений не было',
        'summaryText'=>'',
        //'filter'=>false,
        'columns'=>array(
            array(
                'value'=>'$row+1',
                'header'=>'#',
            ),
            array(
                'name'=>'amount',
                'cssClassExpression'=>'"sum"',
            ),

            array(
                'value'=>'date("d.m.Y H:i",$data->time_start)',
                'header'=>'Дата',
            ),
            'description',
        ),
    ));
    ?>
</div>
<div style="width:47%;margin-left:20px;float:left;"><h2 style="margin-bottom: 0;">Списания</h2>
    <?php
    $transaction->amount = '<0';
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'transaction-grid',
        'dataProvider'=>$transaction->searchFront(),
        'ajaxVar' => false,
        'emptyText'=>'Списаний не было',
        'summaryText'=>'',
        //'filter'=>false,
        'columns'=>array(
            array(
                'value'=>'$row+1',
                'header'=>'#',
            ),
            array(
                'name'=>'amount',
                'cssClassExpression'=>'"sum"',
            ),
            array(
                'value'=>'date("d.m.Y H:i",$data->time_start)',
                'header'=>'Дата',
            ),
            'description',
        ),
    ));
    ?>
</div>
<br clear="all">
<script type="text/javascript" language="javascript">
    $('.intim-photo').click(function(){
        //alert($(this).attr('name'));
        //item[id_user] item[id_photo]
        id_photo = $(this).attr('name');
        id_photo = id_photo.replace(/\D/ig,'');
        $.post('/cp/anketa/setIntimPhoto',{item:{id_user:<?=$model->id?>,id_photo:id_photo},checked:$(this).prop('checked')?1:0},function( data ) {

        });
    });
</script>

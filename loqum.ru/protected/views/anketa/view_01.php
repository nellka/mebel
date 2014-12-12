<?php
$this->pageTitle=$model->name.' - просмотр анкеты';
?>
<?php Yii::app()->clientScript->registerPackage('lightbox'); ?>
<?php /*
<div style="float:right; width:350px;">
    <table id="big2foto" width="100%" align="center" style="text-align:center;">
        <tr>
            <td align="center">
                <?php $this->renderPartial('/anketa/_simplebig',array('model'=>$model,'hidebuttons'=>true)); ?>
            </td>
        </tr>
    </table>
</div>
*/ ?>

<h1>Просмотр анкеты #<?php echo $model->id; ?></h1>
<?php Yii::app()->clientScript->registerPackage('lightbox'); ?>
<div id="photos">
    <?php
    foreach ($model->photos as $photo) {
        echo CHtml::link(CHtml::image($photo->path,$model->name .' '.(++$i)), $photo->path,array('title'=>$model->name .' '.(++$i)));
    }
    ?></div>
<div style="width:530px;">
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
//        'id',
//        'email',
//		'password',
        'name',
        array(
            'value' => Anketa::$getGenders[$model->gender],
            'label'=>$model->getAttributeLabel('gender'),
        ),
//        'gender',
//        'birthday',
        'age',
        array(
            'label'=>$model->getAttributeLabel('zodiac'),
            'value'=>Anketa::$getZodiac[$model->zodiac],
        ),

        'heigth',
        'weight',
//		'marital_status',
//        'sexual_orientation',
//        'description',
        'location',
//        'icq',
//        'phone',
//		'mainphoto',
//        'last_visit',
//        'isdeleted',
//        'isinactive',
        array(
            'label'=>$model->getAttributeLabel('about'),
            'value'=>$model->about,
            'visible'=>null!=$model->about,
        ),
    ),
)); ?>
</div>
<?php if (!empty($model)) { ?>
<div class="simplebig" id="u<?php echo $model->id; ?>">
<?php /* echo //'<span class="small">#',$model->id,'</span> ',
'',$model->name
//, CHtml::link($model->name,$model->id,array('target'=>'blank'))
, ', ',$model->age,' ', Yii::t('app', 'год|года|лет|года', $model->age).','
,' ',$model->location
, ' <br/> '
, $model->heigth ? ' рост '. $model->heigth : ''
, $model->weight ? ' вес '.$model->weight : ''
//,' ',$model->zodiac;?><br/>
*/ ?>
    <?php if (!isset($hidebuttons))
        $hidebuttons = false; ?>
<?php if ($model->photos) { ?>
<div class="bigimg"><a target="_blank" href="<?php echo $model->getMainPhotoUrl('big')?>"><img src="<?php echo $model->getMainPhotoUrl('big')?>" alt=""/></a></div>
<?php } else {?>
<div class="bigimg"><img src="<?php echo $model->getMainPhotoUrl('big')?>" alt=""/></div>
<?php } ?>
<?php
if (!empty ($model->photos)) { ?>
<div class="photos">
<div class="scrollinner">
<?php
foreach ($model->photos as $k=>$photo) {
	if ($k==$model->mainphoto ) continue; //$model->photos[0]->id_photo
	echo CHtml::link(CHtml::image($photo->pathSmall,$model->name .' '.(++$i)), $photo->pathLarge,array('title'=>$model->name .' '.(++$i)));
} ?>
</div>
</div>
<? } ?>

    <?php if (!$hidebuttons) { ?>
    <a href="javascript:;" class="like">Нравится</a> | <a href="javascript:;" class="dislike">Не очень</a><br/>
<? } ?>

</div>
<?php } ?>
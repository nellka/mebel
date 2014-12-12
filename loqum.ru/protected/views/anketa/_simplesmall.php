<?php
$model = $data;
if (!empty($model)) { ?>
<div class="simplesmall" id="u<?php echo $model->id; ?>">
    <?php echo '<span class="small"></span> '
,$model->name
//, CHtml::link($model->name, $model->id)
//, ' ', $model->age,'<br/>'
//, $model->heigth ? ' рост '. $model->heigth : ''
//, $model->weight ? ' вес '.$model->weight : ''

//, ' <br/> ',$model->location
//, ' ', $model->zodiac;?>
<?php
    //if ($mode=='welike') // ссылка на переписку для взаимных
        if (!Yii::app()->user->isGuest)
    echo CHtml::link(
    CHtml::image(Yii::app()->baseUrl.'/images/mail_generic.png','Написать сообщение'),
    array('anketa/messages/','id'=>$model->id)
);?>
    <br/>
<?php //href="<?php echo $this->createUrl('anketa/' . $model->id)?.>"?>
    <div class="smallimg">
        <?php echo CHtml::link(CHtml::image($model->photos[$model->mainphoto]->pathSmall),$model->link,array('target'=>'_blank')); ?>
    </div>
    <?php if ($mode=='dislike'||$mode=='melike') echo CHtml::link('Нравится',array('anketa/setlike','id'=>$model->id),array('class'=>'like'))?>
    <?php if ($mode=='mylike'||$mode=='melike'||$mode=='welike') echo CHtml::link('Не нравится',array('anketa/setdislike','id'=>$model->id),array('class'=>'dislike'))?>
    <!--a href="javascript:;" class="dislike">Нет</a-->
    <div class="smallgallery">
    <?php foreach ($model->photos as $k=>$v){
        if ($k==$model->mainphoto) continue;?>
<a rel="lightbox-a<?php echo $model->id ?>" target="_blank"
           href="<?php echo $model->photos[$k]->path?>"><img
            src="<?php echo $model->photos[$k]->pathSmall?>" alt=""/></a>
<?php } ?>
    </div>
</div>
<?php } ?>
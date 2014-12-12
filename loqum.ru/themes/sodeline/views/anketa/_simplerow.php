<?php
$model = $data;
if (!empty($model)) {
//        $model->last_visit = time()-rand(1000,100000);
//        $model->saveAttributes(array('last_visit'));

$countphotos = count($model->photos);
$lastvisit = $model->getLastVisitInfoArray();
    ?>

<div class="item<?php if ($model->top) echo " item-top"; ?>">
    <?php echo CHtml::link(CHtml::image($model->mainPhotoUrl,'',array('class'=>'foto')), $model->link, array('target' => '_blank')); ?>
    <div class="rht">
        <div class="name"><?=CHtml::link($model->name,$model->link,array('target'=>'_blank'));?> <?=$model->countryCity;?></div>
        <div class="text">
            <?php if ($model->age) echo $model->age, ' ', Yii::t('app', 'год|года|лет|года', $model->age); ?>
        </div>
        <b class="qw"><?=($countphotos > 0 ? $countphotos : 'Нет') . ' фото'?></b>
        <span class="presence <?=$lastvisit['status']?>"><?=$lastvisit['text']?></span>
    </div>
</div>

<? /*
<div class="simplerow" id="u<?php echo $model->id; ?>">
    <?php if ($model->top) { ?> <div class="anketa-top"> <? } ?>
    <div class="rowphoto" style="float:left;text-align:center;">
        <div class="smallrowimg">
            <?php echo CHtml::link(CHtml::image($model->mainPhotoUrl), $model->link, array('target' => '_blank')); ?>
        </div>
    </div>
    <div class="rowinfo">
        <h2><?=CHtml::link($model->name,$model->link,array('target'=>'_blank')); if ($model->age)
            echo ", <span>", $model->age, ' ', Yii::t('app', 'год|года|лет|года', $model->age) . "</span>"; ?></h2>
        <?php  ?>
        <p><?=$countrycity;?></p>

        <p><b><?=($countphotos > 0 ? $countphotos : 'Нет') . ' фото'?></b></p>
    </div>

    <?php echo $model->getLastVisitInfo(); ?>
    <?php
    //if ($mode=='welike') // ссылка на переписку для взаимных
    if (!Yii::app()->user->isGuest)
        echo CHtml::link(
            CHtml::image(Yii::app()->baseUrl . '/images/message.png', 'Написать сообщение',array('style'=>'vertical-align:middle;')).'Написать сообщение',
            array('anketa/messages/', 'id' => $model->id),
            array('style'=>'vertical-align:middle;')
        );?>
    <br clear="all"/>
    <?php if ($model->top) { ?> </div> <? } ?>
</div>
<br clear="all"/>
 */ ?>
<?php } ?>

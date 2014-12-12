<?php
$model = $data;
if (!empty($model)) {
//        $model->last_visit = time()-rand(1000,100000);
//        $model->saveAttributes(array('last_visit'));

$countrycity = $model->countryCity;
$countphotos = count($model->photos);
    ?>

<div class="simplerow" id="u<?php echo $model->id; ?>">
    <?php if ($model->top) { ?> <div class="anketa-top"> <? } ?>
    <div class="rowphoto" style="float:left;text-align:center;">
        <div class="smallrowimg">
            <?php echo CHtml::link(CHtml::image($model->mainPhotoUrl), $model->link, array('target' => '_blank')); ?>
        </div>
    </div>
        <div style="float:right; width:400px;">
            <?php if ($model->about) { ?> <span style="color:blue;">О себе<br/></span>
                <?= $model->about; ?>
            <? } ?>
        </div>

    <div class="rowinfo">
        <h2><?=CHtml::link($model->name,$model->link,array('target'=>'_blank')); if ($model->age)
            echo ", <span>", $model->age, ' ', Yii::t('app', 'год|года|лет|года', $model->age) . "</span>"; ?></h2>
        <?php  ?>
        <?php if ($model->find_from) echo "<p>Ищу <img src='/images/icon/icon_m.gif' alt='Мужчину'> от {$model->find_from} до {$model->find_to}</p>"; ?>
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
<?php } ?>

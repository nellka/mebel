<?php Yii::app()->clientScript->registerPackage('lightbox'); ?>
<?php
Yii::app()->params['body_class'] = 'inner-page';
if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) {
    function mb_ucfirst($string,$enc='utf-8') {
        $string = mb_strtoupper(mb_substr($string, 0, 1, $enc),$enc) . mb_substr($string, 1,100,$enc);
        return $string;
    }
}

$desc1 = explode("\n",$model->description);
$desc1 = array_intersect($desc1,array('ищу спонсора','стану спонсором'));
$desc1 = implode (' ',$desc1);
setlocale(LC_ALL, "ru_RU.UTF-8");
if ($desc1) $desc1 = mb_ucfirst ($desc1,'utf-8') . '.';



$this->pageTitle = "$desc1 ";
$this->pageTitle .= $model->name;
$this->pageTitle .=  ', '. $model->age. ' '. Yii::t('app', 'год|года|лет|года', $model->age) ;
$this->pageTitle .= ', '.$model->city;
if ($model->about) {
    $about = trim($model->about);
    $pos = min(mb_strpos($about,"\n",'utf-8'),mb_strpos($about,".",'utf-8'));
    if ($pos <=0 ) $pos = 250;
    $about = mb_substr($about,0,$pos,'utf-8');
    if ($about)
        $this->pageTitle .= '. '. $about;//strpos($this->pageTitle,"\n")
    $this->pageTitle = mb_substr($this->pageTitle,0,250,'utf-8');
}
//' - просмотр анкеты';
$lastvisit = $model->getLastVisitInfoArray();
?>
<div class="profile nuclear">
    <!-- slider -->
    <div class="slider">

        <div id="gallery" class="ad-gallery">
            <div class="ad-image-wrapper">
            </div>

            <div class="ad-nav">
                <div class="shadow"></div>
                <div class="ad-thumbs">
                    <ul class="ad-thumb-list">
                        <li><?php echo CHtml::link(CHtml::image($model->getMainPhotoUrl()),$model->getMainPhotoUrl('big'),array('rel'=>'lightbox'));?></li>
<?php $i = 0; if ($model->photos) foreach ($model->photos as $k => $photo) if ($k != $model->mainphoto)
    echo '<li>' . CHtml::link(CHtml::image($photo->pathSmall, $model->name . ' ' . (++$i), array('class' => 'image0')),
        $photo->pathLarge, array('rel'=>'lightbox','title' => $model->name . ' ' . (++$i))) . '</li>'; ?>

                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!--/ slider -->
    <div class="descript">
        <div class="headline nuclear">
            <span class="name"><?php echo CHtml::encode($model->name); ?></span>
            <span class="presence <?=$lastvisit['status']?>"><?=$lastvisit['text']?></span>
            <?php if ($model->top) { ?><img src="<?=Yii::app()->theme->baseUrl;?>/images/top.png" alt="" class="top" /><?php } ?>
        </div>
        <p><?php echo  $model->age, ' ', Yii::t('app', 'год|года|лет|года', $model->age)
        , ' ', Anketa::$getZodiac[$model->zodiac]; ?>
            <?=$model->countryCity;?></p>

        <?php if (Yii::app()->user->isGuest || Yii::app()->user->id != $model->id)
        echo CHtml::link('Написать сообщение', array('anketa/messages/', 'id' => $model->id),
            array('class' => 'send')); ?>

        <div class="currently">
            <img src="<?=Yii::app()->theme->baseUrl;?>/images/angle.jpg" alt="" class="angle" />
            <h3>О себе</h3>
            <?=$model->about ? (nl2br(CHtml::encode($model->about))) : ' Пользователь предпочёл не указывать информацию о себе'?>
        </div>

        <div class="desc-row nuclear">
            <div class="data">
                <h3>Данные:</h3>
                <ul class="data-mnu">
                    <li><span>Рост:</span><b><?=$model->heigth ? $model->heigth . ' см' : 'не указан'?></b></li>
                    <li><span>Вес:</span><b><?=$model->weight ? $model->weight . ' кг' : 'не указан'?></b></li>
                </ul>
                <h3>Ищу парня</h3>
                <ul class="data-mnu data-find">
                    <li><?
                        if ($model->find_from) echo " От {$model->find_from} ";
                        if ($model->find_to) echo " до {$model->find_to} ";
                        ?></li>
                </ul>
                <h3>Роль в сексе</h3>
                <ul class="data-mnu data-role">
                    <?php  if ($sex_roles = explode (",",$model->sex_role));
                    foreach ($sex_roles as $role) {?>
                        <li><?= Anketa::$getSexRoles[$role] ?></li>
                    <? } ?>
                </ul>

            </div>
            <div class="target">
                <h3>Цели знакомства:</h3>
                <ul class="target-mnu">
                    <? if ($model->description)
                    foreach (explode("\n",$model->description) as $v) { if (''==trim($v)) continue; ?>
                    <li><?=$v?></li>
                        <? } else { ?>
                        <li>Не указаны</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php ?>


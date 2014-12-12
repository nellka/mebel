<?php

//if ($index == 8) echo "<br><br><h2>Фотографии Содержанок</h2>";
$model = $data;
if (!empty($model)) {
    if (empty($model->photos)) {
        $model->mainphoto = null;
        $model->saveAttributes(array('mainphoto'));
    }
    ?>
<div class="simplemain" id="u<?php echo $model->id; ?>">
    <div class="smallmainimg">
        <?php echo CHtml::link(CHtml::image($model->mainPhotoUrl,CHtml::encode($model->name)),
        $model->link, array('target' => '_blank','title'=>CHtml::encode($model->name)));
//        $model->last_visit = time()-rand(1000,90000);
//        $model->saveAttributes(array('last_visit'));
        ?>
    </div>
    <?//=($index < 8 ) ? 'Гей' : ''?>
    <?=($model->gender == Anketa::GENDER_MAN) ? '&nbsp;' : ''?>
    <?=CHtml::link($model->name,$model->link);?>, <span class="mage"><?=$model->age?></span><br/>
    <?=$model->city?>
    <?php if ($model->find_from) echo "<p>Ищу <img src='/images/icon/icon_m.gif' alt='Мужчину'> {$model->find_from} &ndash; {$model->find_to}</p>"; ?>
</div>
<?php } ?>
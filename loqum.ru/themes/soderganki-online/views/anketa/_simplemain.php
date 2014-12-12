<?php
if ($index == 8) echo '    </div>
    <br clear="all"/>
    <h2>Фотографии содержанок</h2>
    <div class="row nuclear">';
else if ($index == 16) echo '<div class="clear"></div>';
$model = $data;
if (!empty($model)) {
    ?>
    <a href="<?= CHtml::normalizeUrl(array('anketa/fakeView','id'=>strrev($model->id)))?>" class="preview" title="<?=CHtml::encode($model->name)?>">
        <img src="<?=$model->mainPhotoUrl?>" alt="" />
        <i class="txt">
            <? if ($index < 8 && $model->gender == 0): ?><span>Содержанка</span><?php endif; ?>
            <? if ($model->gender == Anketa::GENDER_MAN): ?><span>Спонсор</span><?php endif; ?>
            <span><b><?=CHtml::encode($model->name)?>,</b><?=$model->age?></span>
            <span><?=$model->city?></span>
        </i>
    </a>
<?php } ?>
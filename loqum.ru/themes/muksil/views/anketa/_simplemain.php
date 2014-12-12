<?php
if (0) echo '    </div>
    <br clear="all"/>
    <h2>Фотографии содержанок</h2>
    <div class="row nuclear">';
else if (0 == $index % 8) echo '<div class="clear"></div>';
$model = $data;
if (!empty($model)) {
    ?>
    <a href="<?= CHtml::normalizeUrl(array('anketa/fakeView','id'=>strrev($model->id)))?>" class="preview" title="<?=CHtml::encode($model->name)?>">
        <img src="<?=$model->mainPhotoUrl?>" alt="" />
        <i class="txt">
            <span><b><?=CHtml::encode($model->name)?>,</b><?=$model->age?></span>
            <span><?=$model->city?></span>
        </i>
    </a>
<?php } ?>
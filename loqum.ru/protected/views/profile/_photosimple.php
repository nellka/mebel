<div class="myphoto">
    <?php
    //if ($model->id_photo != $mainphoto)
    echo CHtml::checkBox('delete[' . $model->id_photo . ']');
    echo $model->description, '<br/> ';
    echo CHtml::image($model->path, $model->description);
    echo '<br>', CHtml::link(
        $model->intim ? 'Интим' : 'НЕ интим',
        array('profile/PhotoIntim','id_photo'=>$model->id_photo)
    ),'<br>';
    if ($model->id_photo == $mainphoto) echo 'Основное ';
    else echo CHtml::submitButton('Сделать основным',array('name'=>'mainphoto['.$model->id_photo.']'));

    ?>
</div>
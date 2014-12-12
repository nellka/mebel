<?php $this->renderPartial('_menu'); ?>
<?php
$this->breadcrumbs = array(
    'Профиль' => array('/profile'),
    'Мои фото',
);?>
<h1>Мои фото</h1>
<?php $this->renderPartial('_flash'); ?>

<?php echo CHtml::link('Загрузить', array('/profile/photo')); ?>
<br><br>

<?php $mainphoto = $user->mainphoto; ?>
<?php if ($models) { ?>

<?php echo CHtml::form('', 'post'); ?>
<div class="allphotos">
    <?php
    foreach ($models as $model) {
        $this->renderPartial('_photosimple', compact('model', 'mainphoto'));
    } ?>
    <br clear="both"/>
    <?php echo CHtml::submitButton('Удалить отмеченные', array('confirm' => 'Вы уверены?', 'name' => 'deletephotos')); ?>
</div>
<?php echo CHtml::endForm(); ?>

<?
} else {
    echo 'Фотографий не найдено';
}

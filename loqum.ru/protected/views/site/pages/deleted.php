<?php

    if (!$flash = Yii::app()->user->getFlash('deleted'))
        throw new CHttpException(404,'Страница не найдена');

?>
<h1>Ваша анкета удалена</h1>
<div class="flash-success">
    <?php echo $flash ; // Yii::app()->user->getFlash('deleted'); ?>
</div>
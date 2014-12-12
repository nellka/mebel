<?php if(Yii::app()->user->hasFlash('profile')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('profile'); ?>
</div>
<?php endif; ?>

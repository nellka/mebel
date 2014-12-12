<h1>Сбросить <?php echo $info ?></h1>
<?php if(Yii::app()->user->hasFlash('reset_ok')): ?>
<div class="flash-success">
    <?=Yii::app()->user->getFlash('reset_ok');?>
    <?php if ($guestlikes = Yii::app()->user->getState('guestlikes')) {

} ?>
</div>
<?php endif; ?>
<?php
if ($guestlikes = Yii::app()->user->getState('guestlikes')) {
    if (is_array($guestlikes['like']))
        echo "<br/>Нравятся:", implode(',', $guestlikes['like']);
    if (is_array($guestlikes['dislike']))
        echo "<br/>Не нравятся:", implode(',', $guestlikes['dislike']);
}
?>
    <form method="post" action="">
        <input type="submit" name="v1" value="Сбросить"/>
        <input type="submit" name="v2" value="Сбросить (v2)"/>
    </form>
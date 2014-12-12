<?php
$this->pageTitle =  CHtml::encode($user->name). ' - вся переписка';
Yii::app()->params['body_class'] = 'inner-page';
$model = $anketa = $user;
$lastvisit = $model->getLastVisitInfoArray();
$countphotos = count($model->photos);
?>
<h2><?php echo $user->name ?> -
<?=$all ? 'вся переписка' : ' последние 10 сообщений ('.CHtml::link('показать все',array('anketa/messages','id'=>$user->id,'mode'=>'all')).')'  ?></h2>



<?php if (Yii::app()->user->hasFlash('error')) { ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error') ?>
</div>
<?php } ?>
<div style="width:360px; border:solid 1px #fff; padding:0px; float:left; class="messagelist">
        <div class="mphoto">
    <span class="messagephoto">
    <?php echo
    $anketa->isdeleted ? CHtml::image($anketa->mainPhotoUrl, $anketa->name) :
        CHtml::link(CHtml::image($anketa->mainPhotoUrl, $anketa->name),
            $anketa->link,array('target'=>'_blank'));
    ?>
    </span>
        </div>
    <div class="minfo userinfo" style="width:250px;">
        <?php if ($anketa->isdeleted) { ?>
        <span class="uname black"><?=$anketa->name?></span><br/>
        <b>Пользователь удалён</b>
        <? } else { ?>
        <div class="name"><?=CHtml::link($model->name,$model->link,array('target'=>'_blank'));?></div>
        <div class="text">
            <?php if ($model->age) echo $model->age, ' ', Yii::t('app', 'год|года|лет|года', $model->age),','; ?>
            <?=$model->countryCity;?>
        </div>
        <b class="qw"><?=($countphotos > 0 ? $countphotos : 'Нет') . ' фото'?></b>
        <span class="presence <?=$lastvisit['status']?>"><?=$lastvisit['text']?></span>
        <? } ?>
    </div>
</div>
<div style="width:500px; margin-left:20px; padding:10px; float:left; border:solid 1px #ccc;">
<?php foreach($messages as $message) { /** @var $message Message */
    if($message->id_from == Yii::app()->user->id) {
        $current = $me;
        $class='my';
    } else {
        $current = $user;
        $class="";
    }
    ?>
<div class="umsg">
    <img src="/images/icon/icon_message.gif" alt=""/>
    <?php echo CHtml::link( $current->name,$anketa->isdeleted?'#':array('/anketa/view','id'=>$message->id_from),array('class'=>'msg'.$class,'target'=>'_blank')); ?>
    <span class="umsgdate"><?php echo date('d.m.Y H:i',$message->datestamp); ?></span><br/>
    <div class="umsgtext<?=" $class"?>"><?php echo nl2br($message->message) ?></div>
</div>
<?php } ?>

<?php
    if($anketa->isdeleted) ;
    //if ($hideform)
    //echo 'Вы можете отправлять сообщения только по взаимой симпатии<br/>';
else
    $this->renderPartial('_message', array('model' => $posted,'anketa'=>$anketa)); ?>
    </div>
<br clear="all"/>

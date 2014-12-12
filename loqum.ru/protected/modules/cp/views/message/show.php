<?php
$this->breadcrumbs = array(
    'Переписки' => array('/cp/message'),
);
$this->renderPartial('_menu',compact('model'));
if ($model->id_from) {
    $this->breadcrumbs[$model->from->name] = array('message/list', 'id' => $model->id_from);
}
if ($model->id_to) {
    $this->breadcrumbs[$model->to->name] = array('message/list', 'id' => $model->id_to);
}
$this->breadcrumbs[] = $anketas[0]->name . ' ' . $anketas[1]->name;

$messages = $dataProvider->getData();
?>

<h1><?php //echo $anketas[0]->name, ' ', $anketas[1]->name ?> - вся переписка</h1>
<?php $user = $anketas[0]; $me=$anketas[1]; ?>
<?php $anketa = $user; ?>
<?php if (Yii::app()->user->hasFlash('error')) { ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('error') ?>
</div>
<?php } ?>
<style>
    .umsg { border-bottom:solid 1px #ccc;font-size:12px;margin-top:10px;}
    .umsgtext {margin-bottom:10px;margin-top:7px;}
    .umsg a {text-decoration: none; font-weight: bold; color:#da6a04;}
    .umsg a.msgmy {color:#1b7cc5;}
    .umsgtext.my {color:#1b7cc5;}
</style>


<div style="width:360px; border:solid 1px #fff; padding:0px; float:left; class="messagelist">
<?php $anketa = $anketas[0]; ?>
        <div class="mphoto">



    <span class="messagephoto"><?php echo
    CHtml::link(
        CHtml::image($anketa->getMainPhotoUrl(),$anketa->name),//$anketa->mainphotoimage->path
        array('/cp/anketa/view','id'=>$anketa->id)); ?></span>
        </div>
            <div class="minfo" style="width:250px;">
                <?php if ($anketa->isdeleted) { ?>
                <span class="uname black"><?=$anketa->name?></span><br/>
                <b>Пользователь удалён</b>
                <? } else { ?>
                <span class="uname">
        <?php echo CHtml::link( $anketa->name,array('/cp/anketa/view','id'=>$anketa->id))?>, <?=$anketa->age?>
                    <?=CHtml::image($anketa->genderIcon,'')?></span><br/>
                <?=$anketa->country.', '.$anketa->city;?><br/>
                <? /*<span class="umdate"> последнее сообщение <?php echo date('d.m.Y H:i',$message['datestamp']); ?></span> */ ?>
                <?=$anketa->getLastVisitInfo(); ?>
                <? } ?>
            </div>
<hr>
    <?php $anketa = $anketas[1]; ?>
        <div class="mphoto">
    <span class="messagephoto"><?php echo
    CHtml::link(
        CHtml::image($anketa->getMainPhotoUrl(),$anketa->name),//$anketa->mainphotoimage->path
        array('/cp/anketa/view','id'=>$anketa->id)); ?></span>
        </div>
                <div class="minfo" style="width:250px;">
                    <?php if ($anketa->isdeleted) { ?>
                    <span class="uname black"><?=$anketa->name?></span><br/>
                    <b>Пользователь удалён</b>
                    <? } else { ?>
                    <span class="uname">
        <?php echo CHtml::link( $anketa->name,array('/cp/anketa/view','id'=>$anketa->id))?>, <?=$anketa->age?>
                        <?=CHtml::image($anketa->genderIcon,'')?></span><br/>
                    <?=$anketa->country.', '.$anketa->city;?><br/>
                    <? /*<span class="umdate"> последнее сообщение <?php echo date('d.m.Y H:i',$message['datestamp']); ?></span> */ ?>
                    <?=$anketa->getLastVisitInfo(); ?>
                    <? } ?>
                </div>
</div>


<div style="width:500px; margin-left:20px; padding:10px; float:left; border:solid 1px #ccc;">
    <?php foreach($messages as $message) { /** @var $message Message */
    if($message->id_from == $anketa->id) {//$anketa->id
        $current = $me;
        $class='my';
    } else {
        $current = $user;
        $class="";
    }
    ?>
    <div class="umsg">
        <img src="/images/icon/icon_message.gif" alt=""/>
        <?php echo CHtml::link( $current->name,'#',array('class'=>'msg'.$class),array('class'=>$class)); ?>
        <span class="umsgdate"><?php echo date('d.m.Y H:i',$message->datestamp); ?></span><br/>
        <div class="umsgtext<?=" $class"?>"><?php echo nl2br($message->message) ?></div>
    </div>
    <?php } ?>

</div>
<br clear="all"/>



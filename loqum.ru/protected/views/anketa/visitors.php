<?php $this->pageTitle = 'Кто смотрел'; ?>
<h1>Кто смотрел анкету в последние 2 недели</h1>

<?php  //  print_r ($messages); ?>
<?php foreach($visitors as $visitor) {
    $anketa = $visitor;
    $cnt = 1;//Message::model()->fromto($anketa->id)->count();
    if (!$anketa) continue;?>
<div class="messagelist my<?php // echo $message->id_from==Yii::app()->user->id?' my':''?>">
    <div class="mphoto">
    <span class="messagephoto">
        <?php echo
    $anketa->isdeleted ? CHtml::image($anketa->mainPhotoUrl, $anketa->name) :
        CHtml::link(CHtml::image($anketa->mainPhotoUrl, $anketa->name),
            $anketa->link);
        ?>
    </span>
    </div>
    <div class="minfo" style="width:250px;">
        <?php if ($anketa->isdeleted) { ?>
        <span class="uname black"><?=$anketa->name?></span><br/>
        <b>Пользователь удалён</b>
        <? } else { ?>
        <span class="uname">
        <?php echo CHtml::link( $anketa->name,array('/anketa/view','id'=>$anketa->id))?>, <?=$anketa->age?>
            <?=CHtml::image($anketa->genderIcon,'')?></span><br/>
        <?=$anketa->country.', '.$anketa->city;?><br/>
        <? /*<span class="umdate"> последнее сообщение <?php echo date('d.m.Y H:i',$message['datestamp']); ?></span> */ ?>
        <?=$anketa->getLastVisitInfo(); ?>
        <? } ?>
    </div>
    <div class="munread"></div>
    <div class="mtotal">Смотрел<?=$anketa->gender?'':'а';?> <?= date ('d.m.Y <\b\r/>в H:i',$anketa->datestamp); ?> </div>
    <div class="umessagetext"><?php //echo $message->message ?></div>
</div><br clear="left"/>
<?php } ?>

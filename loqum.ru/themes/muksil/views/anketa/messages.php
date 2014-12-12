<h1>Cообщения / <?=$currentFolder->name?></h1>
<div id="mfolders">

    <?php
    $folders = MessageFolder::model()->sorted()->visible()->findAll();
    foreach ($folders as $k => $folder) { ?>
        <?php echo $folder->id == $currentFolder ? $folder->name:
            CHtml::link($folder->name,array('anketa/messages','folder'=>$folder->id)) ?>:
        <?php if ($folder->id != Anketa::FOLDER_ID_IGNORE)
            if ($unread = $folder->unreadCount) echo "<b class='pink'>$unread</b> "; else echo "<b class='black'>$unread</b>"; ?> /
        <?php echo $folder->messagelistCount; ?>
        <br/>
    <?php if ($folder->id == $currentFolder->id) unset ($folders[$k]); // убрать текущую папку из списка для перемещения ?>
    <?php } ?>
</div>
<div id="message-list-sort">
<?php echo CHtml::beginForm(array('anketa/sortMessages'),'post',array('onsubmit'=>'js:return checkMessageForm();')); ?>
<?php  //  print_r ($messages); ?>
<?php foreach($messages as $k=> $message) {
    $model = $anketa = $users[$k];
    $lastvisit = $model->getLastVisitInfoArray();
    $countphotos = count($model->photos);
    $cnt = $message['cnt'];
    $new = isset($newCnt[$k]) ? $newCnt[$k] : 0;
    if (!$anketa) continue;?>
<div class="messagelist my<?php // echo $message->id_from==Yii::app()->user->id?' my':''?>">
    <div class="mchkbox"><?php echo CHtml::checkBox('id[]',false,array('value'=>$anketa->id)) ?></div>
    <div class="mphoto">
    <span class="messagephoto">
    <?php echo
    $anketa->isdeleted ? CHtml::image($anketa->mainPhotoUrl, $anketa->name) :
        CHtml::link(CHtml::image($anketa->mainPhotoUrl, $anketa->name),
            $anketa->link);
        ?>
    </span>
    </div>
    <?php if ($anketa->isdeleted) { ?>
    <div class="minfo">
        <div class="name"><?=$anketa->name?></div>
        <b>Пользователь удалён</b><br/>
        <?= CHtml::link( Yii::t('app','Архив сообщений')
            ,array('/anketa/messages','id'=>$k));?>
    </div>
    <div class="munread"><?= !$new?'': CHtml::link( Yii::t('app','{n} новое |{n} новых |{n} новых',$new)
        ,array('/anketa/messages','id'=>$k,'#'=>'message-_message-form'),array('target'=>'_blank'));?></div>
    <? } else { ?>
    <div class="minfo">
        <div class="name"><?=CHtml::link($model->name,$model->link,array('target'=>'_blank'));?></div>

        <div class="text">
            <?php if ($model->age) echo $model->age, ' ', Yii::t('app', 'год|года|лет|года', $model->age),','; ?>
            <?=$model->countryCity;?>
        </div>
        <b class="qw"><?=($countphotos > 0 ? $countphotos : 'Нет') . ' фото'?></b>
        <span class="presence <?=$lastvisit['status']?>"><?=$lastvisit['text']?></span>
    </div>
    <div class="munread"><?= !$new?'': CHtml::link( Yii::t('app','{n} новое |{n} новых |{n} новых',$new)
        ,array('/anketa/messages','id'=>$k,'#'=>'message-_message-form'));?></div>
    <div class="mtotal"><?= CHtml::link( Yii::t('app','{n} сообщение |{n} сообщения |{n} сообщений',$cnt)
        ,array('/anketa/messages','id'=>$k));?>
        <br/> Последнее: <?=date('d.m.Y в H:i ',$message['last_time']); ?></div>
    <div class="umessagetext"><?php echo $message->message ?></div>
    <? } ?>
</div><br clear="left"/>
<?php } ?>
<span class="left moveto">Переместить в папку:&nbsp;</span> <?php echo CHtml::dropDownList('folder',null,CHtml::listData($folders,'id','name'))?> &nbsp;
<?php echo CHtml::submitButton('Переместить',array('class'=>'blue-button')); ?>
<?php echo CHtml::endForm(); ?>
</div>
    <br clear="all"/><br/>
<script type="text/javascript">
    function checkMessageForm(){
        if ($('input[name="id[]"]:checked').size()==0) {
            alert ('Следует выбрать переписки для перемещения');
            return false;
        }
        return true;
    }
</script>
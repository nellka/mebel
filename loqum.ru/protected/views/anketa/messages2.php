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
<div style="width:760px;float:left;" id="message-list-sort">
<?php echo CHtml::beginForm(array('anketa/sortMessages'),'post',array('onsubmit'=>'js:return checkMessageForm();')); ?>
<?php foreach($messages as $k=> $message) {
    $anketa = $users[$k];
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
        <span class="uname"><?=$anketa->name?></span> <br/>
        <b>Пользователь удалён</b><br/>
        <?= CHtml::link( Yii::t('app','Архив сообщений')
            ,array('/anketa/messages','id'=>$k));?>
    </div>
    <div class="munread"><?= !$new?'': CHtml::link( Yii::t('app','{n} новое |{n} новых |{n} новых',$new)
        ,array('/anketa/messages','id'=>$k,'#'=>'message-_message-form'),array('target'=>'_blank'));?></div>
    <? } else { ?>
    <div class="minfo">
    <span class="uname">
        <?php echo CHtml::link($anketa->name, array('/anketa/view', 'id' => $k),array('target'=>'_blank'))?>
        <?=CHtml::image($anketa->genderIcon, '')?>
    </span><br/>
        Возраст: <?=$anketa->age?><br/>
        <?=$anketa->country . ', ' . $anketa->city;?><br/>
        Ищу: <?=CHtml::image($anketa->getGenderIcon(false))?> Фото: <?=count($anketa->photos)?><br/>
        <? /*<span class="umdate"> последнее сообщение <?php echo date('d.m.Y H:i',$message['datestamp']); ?></span> */ ?>
        <?=$anketa->getLastVisitInfo(); ?>
    </div>
    <div class="munread"><?= !$new?'': CHtml::link( Yii::t('app','{n} новое |{n} новых |{n} новых',$new)
        ,array('/anketa/messages','id'=>$k,'#'=>'message-_message-form'));?></div>
    <div class="mtotal"><?= CHtml::link( Yii::t('app','{n} сообщение |{n} сообщения |{n} сообщений',$cnt)
        ,array('/anketa/messages','id'=>$k));?></div>
    <div class="umessagetext"><?php echo $message->message ?></div>
    <? } ?>

</div><br clear="left"/>
<?php } ?>
Переместить в папку: <?php echo CHtml::dropDownList('folder',null,CHtml::listData($folders,'id','name'))?> &nbsp;
<?php echo CHtml::submitButton('Переместить',array('class'=>'blue-button')); ?>
<?php echo CHtml::endForm(); ?>
</div>
<script type="text/javascript">
    function checkMessageForm(){
        if ($('input[name="id[]"]:checked').size()==0) {
            alert ('Следует выбрать переписки для перемещения');
            return false;
        }
        return true;
    }
</script>
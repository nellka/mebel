<?php /** @var $data Request */
$anketa = $data->user;
$me = Yii::app()->user->me;
?>
<div style="width:360px; border:solid 1px #fff; padding:0px; float:left;" class="messagelist">
<div class="mphoto">
    <span class="messagephoto">
    <?php echo
    $anketa->isdeleted ? CHtml::image($anketa->mainPhotoUrl, $anketa->name) :
        CHtml::link(CHtml::image($anketa->mainPhotoUrl, $anketa->name),
            $anketa->link,array('target'=>'_blank'));
    ?>
    </span>
</div>
<div class="minfo" style="width:250px;">
    <?php if ($anketa->isdeleted) { ?>
        <span class="uname black"><?=$anketa->publicName?></span><br/>
        <b>Пользователь удалён</b>
    <? } else { ?>
        <span class="uname">
        <?php echo CHtml::link( $anketa->publicName,array('/anketa/view','id'=>$anketa->id),array('target'=>'_blank'))?>, <?=$anketa->age?>
            <?=CHtml::image($anketa->genderIcon,'')?></span><br/>
        <?=$anketa->getCountryCity();?><br/>
        <? /*<span class="umdate"> последнее сообщение <?php echo date('d.m.Y H:i',$message['datestamp']); ?></span> */ ?>
        <?=$anketa->getLastVisitInfo(); ?>
    <? } ?>
</div>
</div>
<!-- Right -->

<div style="width:500px; margin-left:20px; padding:0px; float:left; border:none">
    <div id="messagesBlock" style="min-height:50px;">
        <?php /** @var $message Message */

                $current = $data->user;
                $class="";


            ?>
            <div class="umsg" style="border:none;">
                Заинтересовался<br/>
                <span class="umsgdate"><?php echo date('в H:i',$data->time); ?></span><br/>
            </div>
        <?php if ($me->gender == Anketa::GENDER_WOMAN) : ?>
            <div class="request_answer" id="ra<?=$data->id?>">
                <?php if ($tmp = Request2anketa::checkAnswer($data->id) === null) { ?>
                    Вам интересно? <input type="button" class="request_answer yes on" value=""/>
                    <input type="button" class="request_answer yes off" value=""/>
                <?php } elseif (!$tmp) { ?>
                    <span class="red">Заявка отклонена</span> <input style="margin-left:100px;" type="button"
                                                                     value="Отменить выбор"/>
                <?php } else { ?>
                    <span class="green">Заявка уже отмечена</span> <input style="margin-left:100px;" type="button"
                                                                          value="Отменить выбор"/>
                <?php } ?>
            </div>
        <?php endif; ?>
    </div> <!-- messagesBlock -->
    </div>
<br clear="all"/>
<?php

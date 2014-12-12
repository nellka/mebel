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
    <?php if ($anketa->isdeleted) { $anketa->disableRequests(); ?>
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

<div style="width:500px; margin-left:20px; padding:10px; float:left; border:solid 1px #ccc;">
    <div id="messagesBlock" style="min-height:50px;">
        <?php /** @var $message Message */

                $current = $data->user;
                $class="";


            ?>
            <div class="umsg" style="border:none;">
                <img src="/images/icon/icon_message.gif" alt=""/>
                <?php echo CHtml::link( $current->publicName,$anketa->isdeleted?'#':array('/anketa/view','id'=>$anketa->id),array('class'=>'msg'.$class,'target'=>'_blank')); ?>
                <span class="umsgdate"><?php echo date('d.m.Y H:i',$data->time_start); ?></span><br/>
                <div class="umsgtext<?=" $class"?>"><?php echo nl2br($data->text) ?></div>
            </div>
        <?php if ($me->gender == Anketa::GENDER_MAN) : ?>
            <div class="request_answer" id="ra<?=$data->id?>">
            <?php /* if (!Request2anketa::checkAnswer($data->id)) { ?>
                Вам интересно? <input type="button" class="on" value="Мне интересно!"/>
            <?php } else { ?>
                <span class="green">Сообщение мужчине отправлено</span> <input style="margin-left:100px;" type="button"
                                                                      value="Отменить выбор"/>
            <?php } */ ?>

                <?php if (($tmp = Request2anketa::checkAnswer($data->id)) === false) { ?>
                    Вам интересно? <input type="button" class="request_answer yes on" value=""/>
                    <input type="button" class="request_answer no off" value=""/>
                <?php } elseif (!$tmp) { ?>
                    <span class="red">Вы отказались</span> <input style="margin-left:100px;" type="button"
                                                                     value="Отменить выбор"/>
                <?php } else { ?>
                    <span class="green">Сообщение отправлено</span> <input style="margin-left:100px;" type="button"
                                                                          value="Отменить выбор"/>
                <?php } ?>

            </div>
        <?php endif; ?>
    </div> <!-- messagesBlock -->
    </div>
<br clear="all"/>
<?php

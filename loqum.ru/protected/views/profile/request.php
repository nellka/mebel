<?php
$me = Yii::app()->user->me;
$this->pageTitle = 'Заявки';

// форма заявки для мужчин
if ($me->gender == Anketa::GENDER_MAN)
    $this->renderPartial('request/_form', array('model'=>$request));

// отклики на заявку
if ($me->gender == Anketa::GENDER_MAN) {
    if ($request->answers) {
        echo CHtml::tag('h2',array(),'Кто уже заинтересовался?');
        foreach ($request->answers as $answer)
            $this->renderPartial('request/_answer',array('data'=>$answer));
    }
}

echo CHtml::tag('h2',array(),'Все заявки'.($me->gender == Anketa::GENDER_WOMAN ? ' ':'').' - '.$me->city);

if ($me->gender == Anketa::GENDER_WOMAN)
    echo 'Нажмите &laquo;Мне интересно&raquo; под заявкой - партнер получит сообщение об этом (контакты не тратятся)';

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>false,
    'ajaxUrl'=>false,
    'itemView'=>'request/_item',
    'emptyText'=>'Активных заявок нет',
    'summaryText'=>'Всего заявок: {count}',
    'pager'=>array(
        'nextPageLabel' => '&raquo;',
        'prevPageLabel' => '&laquo;',
    ),
));    ?>
<script type="text/javascript">
    $('.request_answer').on('click','input',function() {
        inputDefault = 'Вам интересно? <input type="button" class="request_answer yes on" value=""/> <input type="button" class="request_answer no off" value=""/>';
        inputOff = '<span class="green">Сообщение отправлено</span> <input style="margin-left:100px;" type="button" value="Отменить выбор"/>';
        inputOn = '<span class="red">Вы отказались</span> <input style="margin-left:100px;" type="button" value="Отменить выбор"/>';
        on=0;
        var newText;
        if ($(this).hasClass('on')) {
            newText = inputOff;
            on = 1;
        } else if ($(this).hasClass('off')) {
            newText = inputOn;
            on = -1;
        } else {
            newText = inputDefault;
            on = 0;
        }

        pt = $(this).parent('.request_answer');
        idr = pt.attr('id').substr(2);
        $.post('/profile/requestMark',{id_request:idr,on:on}, function(data){
            pt.html(newText);
        })
    })
</script>
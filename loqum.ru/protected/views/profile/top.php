<?php
$this->pageTitle = 'Топ';
//$this->layout = '//layouts/column2left';
$this->renderPartial('_menu');

$this->breadcrumbs=array(
    'Профиль'=>array('/profile'),
    'Топ',
);?>


<h1>ТОП (закрепление анкеты вверху поиска)</h1>
<?php if ($me->top) { ?>
<p class="pink">Услуга ТОП оплачена до <?=date('d.m.Y H:i',$me->top_end->time_task)?></p>
<? } ?>
<p>Стоимость 250 рублей/2 недели, 400 руб - месяц.</p><p>
    При закреплении в ТОП:</p><p>
<ul>
    <li>ваша анкета будет всегда вверху </li>
    <li>будет показываться при любом поиске в пределах города
        <span class="pink">игнорируя критерии возраста и последнего посещения</span>
    </li>
</ul>

<?php
$wasTop = $me->top;
$me->top = 1;
$dataProvider = new CArrayDataProvider(array(0=>$me));
$this->renderPartial('//anketa/_list',array('dataProvider'=>$dataProvider,'itemview'=>'//anketa/_simplerow'));
$me->top = $wasTop;
?>

<div style="float:left;width:48%">
    <p class="service-top">ТОП 2 недели - 250 рублей.</p>
    <?php if ($me->balance >= 250) { ?>
    <p>У вас на счету <span class="green">достаточно денег</span></p>
    <form method="post" action="/profile/orderService">
        <input type="hidden" name="service" value="2"/>
        <input type="submit" class="blue-button" value="В ТОП на 2 недели"/>
    </form>
    <? } else { ?>
    <p>У вас на счету <span class="pink">недостаточно денег</span></p>
    <?php $this->widget('BillingFormWidget', array('amount' => 250)); ?>
    <? } ?>
</div>
<div style="float:left;width:48%">
    <p class="service-top">ТОП месяц - 400 рублей.</p>
    <?php if ($me->balance >= 400) { ?>
    <p>У вас на счету <span class="green">достаточно денег</span></p>
    <form method="post" action="/profile/orderService">
        <input type="hidden" name="service" value="3"/>
        <input type="submit" class="blue-button" value="В ТОП на месяц"/>
    </form>
    <? } else { ?>
    <p>У вас на счету <span class="pink">недостаточно денег</span></p>
    <?php $this->widget('BillingFormWidget', array('amount' => 400)); ?>
    <? } ?>
    <br/>
</div>
<br clear="all"/><br>
<p>
    Оплатить "ТОП" можно вперед на любой срок. В этом случае проплаченные периоды суммируются.</p><p>
    Место в топе определяется согласно месту в поиске среди анкет, оплативших ТОП. </p><p>
    Чтобы быть первым в "ТОП" необходимо воспользоваться поднятием анкеты
</p>


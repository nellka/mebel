<?php $this->renderPartial('_menu'); ?>
<?php
$this->breadcrumbs = array(
    'Профиль' => array('/profile'),
    'Платные возможности',
);?>
<h1>Платные возможности</h1>

<?php $this->renderPartial('_serviceup',array('anketa'=>$model)); ?>
<p>Подъем анкеты</p>
<p>Стоимость подъема анкеты - 100 рублей.</p><p>
    Поднятие сделает вашу анкету в поиске первой после анкет из раздела "ТОП".</p><p>
    Также поднятие анкеты сделает вашу анкету в категории "ТОП" первой, если вы уже оплатили "ТОП"</p><p>
</p>


<p><b>ТОП (закрепление анкеты вверху поиска)</b></p>
<?php if ($model->top) { ?>
<p class="pink">Услуга ТОП оплачена до <?=date('d.m.Y H:i',$model->top_end->time_task)?></p>
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
$model->top = 1;
$dataProvider = new CArrayDataProvider(array(0=>$model));
//$m2 = new Anketa;
//$m2->id = $model->id;
//$dataProvider = $model->search();
$this->renderPartial('//anketa/_list',array('dataProvider'=>$dataProvider,'itemview'=>'//anketa/_simplerow'));
//$this->renderPartial('/anketa/_list',array('dataProvider'=>new CArrayDataProvider(array(0=>$model))));
?>

<div style="float:left;width:48%">
    <p class="service-top">ТОП 2 недели - 250 рублей.</p>
    <?php if ($model->balance >= 250) { ?>
    <p>У вас на счету <span class="green">достаточно денег</span></p>
    <form method="post" action="/profile/orderService">
        <input type="hidden" name="service" value="2"/>
        <input type="submit" class="blue-button" value="В ТОП на 2 недели"/>
    </form>
    <? } else { ?>
    У вас на счету <span class="pink">недостаточно денег</span><br><br>
    <?php $this->widget('BillingFormWidget', array('amount' => 250)); ?>
    <? } ?>
</div>
<div style="float:left;width:48%">
    <p class="service-top">ТОП месяц - 400 рублей.</p>
    <?php if ($model->balance >= 400) { ?>
    У вас на счету <span class="green">достаточно денег</span>
    <form method="post" action="/profile/orderService"><br>
        <input type="hidden" name="service" value="3"/>
        <input type="submit" class="blue-button" value="В ТОП на месяц"/>
    </form>
    <? } else { ?>
    У вас на счету <span class="pink">недостаточно денег</span><br><br>
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
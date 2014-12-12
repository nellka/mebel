<?php
$this->pageTitle = 'Премиум-аккаунт';
//$this->layout = '//layouts/column2left';
$this->renderPartial('_menu');
$prices = array(
    '3days'=>ServiceManager::getPrice(ServiceManager::SERVICE_PREMIUM_3DAYS),
    'small'=>ServiceManager::getPrice(ServiceManager::SERVICE_PREMIUM_SMALL),
    'big'=>ServiceManager::getPrice(ServiceManager::SERVICE_PREMIUM_BIG),
    '3daysCharge'=>ServiceManager::getPriceCharge(ServiceManager::SERVICE_PREMIUM_3DAYS),
    'smallCharge'=>ServiceManager::getPriceCharge(ServiceManager::SERVICE_PREMIUM_SMALL),
    'bigCharge'=>ServiceManager::getPriceCharge(ServiceManager::SERVICE_PREMIUM_BIG),
);
$show3col = false;
$show3col = $me->first_visit > ServiceManager::TIME_RISE; //$me->id == 4932797 || $me->id == 4932794;

$this->breadcrumbs=array(
    'Профиль'=>array('/profile'),
    'Премиум-аккаунт',
);?>
<h1>Премиум аккаунт</h1>
<?php if ($me->premium): ?>
    <p><span class="pink">Премиум аккаунт оплачен до <? echo date('d.m.Y H:i:s',$me->premium_end->time_task) ?></span></p>
<?php endif; ?>
<h3>Мужчинам</h3>

<p>Для общения с девушками необходимо оплачивать премиум-аккаунт.<br>
Пробный аккаунт, который вы получили после регистрации действует 36 часов. В течение этого времени вы можете решить, интересно вам общение на нашем сайте или нет.<br>
Без премиум аккаунта ваша анкета остаётся в поиске, вы можете получать сообщения, но отвечать не сможете.<br>
Эта услуга в том числе и для вашего удобства. Мы отсекаем праздных посетителей и спамеров.</p>

<h3>Девушкам</h3>
<p>Премиум-аккаунт для девушек необходим для общения с другими девушками. Другой необходимости в нём в настоящий момент нет.</p>

<h2>Купить премиум аккаунт.</h2>
<p>
Стоимость:
    <?=$show3col ? $prices['3days'] . ' рублей - 3 дня, ' : ''; ?>
    <?=$prices['small']?> рублей - 2 недели,
    <?=$prices['big']?> рублей - месяц.<br>
1. При покупке премиум-аккаунта во время действия пробного аккаунта всё неизрасходованное время добавляется к времени действия премиум аккаунте в <span class="pink">двойном</span> размере.<br>
2. При продлении премиум аккаунта оплаченный период добавляется к имеющемуся. Таким образом оплаченные периоды не теряются.<br>
</p>
<?php $model = $me; $w = 48; // refuck ?>
<?php if ($show3col): $w = 33; ?>
<div style="float:left;width:<?=$w?>%">
    <p class="service-top">Премиум 3 дня - <?=$prices['3days']?> рублей.</p>
    <?php if ($model->balance >= $prices['3days']) { ?>
    <p>У вас на счету <span class="green">достаточно денег</span></p>
    <form method="post" action="/profile/orderService">
        <input type="hidden" name="service" value="6"/>
        <input type="submit" class="blue-button" value="ПРЕМИУМ 3 дня"/>
    </form>
    <? } else { ?>
    У вас на счету <span class="pink">недостаточно денег</span><br><br>
    <?php $this->widget('BillingFormWidget', array('amount' => $prices['3daysCharge'])); ?>
    <? } ?>
</div>
<?php endif; ?>
<div style="float:left;width:<?=$w?>%">
    <p class="service-top">Премиум 2 недели - <?=$prices['small']?> рублей.</p>
    <?php if ($model->balance >= $prices['small']) { ?>
    <p>У вас на счету <span class="green">достаточно денег</span></p>
    <form method="post" action="/profile/orderService">
        <input type="hidden" name="service" value="4"/>
        <input type="submit" class="blue-button" value="ПРЕМИУМ 2 недели"/>
    </form>
    <? } else { ?>
    У вас на счету <span class="pink">недостаточно денег</span><br><br>
    <?php $this->widget('BillingFormWidget', array('amount' => $prices['smallCharge'])); ?>
    <? } ?>
</div>
<div style="float:left;width:<?=$w?>%">
    <p class="service-top">Премиум месяц - <?=$prices['big']?> рублей.</p>
    <?php if ($model->balance >= $prices['big']) { ?>
    У вас на счету <span class="green">достаточно денег</span>
    <form method="post" action="/profile/orderService"><br>
        <input type="hidden" name="service" value="5"/>
        <input type="submit" class="blue-button" value="ПРЕМИУМ месяц"/>
    </form>
    <? } else { ?>
    У вас на счету <span class="pink">недостаточно денег</span><br><br>
    <?php $this->widget('BillingFormWidget', array('amount' => $prices['bigCharge'])); ?>
    <? } ?>
    <br/>
</div>
<br clear="all"/>


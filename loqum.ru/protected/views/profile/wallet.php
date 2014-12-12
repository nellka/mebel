<?php
$this->pageTitle = 'Кошелек';
//$this->layout = '//layouts/column2left';
$this->renderPartial('_menu');

$this->breadcrumbs=array(
    'Профиль'=>array('/profile'),
    'Кошелек',
);?>
<style>.bold *{font-weight: bold;text-align:left;}
.bold td {font-size:12px;}
</style>
<h1>Кошелек</h1>
<h2 align="center">Состояние счёта: <span class="pink"><?=$anketa->balance ?> рублей</span></h2>
    <div style="width:320px; float:right;">
        <p>
            <strong style="font-size:18px;">Или</strong></p>
        <p><br>
            <strong>Вы можете пополнить кошелек через </strong><br>
            <strong>любой терминал, отправив деньги на</strong><br>
            <strong>наш счет в системе Яндекс.Деньги</strong></p>

        <p>
            <strong>Номер счета:</strong> <strong class="pink">4100137817137</strong></p>

        <p>
            <strong>После оплаты напишите <a href="/anketa/4932794"> администратору</a></strong><br>
            <strong>сумму, дату и номер платежа.</strong></p>
        <p>
            <strong>Обратите внимание на то, что во многих терминалах взымается комиссия.</strong></p>

    </div>
<? /* padding-left:150px;background: url(/images/design/billing-wallet.jpg) 5px 5px no-repeat */ ?>
<div style="">
    <?php $this->widget('BillingFormWidget',array('amount'=>300)); ?>
        <br><br>
    <table class="bold" style="width:380px;">
        <tr>
            <td>Пластиковые карты</td>
            <td><!--QIWI - временно недоступно--></td>
            <td>Со счета мобильного</td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="1" align="center"><img src="/images/design/billing-paysystems-1-1.png"/></td>
            <td colspan="1" align="center"><!--img src="/images/design/billing-paysystems-1-2.png"/--></td>
            <td colspan="1" align="center"><img src="/images/design/billing-paysystems-1-3.png"/></td>
        </tr>
        <tr>
            <td colspan="3"><br><br>Пополнение с помощью электронных систем</td>
        </tr>
        <tr>
            <td colspan="3"><div style="width:280px; overflow: hidden;"><img src="/images/design/billing-paysystems-2.jpg"/><br></div></td>
        </tr>
    </table>

</div>
    <br clear="all"/>

<div style="width:47%;float:left;"><h2 style="margin-bottom: 0;">Поступления</h2>
    <?php
    $transaction = new Btransaction;
    $transaction->id_user = Yii::app()->user->id;
    $transaction->amount = '>0';
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transaction-grid',
    'dataProvider'=>$transaction->searchFront(),
    'ajaxVar' => false,
        'emptyText'=>'Поступлений не было',
        'summaryText'=>'',
    //'filter'=>false,
	'columns'=>array(
        array(
            'value'=>'$row+1',
            'header'=>'#',
        ),
        array(
            'name'=>'amount',
            'cssClassExpression'=>'"sum"',
        ),

        array(
            'value'=>'date("d.m.Y H:i",$data->time_start)',
            'header'=>'Дата',
        ),
        'description',
        ),
    ));
?>
</div>
<div style="width:47%;margin-left:20px;float:left;"><h2 style="margin-bottom: 0;">Списания</h2>
    <?php
    $transaction->amount = '<0';
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'transaction-grid',
        'dataProvider'=>$transaction->searchFront(),
        'ajaxVar' => false,
        'emptyText'=>'Списаний не было',
        'summaryText'=>'',
        //'filter'=>false,
        'columns'=>array(
            array(
                'value'=>'$row+1',
                'header'=>'#',
            ),
            array(
                'name'=>'amount',
                'cssClassExpression'=>'"sum"',
            ),
            array(
                'value'=>'date("d.m.Y H:i",$data->time_start)',
                'header'=>'Дата',
            ),
            'description',
        ),
    ));
    ?>
</div>
<br clear="all">
<?php
$this->pageTitle = 'Кошелек';
$this->layout = '//layouts/column2left';
$this->renderPartial('//anketa/_menu');
?>
<style>.bold *{font-weight: bold;text-align:left;}
.bold td {font-size:12px;}
</style>
<h1>Кошелек</h1>
<div style="padding-left:150px;background: url(/images/design/billing-wallet.jpg) 5px 5px no-repeat">
<h2>Состояние счёта: <span class="pink"><?=500 ?> рублей</span></h2>
    <form method="post" action="/payment">
        <input type="text" name="amount" value="100" style="width:50px;height:22px;"/> руб.
        <input type="submit" value="" style="cursor:pointer;background: url(/images/design/billing-purchase-button.jpg) left top no-repeat; width:161px; height: 25px; border:none;" />
    </form>
        <br><br>
    <table class="bold" style="width:450px;">
        <tr>
            <td>Пластиковые карты</td>
            <td>Платежная система QIWI</td>
            <td>Со счета мобильного</td>
        </tr>
        <tr>
            <td colspan="3"><img src="/images/design/billing-paysystems-1.jpg"/><br></td>
        </tr>
        <tr>
            <td colspan="3"><br><br>Пополнение с помощью электронных систем</td>
        </tr>
        <tr>
            <td colspan="3"><img src="/images/design/billing-paysystems-2.jpg"/><br></td>
        </tr>
    </table>

</div>

<div style="width:45%;float:left;"><h2>Поступления</h2>
    Поступлений не было
</div>
<div style="width:45%;float:left;"><h2>Списания</h2>
    Списаний не было
</div>
<br clear="all">
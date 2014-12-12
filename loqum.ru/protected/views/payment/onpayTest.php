<form method="get" action="https://secure.onpay.ru/pay/atolin_ru">
    <input type="text" name="price" value="100"/>
    <input type="hidden" name="pay_mode" value="free"/>
    <!--input type="hidden" name="ticker" value="TST"/-->
    <input type="hidden" name="f" value="7"/>
    <input type="hidden" name="pay_for" value="<?=Yii::app()->user->id;?>"/>
    <input type="hidden" name="user_email" value="<?=Yii::app()->user->me->email?>"/>
    <input type="hidden" name="url_fail" value="http://atolin.ru/payment/fail"/>
    <input type="hidden" name="url_success" value="http://atolin.ru/payment/ok"/>
    <input type="hidden" name="" value=""/>
    <input type="submit" value="Пополнить счёт"/>
</form>

<iframe src="https://secure.onpay.ru/pay/atolin_ru?price=100&pay_mode=free&f=7&pay_for=<?=Yii::app()->user->id;?>&user_email=<?=Yii::app()->user->me->email?>&url_fail=http%3A%2F%2Fatolin.ru%2Fpayment%2Ffail&url_success=http%3A%2F%2Fatolin.ru%2Fpayment%2Fok"
    width="600" height="1100"/>
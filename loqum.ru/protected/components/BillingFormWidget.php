<?php

class BillingFormWidget extends CWidget
{
    public $amount = 100;
    public $payment_id;

    public function init(){
        parent::init();
        if (empty($payment_id) && !Yii::app()->user->isGuest)
            $this->payment_id = Yii::app()->user->id.'-'. time(); // счёт предварительно сформированный
    }

    public function run()
    {
        return;
        Yii::import('ext.payment.*');
        $interkassa = new Interkassa();

        $interkassa->setOptions(array(
            'ik_shop_id'=>Yii::app()->params['ik_shop_id'],
            'ik_secret_key'=>Yii::app()->params['ik_secret_key'],
            'ik_payment_amount'=>$this->amount,
            'ik_payment_id'=> $this->payment_id,
            'ik_payment_desc'=>'Пополнение счета аккаунт №'.(Yii::app()->user->id?Yii::app()->user->id:' GUEST ACCOUNT ') ,//.Yii::app()->user->id,
            'submit_button' =>'<input type="submit" class="blue-button" value="Пополнить счет"/>'
        ));
        $output = $interkassa->getForm();
        echo $output;
        //$this->render('billingForm',$output);
    }
}
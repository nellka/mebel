<?php
class Interkassa {

    public $ik_payment_url = 'https://www.interkassa.com/lib/payment.php';
    //public $ik_shop_id = '32791A0A-7E03-5375-DA48-03C06078FBA9';
    public $ik_payment_amount = 0;
    public $ik_payment_id = 0;
    public $ik_payment_desc = '';
    public $submit_button = '<input type="submit" name="process" value="Оплатить">';

    private static $ik_shop_id = '32791A0A-7E03-5375-DA48-03C06078FBA9';
    private static $ik_secret_key;

    public function getForm(){
        return '<form name="payment" action="'.$this->ik_payment_url.'" method="post"
enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
<input type="hidden" name="ik_shop_id" value="'.self::$ik_shop_id.'">
<input type="text" size=2 name="ik_payment_amount" value="'.$this->ik_payment_amount.'"> руб.'
.(isset ($this->ik_paysystem_alias) ?
'<input type="hidden" name="ik_paysystem_alias" value="'.$this->ik_paysystem_alias.'">':'').
'
<input type="hidden" name="ik_payment_id" value="'.$this->ik_payment_id.'">
<input type="hidden" name="ik_payment_desc" value="'.$this->ik_payment_desc.'">
'.$this->submit_button.'
</form>';
    }

    public function checkPayment(){
        $data = array(
            'ik_shop_id' => self::$ik_shop_id,
            'ik_payment_amount' => $this->ik_payment_amount,
            'ik_payment_id' => $this->ik_payment_id,
            'ik_paysystem_alias' => $this->ik_paysystem_alias,
            'ik_baggage_fields' => $this->ik_baggage_fields,
            'secret_key' => self::$ik_secret_key,
        );

        $str = implode($data, ':');
        $signature = md5($str);
        $data['ik_payment_desc'] = $this->ik_payment_desc;
        $data['ik_sign_hash'] = $signature;
        unset($data['secret_key']);
        return $data;
    }

    public function setOptions( $opt = array() )
    {
        if ( !isset( $opt['ik_shop_id'] ) || !isset( $opt['ik_secret_key'] )) die("No params");
        self::$ik_shop_id = $opt['ik_shop_id'];
        self::$ik_secret_key = $opt['ik_secret_key'];
        unset( $opt['ik_shop_id'], $opt['ik_secret_key'] );
        if ( count($opt) === 0 ) return $this;
        foreach ( $opt as $k => $v) $this->$k = $v;
        return $this;
    }



}
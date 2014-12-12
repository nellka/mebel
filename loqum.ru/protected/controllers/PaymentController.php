<?php // http://www.interkassa.com/lib/paysystems.currencies.export.php
class PaymentController extends Controller
{
    public $defaultAction='interkassa';
    /**
     * TODO Переписать после тестирования
     * @return bool
     */
    public function beforeAction(){
        return true;
    }

    public function createTransaction($data){
        $transaction = new Btransaction();
        $transaction->amount = isset ($data['amount']) ? (int) $data['amount'] : 100;
        $transaction->id_user = Yii::app()->user->id;
        $transaction->id_operation = 1;
        $transaction->time_start = time();
        if ($transaction->save())
            return $transaction;
        else {
            print_r ($transaction->getErrors());
            die ();
            throw new CHttpException(404,'Ошибка при создании транзакции');
        }
    }

    public function actionInterkassa()
    {
        Yii::import('ext.payment.*');
        $interkassa = new Interkassa();
        $amount = 10;
        $payment_id = Yii::app()->user->id.'-'. time(); // счёт предварительно сформированный
        if (!empty ($_POST)) {
            $_POST['amount'] = (int) $_POST['amount'];
            if (empty($_POST['amount']))
                throw new CHttpException(403,'Ошбочная сумма');
            $transaction = $this->createTransaction($_POST);
            Yii::app()->user->setState('id_transaction',$transaction->id);
            $this->refresh();
        }
        if ($id_transaction = Yii::app()->user->getState('id_transaction')) {
            if (!$transaction = Btransaction::model()->findByPk($id_transaction))
                throw new CHttpException('404','Неверная информация о тразакции');
            $amount = $transaction->amount;
            $payment_id = $transaction->id;
        }

        $interkassa->setOptions(array(
            'ik_shop_id'=>Yii::app()->params['ik_shop_id'],
            'ik_secret_key'=>Yii::app()->params['ik_secret_key'],
            'ik_payment_amount'=>$amount,
            'ik_payment_id'=> $payment_id,
            'ik_payment_desc'=>'Пополнение счета аккаунт №'.(Yii::app()->user->id?Yii::app()->user->id:' GUEST ACCOUNT ') ,//.Yii::app()->user->id,
        ));
        $output = $interkassa->getForm();
        $this->render('interkassa',compact('output'));
    }

    public function actionInterkassaStatus1(){
        $data = $_POST;
        $data['ik_payment_desc'] = iconv('cp1251','utf-8',$data['ik_payment_desc']);

        if (!$transaction = Btransaction::model()->findByPk($data['ik_payment_id'])) { /** @var $transaction Btransaction */
            $transaction = new Btransaction();
            if (!preg_match('/(\d+)-(\d+)/',$data['ik_payment_id'],$matches)) {
                $data['alert'] = '!unhandled transaction';
                Yii::log('WARNING! IPN notification '.print_r($data,true),'info','payment');
                return;
            }
            $transaction->amount = $data['ik_payment_amount'];
            $transaction->id_user = $matches[1];
            $transaction->id_operation = 1;
            $transaction->time_start = time();
        }

            $transaction->amount_real = $data['ik_payment_amount'];
            $transaction->time_end = time();
            $transaction->status = 1;
            $transaction->info = serialize($data);
            $transaction->description = 'Пополнение счета'; // прикрутить разбор "картой"
            $transaction->save(false);
            if ($user = $transaction->user) {
                $user->balance += $transaction->amount_real;
                $user->contact_count += floor($transaction->amount_real / 10);
                $user->saveAttributes(array('balance','contact_count'));
                //$user->con
            }
        Yii::log('IPN notification '.print_r($data,true),'info','payment');
    }

    public function actionInterkassaYandexDengi()
    {
        Yii::import('ext.payment.*');
        $interkassa = new Interkassa();
        $amount = 10;
        $interkassa->setOptions(array(
            'ik_shop_id'=>Yii::app()->params['ik_shop_id'],
            'ik_secret_key'=>Yii::app()->params['ik_secret_key'],
            'ik_payment_amount'=>$amount,
            'ik_paysystem_alias'=>'yandexdengir',
            'ik_payment_id'=>time(), // счёт предварительно сформированный
            'ik_payment_desc'=>'Пополнение счета аккаунт №'.(Yii::app()->user->id?Yii::app()->user->id:' GUEST ACCOUNT ') ,//.Yii::app()->user->id,
        ));
        $output = $interkassa->getForm();
        //$output = '1';
        $this->render('interkassa',compact('output'));
    }


    public function actionOnpayTest(){
        Yii::import('ext.payment.*');
        $onpay = new Onpay('other_db','atolin_ru','3dNXOO4lPAN');
        $this->render('onpayTest');
    }

    /**
     * onpay status
     * @link http://wiki.onpay.ru/doku.php?id=api-notify
     * @link http://wiki.onpay.ru/doku.php?id=payment-links-specs
2013/11/21 01:18:36 [info] [payment] IPN notification Array
(
    [type] => check
    [amount] => 100.0
    [order_amount] => 100.0
    [order_currency] => TST
    [pay_for] => 4932797
    [md5] => B6C80B7F925CD99C1CC8B35AEE6F8630
)
    2013/11/21 01:33:39 [info] [payment] IPN notification Array
    (
    [type] => check
    [amount] => 100.0
    [order_amount] => 100.0
    [order_currency] => TST
    [pay_for] => 4932797
    [md5] => B6C80B7F925CD99C1CC8B35AEE6F8630
    )
     *
    2013/11/21 01:39:59 [info] [payment] IPN notification Array
    (
    [type] => pay
    [onpay_id] => 7261069
    [amount] => 100.0
    [balance_amount] => 100.0
    [balance_currency] => TST
    [order_amount] => 100.0
    [order_currency] => TST
    [exchange_rate] => 1.0
    [pay_for] => 4932797
    [paymentDateTime] => 2013-11-21T01:39:59+04:00
    [user_email] => ivan5@iv-an.ru
    [user_phone] =>
    [paid_amount] => 100.0
    [md5] => 99C40DE7B5F231B7E54C59A06A8C0A1C
    )
     *
    2013/11/21 01:50:48 [info] [payment] IPN notification Array
    (
    [type] => check
    [amount] => 100.0
    [order_amount] => 100.0
    [order_currency] => TST
    [pay_for] => 4932797
    [md5] => B6C80B7F925CD99C1CC8B35AEE6F8630
    )
     *
    2013/11/21 01:51:54 [info] [payment] IPN notification Array
    (
    [type] => pay
    [onpay_id] => 7261103
    [amount] => 100.0
    [balance_amount] => 100.0
    [balance_currency] => TST
    [order_amount] => 100.0
    [order_currency] => TST
    [exchange_rate] => 1.0
    [pay_for] => 4932797
    [paymentDateTime] => 2013-11-21T01:51:54+04:00
    [user_email] => ivan5@iv-an.ru
    [user_phone] =>
    [paid_amount] => 100.0
    [md5] => E1532BFA5BB6CA8511F17ECA6B8A1871
    )
     *
    2013/11/21 02:22:17 [info] [payment] IPN notification Array
    (
    [type] => check
    [amount] => 100.0
    [order_amount] => 100.0
    [order_currency] => TST
    [pay_for] => 4932797
    [md5] => B6C80B7F925CD99C1CC8B35AEE6F8630
    [code] => 0
    [d_errors] =>
     *
    2013/11/21 02:22:25 [info] [payment] IPN notification Array
    (
    [type] => pay
    [onpay_id] => 7261193
    [amount] => 100.0
    [balance_amount] => 100.0
    [balance_currency] => TST
    [order_amount] => 100.0
    [order_currency] => TST
    [exchange_rate] => 1.0
    [pay_for] => 4932797
    [paymentDateTime] => 2013-11-21T02:22:25+04:00
    [user_email] => ivan5@iv-an.ru
    [user_phone] =>
    [paid_amount] => 100.0
    [md5] => 4A79BCEF6EC06764ACB973840ACAF863
     *
    2013/11/21 02:27:08 [info] [payment] IPN notification Array
    (
    [type] => check
    [amount] => 100.0


    [order_amount] => 100.0
    [order_currency] => TST
    [pay_for] => 4932797
    [md5] => B6C80B7F925CD99C1CC8B35AEE6F8630
    [code] => 0
    [d_errors] =>
    )

     *
    2013/11/21 02:30:23 [info] [payment] IPN notification Array
    (
    [type] => pay
    [onpay_id] => 7261210
    [amount] => 100.0
    [balance_amount] => 100.0
    [balance_currency] => TST
    [order_amount] => 100.0
    [order_currency] => TST
    [exchange_rate] => 1.0
    [pay_for] => 4932797
    [paymentDateTime] => 2013-11-21T02:30:22+04:00
    [user_email] => ivan5@iv-an.ru
    [user_phone] =>
    [paid_amount] => 100.0
    [md5] => A79B7830ACE5269F076A1E1585CB07F8
 */
    public function actionOnpayStatus1(){
        /** @var $transaction Btransaction */
        $data = $_POST;
/*
        if (!$transaction = Btransaction::model()->findByPk($data['ik_payment_id'])) {
            $transaction = new Btransaction();
            if (!preg_match('/(\d+)-(\d+)/',$data['ik_payment_id'],$matches)) {
                $data['alert'] = '!unhandled transaction';
                Yii::log('WARNING! IPN notification '.print_r($data,true),'info','payment');
                return;
            }
            $transaction->amount = $data['ik_payment_amount'];
            $transaction->id_user = $matches[1];
            $transaction->id_operation = 1;
            $transaction->time_start = time();
        }

        $transaction->amount_real = $data['ik_payment_amount'];
        $transaction->time_end = time();
        $transaction->status = 1;
        $transaction->info = serialize($data);
        $transaction->description = 'Пополнение счета'; // прикрутить разбор "картой"
        $transaction->save(false);
        if ($user = $transaction->user) {
            $user->balance += $transaction->amount_real;
            $user->contact_count += floor($transaction->amount_real / 10);
            $user->saveAttributes(array('balance','contact_count'));
            //$user->con
        }
*/

        Yii::import('ext.payment.*');
        $onpay = new Onpay('other_db','atolin_ru','3dNXOO4lPAN');
        if ($onpay->check_errors($data))
            $data['code'] = 0;
        else {
            if (empty($data['order_amount']))
            $data['code'] = 0;
            else
            $data['code'] = 2;
        }

        $data['d_errors'] = $onpay->error;
        Yii::log('IPN notification '.print_r($data,true),'info','payment');

        if ($data['type']=='pay') {
            $transaction = new Btransaction();
            $transaction->amount = $data['order_amount'];
            $transaction->id_user = $data['pay_for'];
            $transaction->id_operation = 1;
            $transaction->time_start = time();


            $transaction->amount_real = $data['order_amount'];
            $transaction->time_end = time();
            $transaction->status = 1;
            $transaction->info = serialize($data);
            $transaction->description = 'Пополнение счета'; // прикрутить разбор "картой"
            $transaction->save(false);
            if ($user = $transaction->user) {
                $user->balance += $transaction->amount_real;
                $user->contact_count += floor($transaction->amount_real / 10);
                $user->saveAttributes(array('balance','contact_count'));
            }
        }

        echo $onpay->gen_xml_answer($data);
/*
        $code = 0;
        $keys = array(
            'type' => $data['type'] == 'pay' ? 'pay' : 'check', //
            'pay_for'=>$data['pay_for'],
            'order_amount'=>$data['order_amount'],
            'order_ticker'=>$data['order_currency'],
            'code'=>$code,
            'secret_key_for_api_in'=>'3dNXOO4lPAN',
        );
        // md5 - проверка ответа
        // check “type;pay_for;order_amount;order_ticker;secret_key_for_api_in”
        // pay “type;pay_for;onpay_id;order_amount;order_ticker;secret_key_for_api_in”

        //      “type;pay_for;order_amount;order_ticker;code;secret_key_api_in” (без кавычек)
        //     “type;pay_for;onpay_id;order_id;order_amount;order_ticker;code;secret_key_api_in”
        $md5 = implode(';',$keys);
        $md5 = md5($md5);
echo '<?xml version="1.0" encoding="UTF-8"?>
	<result>
		<code>'.$code.'</code>
		<pay_for>'.$data['pay_for'].'</pay_for>
		<comment>OK</comment>
		<md5>'.$md5.'</md5>
	</result>';*/
    }



//    public function actionInterkassaResult()
//    {
//
//    }

    public function actionOk()
    {
//        if (Yii::app()->user->isGuest) {
//            $host = 'atolin.ru';
//            if (strpos($_SERVER['HTTP_HOST'],$host)!==false)
//                $host = 'soderganki-online.ru';
//            $this->redirect("http://$host".$_SERVER['REQUEST_URI']);
//        }
        $this->checkHost();
        $this->render('ok');
    }

    public function actionFail()
    {
        $this->checkHost();
        $this->render('fail');
    }

    public function checkHost(){
        $hosts = array('atolin.ru','soderganki-online.ru','sodeline.ru');
        if (Yii::app()->user->isGuest) {
            $host = false;
            foreach ($hosts as $host) {
                if (strpos($_SERVER['HTTP_HOST'],$host)!==false) {
                    $host = next($hosts);
                    break;
                }
            }
            if ($host)
                $this->redirect("http://$host".$_SERVER['REQUEST_URI']);
            else {
                Yii::log('HOST '.$host.print_r($_SERVER,true),'info','payment');
            }
        }
    }


}
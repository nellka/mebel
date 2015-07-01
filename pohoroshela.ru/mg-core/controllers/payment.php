<?php

class Controllers_Payment extends BaseController {

  public $msg = "";

  function __construct() {
    $this->msg = "";
    $paymentID = URL::getQueryParametr('id');
    $paymentStatus = URL::getQueryParametr('pay');
    $_POST['url'] = URL::getUrl();
    $modelOrder = new Models_Order();

    switch ($paymentID) {
      case 1: //webmoney
        $msg = $this->webmoney($paymentID, $paymentStatus);
        break;
      case 5: //robokassa
        $msg = $this->robokassa($paymentID, $paymentStatus);
        break;
      case 6: //qiwi
        $msg = $this->qiwi($paymentID, $paymentStatus);
        break;
      case 8: //interkassa
        $msg = $this->interkassa($paymentID, $paymentStatus);
        break;
      case 2: //ЯндексДеньги	  
        $msg = $this->yandex($paymentID, $paymentStatus);
        break;
      case 9: //PayAnyWay
        $msg = $this->payanyway($paymentID, $paymentStatus);

      case 10: //PayMastert
        $msg = $this->paymaster($paymentID, $paymentStatus);
        break;

      case 11: //alfabank
        $msg = $this->alfabank($paymentID, $paymentStatus);
        break;
      case 14: //Яндекс.Касса
        $msg = $this->yandexKassa($paymentID, $paymentStatus);
        break;
      case 15: //privat24
        $msg = $this->privat24($paymentID, $paymentStatus);
        break;
    }

    $this->data = array(
      'payment' => $paymentID, //id способа оплаты
      'status' => $paymentStatus, //статус ответа платежной системы (result, success, fail)
      'message' => $msg, //статус ответа платежной системы (result, success, fail)
    );
  }

  /**
   * Действие при оплате заказа
   * Обновляет статус заказа на Оплачен, отправляет письма оповещения, генерирует хук.
   */
  public function actionWhenPayment($args) {
    $result = true;
    ob_start();

    $order = new Models_Order();
    if (method_exists($order, 'updateOrder')) {
      $order->updateOrder(array('id' => $args['paymentOrderId'], 'status_id' => 2));
    }
    if (method_exists($order, 'sendMailOfPayed')) {
      $order->sendMailOfPayed($args['paymentOrderId'], $args['paymentAmount'], $args['paymentID']);
    }
    if (method_exists($order, 'sendLinkForElectro')) {
      $order->sendLinkForElectro($args['paymentOrderId']);
    }

    $content = ob_get_contents();
    ob_end_clean();

    // если в ходе работы метода допущен вывод контента, то записать в лог ошибку.
    if (!empty($content)) {
      MG::loger('ERROR PAYMENT: ' . $content);
    }

    return MG::createHook(__CLASS__ . "_" . __FUNCTION__, $result, $args);
  }

  /**
   * проверка платежа через WebMoney
   */
  public function webmoney($paymentID, $paymentStatus) {
    $order = new Models_Order();
    
    if ('success' == $paymentStatus) {
	
	  if(empty($_POST['LMI_PAYMENT_NO'])){
	    echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
        exit;
	  }
	  
      $orderInfo = $order->getOrder(" id = " . DB::quote($_POST['LMI_PAYMENT_NO'], 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$_POST['LMI_PAYMENT_NO']]['number']; 
      $msg .= $this->msg;
    } elseif ('result' == $paymentStatus && $_POST) {      
      $paymentAmount = trim($_POST['LMI_PAYMENT_AMOUNT']);
      //$paymentAmount = $paymentAmount*1;
      $paymentOrderId = trim($_POST['LMI_PAYMENT_NO']);
      if (!empty($paymentAmount) && !empty($paymentOrderId)) {
        $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
        $paymentInfo = $order->getParamArray($paymentID, $orderInfo['id'], $orderInfo['summ']);
      }

      $payeePurse = $paymentInfo[0]['value'];
      $secretKey = $paymentInfo[1]['value'];
      // предварительная проверка платежа
      if ($_POST['LMI_PREREQUEST'] == 1) {
        $error = false;

        if (empty($orderInfo)) {
          echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
          exit;
        }

        if (trim($_POST['LMI_PAYEE_PURSE']) != $payeePurse) {
          echo "ERR: НЕВЕРНЫЙ КОШЕЛЕК ПОЛУЧАТЕЛЯ " . $_POST['LMI_PAYEE_PURSE'];
          exit;
        }
        echo "YES";
        exit;
      } else {
        // проверка хеша, присвоение нового статуса заказу
        $chkstring = $_POST['LMI_PAYEE_PURSE'] .
          $_POST['LMI_PAYMENT_AMOUNT'] .
          $_POST['LMI_PAYMENT_NO'] .
          $_POST['LMI_MODE'] .
          $_POST["LMI_SYS_INVS_NO"] .
          $_POST["LMI_SYS_TRANS_NO"] .
          $_POST["LMI_SYS_TRANS_DATE"] .
          $secretKey .
          $_POST["LMI_PAYER_PURSE"] .
          $_POST["LMI_PAYER_WM"];
        $md5sum = strtoupper(md5($chkstring));

        if ($_POST['LMI_HASH'] == $md5sum) {
          $this->actionWhenPayment(
            array(
              'paymentOrderId' => $paymentOrderId,
              'paymentAmount' => $paymentAmount,
              'paymentID' => $paymentID
            )
          );
          echo "YES";
          exit;
        } else {
          echo "ERR: Произошла ошибка или подмена параметров.";
          exit;
        }
      }
    } else {
      $msg = 'Оплата не удалась';
    }

    return $msg;
  }

  /**
   * проверка платежа через paymaster
   */
  public function paymaster($paymentID, $paymentStatus) {
    $order = new Models_Order();
    if ('success' == $paymentStatus) {
      $orderInfo = $order->getOrder(" id = " . DB::quote($_POST['LMI_PAYMENT_NO'], 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$_POST['LMI_PAYMENT_NO']]['number']; 
      $msg .= $this->msg;
    } elseif ('result' == $paymentStatus && $_POST) {
      $paymentAmount = trim($_POST['LMI_PAYMENT_AMOUNT']);
      //$paymentAmount = $paymentAmount*1;
      $paymentOrderId = trim($_POST['LMI_PAYMENT_NO']);
      if (!empty($paymentAmount) && !empty($paymentOrderId)) {
        $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
        $paymentInfo = $order->getParamArray($paymentID, $orderInfo['id'], $orderInfo['summ']);
      }

      $payeePurse = $paymentInfo[0]['value'];
      $secretKey = $paymentInfo[1]['value'];

      // предварительная проверка платежа
      if ($_POST['LMI_PREREQUEST'] == 1) {
        $error = false;

        if (empty($orderInfo)) {
          echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
          exit;
        }

        echo "YES";
        exit;
      } else {

        $chkstring = $_POST['LMI_MERCHANT_ID'] . ";" .
          $_POST['LMI_PAYMENT_NO'] . ";" .
          $_POST['LMI_SYS_PAYMENT_ID'] . ";" .
          $_POST['LMI_SYS_PAYMENT_DATE'] . ";" .
          $_POST['LMI_PAYMENT_AMOUNT'] . ";" .
          $_POST['LMI_CURRENCY'] . ";" .
          $_POST['LMI_PAID_AMOUNT'] . ";" .
          $_POST['LMI_PAID_CURRENCY'] . ";" .
          $_POST['LMI_PAYMENT_SYSTEM'] . ";" .
          $_POST['LMI_SIM_MODE'] . ";" .
          $secretKey;

        $md5sum = base64_encode(md5($chkstring, true));

        if ($_POST['LMI_HASH'] == $md5sum) {

          $this->actionWhenPayment(
            array(
              'paymentOrderId' => $paymentOrderId,
              'paymentAmount' => $paymentAmount,
              'paymentID' => $paymentID
            )
          );
          echo "YES";
          exit;
        } else {
          echo "ERR: Произошла ошибка или подмена параметров.";
          exit;
        }
        $msg = 'Оплата не удалась';
      }
    }

    return $msg;
  }

  /**
   * проверка платежа через ROBOKASSA
   */
  public function robokassa($paymentID, $paymentStatus) {
    $order = new Models_Order();
    if ('success' == $paymentStatus) {
      $orderInfo = $order->getOrder(" id = " . DB::quote($_POST['InvId'], 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$_POST['InvId']]['number']; 
      $msg .= $this->msg;
    } elseif ('result' == $paymentStatus && isset($_POST)) {    
      $paymentAmount = trim($_POST['OutSum']);
      $paymentOrderId = trim($_POST['InvId']);
      if (!empty($paymentAmount) && !empty($paymentOrderId)) {
        $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
        $paymentInfo = $order->getParamArray($paymentID, $orderInfo['id'], $orderInfo['summ']);
      }
      // предварительная проверка платежа
      if (empty($orderInfo)) {
        echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
        exit;
      }

      $sMerchantPass2 = $paymentInfo[2]['value'];
      $sSignatureValue = $paymentAmount . ':' . $paymentOrderId . ':' . $sMerchantPass2;
      $md5sum = strtoupper(md5($sSignatureValue));

      if ($_POST['SignatureValue'] == $md5sum) {
        $this->actionWhenPayment(
          array(
            'paymentOrderId' => $paymentOrderId,
            'paymentAmount' => $paymentAmount,
            'paymentID' => $paymentID
          )
        );

        echo "OK" . $paymentOrderId;
        exit;
      }
    } else {
      $msg = 'Оплата не удалась';
    }

    return $msg;
  }

  /**
   * проверка платежа через QIWI
   */
  public function qiwi($paymentID, $paymentStatus) {

    $order = new Models_Order();
    if ('success' == $paymentStatus) {
      $orderInfo = $order->getOrder(" id = " . DB::quote($_GET['order'], 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$_GET['order']]['number']; 
      $msg .= $this->msg;
    } elseif ('result' == $paymentStatus && isset($_POST)) {
      $i = file_get_contents('php://input');

      $l = array('/<login>(.*)?<\/login>/', '/<password>(.*)?<\/password>/');
      $s = array('/<txn>(.*)?<\/txn>/', '/<status>(.*)?<\/status>/');

      preg_match($l[0], $i, $m1);
      preg_match($l[1], $i, $m2);

      preg_match($s[0], $i, $m3);
      preg_match($s[1], $i, $m4);

      $paymentOrderId = $m3[1];

      $statusQiwi = $m4[1];


      if (!empty($paymentOrderId)) {
        $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1));
      } else {
        $orderInfo = NULL;
        echo "Ошибка обработки";
        exit();
      }


      $paymentInfo = $order->getParamArray($paymentID, $paymentOrderId, $orderInfo[$paymentOrderId]['summ']);
      $password = $paymentInfo[1]['value'];

      $parseLog .=
        ' status=' . $statusQiwi .
        ' paymentOrderId=' . $paymentOrderId .
        ' paymentID=' . $paymentID .
        ' summ=' . $orderInfo[$paymentOrderId]['summ'];

      // если заказа не существует то отправляем код 150
      if (empty($orderInfo)) {
        $resultCode = 300;
      } else {

        $hash = strtoupper(md5($m3[1] . strtoupper(md5($password))));

        if ($hash !== $m2[1]) { //сравнение хешей
          $resultCode = 150;
        } else {
          if ($statusQiwi == 60) {// заказ оплачен         
            $this->actionWhenPayment(
              array(
                'paymentOrderId' => $paymentOrderId,
                'paymentAmount' => $orderInfo[$paymentOrderId]['summ'],
                'paymentID' => $paymentID
              )
            );
          }
          $resultCode = 0; // все прошло успешно оправляем "0"
        }
      }
      header('content-type: text/xml; charset=UTF-8');
      echo '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://client.ishop.mw.ru/"><SOAP-ENV:Body><ns1:updateBillResponse><updateBillResult>' . $resultCode . '</updateBillResult></ns1:updateBillResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>';
      exit;
    }

    return $msg;
  }

  /**
   * проверка платежа через Interkassa
   */
  public function interkassa($paymentID, $paymentStatus) {
    $order = new Models_Order();
    if ('success' == $paymentStatus) {
      $orderInfo = $order->getOrder(" id = " . DB::quote($_POST['ik_pm_no'], 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$_POST['ik_pm_no']]['number'];      
      $msg .= $this->msg;
    } elseif ('result' == $paymentStatus && isset($_POST)) {
  
      $paymentAmount = trim($_POST['ik_am']);
      $paymentOrderId = trim($_POST['ik_pm_no']);
      if (!empty($paymentAmount) && !empty($paymentOrderId)) {
        $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
        $paymentInfo = $order->getParamArray($paymentID, $paymentOrderId, $orderInfo[$paymentOrderId]['summ']);
      }
      // предварительная проверка платежа
      if (empty($orderInfo)) {
        echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
        exit;
      }


      $testKey = '*****';
      $normKey = $paymentInfo[1]['value'];

      $signString = $_POST['ik_co_id'];
      $key = $normKey;
      if (!empty($_POST['ik_pw_via']) && $_POST['ik_pw_via'] == 'test_interkassa_test_xts') {
        $key = $testKey;
      }

      $dataSet = $_POST;
      unset($dataSet['url']);
      unset($dataSet['ik_sign']);
      ksort($dataSet, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива 
      array_push($dataSet, $key); // добавляем в конец массива "секретный ключ" 	 
      $signString = implode(':', $dataSet); // конкатенируем значения через символ ":" 
      $sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по

      if ($sign == $_POST['ik_sign']) {
        $this->actionWhenPayment(
          array(
            'paymentOrderId' => $paymentOrderId,
            'paymentAmount' => $orderInfo[$paymentOrderId]['summ'],
            'paymentID' => $paymentID
          )
        );
        echo "200 OK";
        exit;
      } else {
        echo "Подписи не совпадают!";
        exit;
      }
    }
    return $msg;
  }

  /**
   * проверка платежа через Interkassa
   */
  public function payanyway($paymentID, $paymentStatus) {
    $order = new Models_Order();
	
    if ('success' == $paymentStatus) {   
      $orderInfo = $order->getOrder(" id = " . DB::quote($_GET['MNT_TRANSACTION_ID'], 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$_GET['MNT_TRANSACTION_ID']]['number'];
      $msg .= $this->msg;
    } elseif ('result' == $paymentStatus && isset($_POST)) {
     
  	  
	  
      $paymentAmount = trim($_POST['MNT_AMOUNT']);
      $paymentOrderId = trim($_POST['MNT_TRANSACTION_ID']);

      if (!empty($paymentAmount) && !empty($paymentOrderId)) {
        $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
        $paymentInfo = $order->getParamArray($paymentID, $paymentOrderId, $orderInfo[$paymentOrderId]['summ']);
      }

  
      // предварительная проверка платежа
      if (empty($orderInfo)) {
        echo "FAIL";
        exit;
      }

      $testmode = 0;

      // предварительная проверка платежа обработка команды CHECK
      if ($_POST['MNT_COMMAND'] == 'CHECK' && empty($_POST['MNT_OPERATION_ID'])) {
	  
	 
        $summ = sprintf("%01.2f", $orderInfo[$paymentOrderId]['summ']);
        $currency = (MG::getSetting('currencyShopIso') == "RUR") ? "RUB" : MG::getSetting('currencyShopIso');

        $sign = md5($_POST['MNT_COMMAND'] . $paymentInfo[0]['value'] . $paymentOrderId .  $summ . $currency . $testmode . $paymentInfo[1]['value']);
      
		
		
        if ($sign == $_POST['MNT_SIGNATURE']) {
          $signNew = md5('402' . $paymentInfo[0]['value'] . $paymentOrderId . $paymentInfo[1]['value']);
	     $responseXml = '<?xml version="1.0" encoding="UTF-8"?>
		<MNT_RESPONSE>
		<MNT_ID>' . $paymentInfo[0]['value'] . '</MNT_ID>
		<MNT_TRANSACTION_ID>' . $paymentOrderId . '</MNT_TRANSACTION_ID>
		<MNT_RESULT_CODE>402</MNT_RESULT_CODE>
		<MNT_DESCRIPTION>Оплата заказа ' . $paymentOrderId . '</MNT_DESCRIPTION>
		<MNT_AMOUNT>' . $orderInfo[$paymentOrderId]['summ'] . '</MNT_AMOUNT>
		<MNT_SIGNATURE>' . $signNew . '</MNT_SIGNATURE>
		</MNT_RESPONSE>';
          header("Content-type: text/xml");
          echo $responseXml;
          exit;
        } else {
		 
	     echo "Подписи не совпадают!";
          exit;
        }
      } elseif (isset($_POST['MNT_OPERATION_ID'])) {
	
	   
        $summ = sprintf("%01.2f", $orderInfo[$paymentOrderId]['summ']);
        $currency = (MG::getSetting('currencyShopIso') == "RUR") ? "RUB" : MG::getSetting('currencyShopIso');

        $sign = md5($_POST['MNT_COMMAND'] .$paymentInfo[0]['value'] . $paymentOrderId . $_POST['MNT_OPERATION_ID'] . $summ  . $currency . $testmode . $paymentInfo[1]['value']);
      
	    if ($sign == $_POST['MNT_SIGNATURE']) {
		 
          $signNew = md5('402' . $paymentInfo[0]['value'] . $paymentOrderId . $paymentInfo[1]['value']);
		
          $responseXml = '<?xml version="1.0" encoding="UTF-8"?>
		<MNT_RESPONSE>
		<MNT_ID>' . $paymentInfo[0]['value'] . '</MNT_ID>
		<MNT_TRANSACTION_ID>' . $paymentOrderId . '</MNT_TRANSACTION_ID>
		<MNT_RESULT_CODE>402</MNT_RESULT_CODE>
		<MNT_SIGNATURE>' . $signNew . '</MNT_SIGNATURE>
		</MNT_RESPONSE>';

          header("Content-type: text/xml");
          echo $responseXml;

          $this->actionWhenPayment(
            array(
              'paymentOrderId' => $paymentOrderId,
              'paymentAmount' => $orderInfo[$paymentOrderId]['summ'],
              'paymentID' => $paymentID
            )
          );

          exit;
        }
		
      }
    }
    return $msg;
  }

  /**
   * проверка платежа через Yandex
   */
  public function yandex($paymentID, $paymentStatus) {
    $order = new Models_Order();
    if ('success' == $paymentStatus) {      
      $orderInfo = $order->getOrder(" id = " . DB::quote($_POST['label'], 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$_POST['label']]['number'];
      $msg .= $this->msg;
    } elseif ('result' == $paymentStatus && isset($_POST)) {     
      $paymentAmount = trim($_POST['withdraw_amount']);
      $paymentOrderId = trim($_POST['label']);
      if (!empty($paymentAmount) && !empty($paymentOrderId)) {
        $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
        $paymentInfo = $order->getParamArray($paymentID, $paymentOrderId, $orderInfo[$paymentOrderId]['summ']);
      }
      // предварительная проверка платежа
      if (empty($orderInfo)) {
        echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
        exit;
      }

      $secret = $paymentInfo[1]['value'];

      $pre_sha = $_POST['notification_type'] . '&' .
        $_POST['operation_id'] . '&' .
        $_POST['amount'] . '&' .
        $_POST['currency'] . '&' .
        $_POST['datetime'] . '&' .
        $_POST['sender'] . '&' .
        $_POST['codepro'] . '&' .
        $secret . '&' .
        $_POST['label'];

      $sha = sha1($pre_sha);
      if ($sha == $_POST['sha1_hash']) {
        $this->actionWhenPayment(
          array(
            'paymentOrderId' => $paymentOrderId,
            'paymentAmount' => $orderInfo[$paymentOrderId]['summ'],
            'paymentID' => $paymentID
          )
        );
        echo "0";
        exit;
      } else {
        echo "1";
        exit;
      }
    }
    return $msg;
  }
  
  /*
   * проверка платежа через Яндекс.Кассу
   */
  public function yandexKassa($paymentID, $paymentStatus){
    $order = new Models_Order();
    $action = URL::getQueryParametr('action');
    $orderNumber = URL::getQueryParametr('orderNumber');
    
    if($paymentStatus == 'success' && $action == 'PaymentSuccess'){
      $orderInfo = $order->getOrder(" id = " . DB::quote($orderNumber, 1));
      $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$orderNumber]['number'];
      $msg .= $this->msg;
      return $msg;
    }elseif($paymentStatus == 'fail'){
      $orderInfo = $order->getOrder(" id = " . DB::quote($orderNumber, 1));
      $msg = 'При попытке оплаты заказа №'.$orderInfo[$orderNumber]['number'].' произошла ошибка.<br />Пожалуста, попробуте позже или используйте другой способ оплаты';
      $msg .= $this->msg;
      return $msg;
    }
    
    $error = false;
    
    $orderSumAmount = URL::getQueryParametr('orderSumAmount');
    $orderSumCurrencyPaycash = URL::getQueryParametr('orderSumCurrencyPaycash');
    $orderSumBankPaycash = URL::getQueryParametr('orderSumBankPaycash');
    $shopId = URL::getQueryParametr('shopId');
    $invoiceId = URL::getQueryParametr('invoiceId');
    $customerNumber = URL::getQueryParametr('customerNumber');
    $key = URL::getQueryParametr('md5');
    
    $responseXml = '<?xml version="1.0" encoding="UTF-8"?> 
      <checkOrderResponse performedDatetime="'.date('c').'" ';
    
    if(!empty($orderSumAmount) && !empty($orderNumber)) {
      $orderInfo = $order->getOrder(" id = " . DB::quote($orderNumber, 1) . " and summ+delivery_cost = " . DB::quote($orderSumAmount, 1));
      $paymentInfo = $order->getParamArray($paymentID, $orderNumber, $orderInfo[$orderNumber]['summ']);
      $shopPassword = trim($paymentInfo[3]['value']);
      //$shopPassword = 'DGq3F78vd2';
    }else{
      $error = true;
      $responseXml .= 'code="200"
        message="не пришла сумма или номер"';
    }
    
    //action;orderSumAmount;orderSumCurrencyPaycash;orderSumBankPaycash;shopId;invoiceId;customerNumber;shopPassword 
    if(!empty($orderInfo)){
      $hash = strtoupper(md5($action.';'.$orderSumAmount.';'.$orderSumCurrencyPaycash.';'.$orderSumBankPaycash.';'.$shopId.';'.$invoiceId.';'.$customerNumber.';'.$shopPassword));
      
      if($action == 'checkOrder'){
        if($hash == $key){
          $responseXml .= 'code="0" ';
        }else{
          $responseXml .= 'code="1" ';
        }
      }elseif($action == 'paymentAviso'){
        if($hash == $key){
          $responseXml .= 'code="0" ';
        }else{
          $responseXml .= 'code="1" paymentAviso ';
        }
        
        if($orderInfo[$orderNumber]['status_id']!=2 && $orderInfo[$orderNumber]['status_id']!=4 && $orderInfo[$orderNumber]['status_id']!=5){
          $this->actionWhenPayment(
            array(
              'paymentOrderId' => $orderNumber,
              'paymentAmount' => $orderInfo[$orderNumber]['summ'],
              'paymentID' => $paymentID
            )
          );
        }
      }else{
        $responseXml .= 'code="200"
          message="Неизвестное действие"';
      } 
    }elseif(!$error){
      $responseXml .= '
        code="200"
        message="Указаны неверные параметры заказа"';
    }
    
    $responseXml .= '
      invoiceId="'.$invoiceId.'" 
      shopId="'.$shopId.'" />';

    header('content-type: text/xml; charset=UTF-8');
    echo $responseXml;
    exit;
  }
  
  /**
   * проверка платежа через AlfaBank
   */
  public function alfabank($paymentID, $paymentStatus) {
	
    $order = new Models_Order();
    if ('result' == $paymentStatus && isset($_POST)) {     
      // если пользователь вернулся на страницу после оплаты, проверяем статус заказа
      if (isset($_REQUEST['orderId'])) {
        $paymentInfo = $order->getParamArray($paymentID, null, null);	
        $jsondata = file_get_contents('https://engine.paymentgate.ru/payment/rest/getOrderStatusExtended.do?language=ru&orderId=' . $_REQUEST['orderId'] . '&userName=' . $paymentInfo[0]['value'] . '&password=' . $paymentInfo[1]['value']);
        $obj = json_decode($jsondata);

        // приводим сумму заказа к нормальному виду
        $obj->amount = substr($obj->amount, 0, - 2) . "." . substr($obj->amount, -2);

        // приводим номер заказа к нормальному виду
        $orderNumber = explode('/', $obj->orderNumber);
        $obj->orderNumber = $orderNumber[0];

        $paymentAmount = trim($obj->amount);
        $paymentOrderId = trim($obj->orderNumber);

        // проверяем имеется ли в базе заказ с такими параметрами
        if (!empty($paymentAmount) && !empty($paymentOrderId)) {
          $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
        }

        // если заказа с таким номером и стоимостью нет, то возвращаем ошибку
        if (empty($orderInfo)) {
          echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ";
          exit;
        }

        // если заказ есть и он успешно оплачен в банке
        if ($obj->errorCode == 0 && $obj->actionCode==0) {
          // высылаем письма админу и пользователю об успешной оплате заказа, 
		  // только если его действующий статус не равен "оплачен" или "выполнен" или "отменен"	  
		  if($orderInfo[$paymentOrderId]['status_id']!=2 && $orderInfo[$paymentOrderId]['status_id']!=4 && $orderInfo[$paymentOrderId]['status_id']!=5){
			  $this->actionWhenPayment(
				array(
				  'paymentOrderId' => $paymentOrderId,
				  'paymentAmount' => $orderInfo[$paymentOrderId]['summ'],
				  'paymentID' => $paymentID
				)
			  );
		  }
          $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$paymentOrderId]['number'];
          $msg .= $this->msg;
        }else{
		  $msg = $obj->actionCodeDescription;
		}
		
      } else {
        //Запрос в альфабанк на формирование ссылки для перенаправления клиента к платежной форме
        if (!empty($_POST['paymentAlfaBank'])) {
          $paymentAmount = trim($_POST['amount']);
          $paymentOrderId = trim($_POST['orderNumber']);
          if (!empty($paymentAmount) && !empty($paymentOrderId)) {
            $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1) . " and summ+delivery_cost = " . DB::quote($paymentAmount, 1));
            $paymentInfo = $order->getParamArray($paymentID, $paymentOrderId, $orderInfo[$paymentOrderId]['summ']);
          }
          // предварительная проверка платежа
          if (empty($orderInfo)) {
            echo "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
            exit;
          }

          $_POST['orderNumber'] = $_POST['orderNumber'] . '/' . time();
          $_POST['userName'] = $paymentInfo[0]['value'];
          $_POST['password'] = $paymentInfo[1]['value'];
          $_POST['amount'] = number_format($_POST['amount'], 2, '', '');

          $jsondata = file_get_contents('https://engine.paymentgate.ru/payment/rest/register.do?amount=' . $_POST['amount'] . '&currency=' . $_POST['currency'] . '&language=' . $_POST['language'] . '&orderNumber=' . $_POST['orderNumber'] . '&returnUrl=' . urlencode($_POST['returnUrl']) . '&userName=' . $_POST['userName'] . '&password=' . $_POST['password']. '&description=' . $_POST['description']);
          $obj = json_decode($jsondata);
		
          // если произошла ошибка
          if (!empty($obj->errorCode)) {
            echo "ERR: " . $obj->errorMessage;
            exit;
          }

          // если ссылка сформированна, то отправляем клиента в альфабанк
          if (!empty($obj->orderId) && !empty($obj->formUrl)) {
            header('Location: ' . $obj->formUrl);
          }

          exit;
        }
      }
    }
    return $msg;
  }
  
  /*
   * Проверка платежа через privat24
   */
  public function privat24($paymentID, $paymentStatus){
    $order = new Models_Order();
    
    if ('result' == $paymentStatus && isset($_POST)){
      $payment = $_POST['payment'];

      if($payment){
        $payment_array = array();
        parse_str($payment, $payment_array);

        $state = trim($payment_array['state']);
        $paymentOrderId = trim($payment_array['order']);
        $orderNumber = trim($payment_array['ext_details']);
        $paymentAmount = trim($payment_array['amt']);

        switch($state){
          case 'not found':
            $msg = "Платеж не найден";
            return $msg;
            break;
          case 'fail':
            $msg =  "Ошибка оплаты";
            return $msg;
            break;
          case 'incomplete':
            $msg = "Пользователь не подтвердил оплату";
            return $msg;
            break;
          case 'wait':
            $msg = "Платеж в ожидании";
            return $msg;
            break;
        }
        
        if (empty($paymentOrderId)){
          $msg = "Оплата не удалась";
          return $msg;
        }

        if (!empty($paymentAmount) && !empty($paymentOrderId)) {
          $orderInfo = $order->getOrder(" id = " . DB::quote($paymentOrderId, 1));
          $paymentInfo = $order->getParamArray($paymentID, $paymentOrderId, $orderInfo[$paymentOrderId]['summ']);
          $merchant = $paymentInfo[0]['value'];
          $pass = $paymentInfo[1]['value'];
        }
  
        if (empty($orderInfo)) {
          $msg = "ERR: НЕКОРРЕКТНЫЕ ДАННЫЕ ЗАКАЗА";
          return $msg;
        }

        $amt = round($orderInfo[$paymentOrderId]['summ'], 2) + round($orderInfo[$paymentOrderId]['delivery_cost'], 2);
        $payment = 'amt='.$amt.'&ccy=UAH&details=заказ на '.SITE.'&ext_details='.$orderNumber.'&pay_way=privat24&order='.$paymentOrderId.'&merchant='.$merchant;
        $signature = sha1(md5($payment.$pass));

        $paymentSignatureString = 'amt=' . round($payment_array['amt'], 2) . '&ccy=' . $payment_array['ccy'] . '&details=' .  $payment_array['details'] . '&ext_details=' . $payment_array['ext_details'] . '&pay_way=' . $payment_array['pay_way'] . '&order=' . $payment_array['order'] . '&merchant=' . $payment_array['merchant'];
        $paymentSignature = sha1(md5($paymentSignatureString.$pass));

        if($paymentSignature !== $signature){
          $msg = "Подписи не совпадают!";
           return $msg;
        }

        $this->actionWhenPayment(
          array(
            'paymentOrderId' => $paymentOrderId,
            'paymentAmount' => $paymentAmount,
            'paymentID' => $paymentID
          )
        );

        $msg = 'Вы успешно оплатили заказ №' . $orderInfo[$paymentOrderId]['id'];      
        $msg .= $this->msg;

      }else{
        $msg = 'Оплата не удалась';
      }
    }else{
      $msg = 'Оплата не удалась';
    }
    return $msg;
  }

}

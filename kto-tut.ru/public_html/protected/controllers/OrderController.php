<?php

class OrderController extends CController
{
	
    public function accessRules()
	{
		return array(		
		);
	}
	/**
	 * Declares class-based actions.
	 */
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		     die(';;;');
		$this->render('index');		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	public function actionMy()
	{
        if(Yii::app()->user->isGuest) throw new CHttpException(404,'The requested page does not exist.');
		
        $dataProvider = new CActiveDataProvider('Order', 
        	array('pagination' => array('pageSize' => 20),
        		  'criteria'=>array('order'=>'order_id desc','condition'=>"user_id=".Yii::app()->user->id))        	
       	 );
    
		//$model=new Order('search');		
		//$model->unsetAttributes();  // clear any default values
		//$model->user_id = ;
		
		$this->render('my',array(
			//'model'=>$model,
			'dataProvider'=>$dataProvider
		));
	}
	
	public function actionView($id)
	{ 
	    if(Yii::app()->user->isGuest) throw new CHttpException(404,'The requested page does not exist.');		
	    $model=$this->loadModel($id);	
		if($model->user_id!=Yii::app()->user->id) throw new CHttpException(404,'The requested page does not exist.');	
		$dataProvider=new CActiveDataProvider('Order');
		$products = OrderProduct::model()->orderProducts($id); 
		$this->render('view',compact('model','products'));
	}
	
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
    public function actionSuccess()
	{
		$this->render('success');
	}
	
	public function actionDoOrder() {
	    if (Yii::app()->user->isGuest || empty ($_POST)) throw new CHttpException(404,'Страница не найдена');
	    
        $product_ids = Yii::app()->request->getPost('id');
        
        if (empty($product_ids) || !is_array($product_ids))  throw new CHttpException(404,'Не выбраны товары для заказа');
        
	 	$model_order=new Order;
       
        if(count($product_ids)){
            $model_order->order_status_id = Order::STATUS_CREATED;
            $model_order->user_id = Yii::app()->user->id;
            $model_order->ip = $_SERVER['REMOTE_ADDR'];
            $model_order->comment = $_POST['comment'];
            $model_order->date = date('Y-m-d H:i:s',time());
            $model_order->save();
            $order_id = $model_order->order_id;
        } 
        $products = array();      
	    foreach ($product_ids as $pid){
	        if(!isset($_POST["quantity$pid"])||!$_POST["quantity$pid"]) continue;
	        $model_order_product=new OrderProduct;
            $model_order_product->product_id = $pid;
            $model_order_product->order_id = $order_id;            
            $model_order_product->quantity = $_POST["quantity$pid"];
            $products[$pid] = $_POST["quantity$pid"];
            $model_order_product->save();
        }      
        //Отпраляем письмо с заказом        
         $message = new YiiMailMessage;
         $message->view = 'orderinfo';
         $message->setSubject("Создан новый заказ на сайте kto-tut.ru");
         $message->setBody(array('products'=>$products,'comment'=>$_POST['comment'],'for_admin'=>true), 'text/html');
         $message->addTo(Yii::app()->params['adminEmail']);                    
         $message->from = Yii::app()->params['adminEmail'];        
         Yii::app()->mail->send($message);
        
         $message = new YiiMailMessage;
         $message->view = 'orderinfo';
         $message->setSubject('Ваш заказ на сайте kto-tut.ru успешно сформирован!');
         $message->setBody(array('products'=>$products,'comment'=>$_POST['comment'],'for_admin'=>false), 'text/html');
         $message->addTo(Yii::app()->user->me->email);                    
         $message->from = Yii::app()->params['adminEmail'];        
         Yii::app()->mail->send($message);        
        
         $this->redirect('success');
        
    }

}
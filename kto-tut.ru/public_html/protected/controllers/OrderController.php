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
	    foreach ($product_ids as $pid){
	        $model_order_product=new OrderProduct;
            $model_order_product->product_id = $pid;
            $model_order_product->order_id = $order_id;
            $model_order_product->quantity = $_POST["quantity$pid"];
            $model_order_product->save();
        }       
        
        $this->redirect('/');
    }

}
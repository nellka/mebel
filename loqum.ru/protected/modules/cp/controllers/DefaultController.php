<?php

class DefaultController extends CpController
{
    public function accessRules()
   	{
   		return array(
   			array('allow', // allow admin user to perform 'admin' and 'delete' actions
   				'actions'=>array('index'),
   				'roles'=>array('admin'),
   			),
   			array('deny',  // deny all users
   				'users'=>array('*'),
   			),
   		);
   	}
	public function actionIndex()
	{
        $count['total']=Anketa::model()->count();
        $count['active']=Anketa::model()->count();
        $count['woman']=Anketa::model()->count('gender=0');
        $count['man']=Anketa::model()->count('gender=1');
        $count['premium']=Anketa::model()->count('flags & 2');
		$this->render('index',compact('count'));
	}
}
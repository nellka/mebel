<?php

class MessageController extends CpController
{
    public $defaultAction='index';
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view','list','show','stat','new','old','deleteUserMessages'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Message;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Message']))
		{
			$model->attributes=$_POST['Message'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Message']))
		{
			$model->attributes=$_POST['Message'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    public function actionOld(){
        $model = new Message();
        $dataProvider = new CActiveDataProvider('Message');
        $dataProvider->criteria = array(
            'select'=>'id_from,id_to,viewed,max(datestamp)as datestamp, count(id) as cnt',
            'condition'=>'deleted=0',
            'group'=>"CONCAT(LEAST(id_from,id_to),GREATEST(id_from,id_to))",
//            'group'=>'id_from + id_to',
            'order'=>'datestamp DESC',
        );
        $dataProvider->pagination = array('pageSize'=>50);
        $this->render('old',array('dataProvider'=>$dataProvider,'model'=>$model));
    }

    public function actionListOld($id = 0){
        //$model = Anketa::model()->findByPk($id);
        $model = new Message();
        $model->id_from = $id;
        $dataProvider = new CActiveDataProvider('Message');
        $dataProvider->criteria = array(
            'select'=>'id_from,id_to,viewed,max(datestamp)as datestamp, count(id) as cnt',
            'condition'=>'(id_from = :id OR id_to = :id)  AND (deleted=0)',
            'params'=>array(':id'=>$id),
            'group'=>"CONCAT(LEAST(id_from,id_to),GREATEST(id_from,id_to))",
            'order'=>'datestamp DESC',
        );

        $dataProvider->pagination = array('pageSize'=>50);
        //$this->renderPartial('/anketa/_menu',compact('model'));
        $this->render('index',array('dataProvider'=>$dataProvider,'model'=>$model));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('MessageCount');
        $dataProvider->criteria = array(
            'select'=>'IF (start_2,id2,id1) as id1 , IF (start_2,id1,id2) as id2, last_time, cnt',
            'order'=>'last_time DESC',
        );
        $dataProvider->pagination = array('pageSize'=>50);
        $this->render ('index',array('dataProvider'=>$dataProvider));
    }

    public function actionList($id=0) {
        $dataProvider = new CActiveDataProvider('MessageCount');
        $dataProvider->criteria = array(
            'select'=>'IF (start_2,id2,id1) as id1 , IF (start_2,id1,id2) as id2, last_time, cnt',
            'condition'=>'(id1 = :id OR id2 = :id)',
            'params'=>array(':id'=>$id),
            'order'=>'last_time DESC',
        );
        $dataProvider->pagination = array('pageSize'=>50);
        $this->render ('index',array('dataProvider'=>$dataProvider));
    }

    public function actionShow($l=0) {
        $this->layout = '//layouts/column1';

        $id = explode('-',$l);
        $model = new Message();
        $model->id_from = $id[0]; $model->id_to = $id[1];
        $anketas = array();
        $anketas[0] = Anketa::model()->with('mainphotoimage')->findByPk($id[0]);
        $anketas[1] = Anketa::model()->with('mainphotoimage')->findByPk($id[1]);


        $dataProvider = new CActiveDataProvider('Message');
        $dataProvider->criteria = array(
//            'select'=>'id_from,id_to,viewed,datestamp, count(id) as cnt',
            'condition'=>'(id_from = :id_to AND id_to = :id_from OR id_from = :id_from AND id_to = :id_to)  AND (deleted=0)',
            'params'=>array(':id_from'=>$model->id_from,':id_to'=>$model->id_to,),
            'order'=>'datestamp ASC',
        );

        $dataProvider->pagination = false;
        $this->render('show',array('dataProvider'=>$dataProvider,'model'=>$model,'anketas'=>$anketas));
    }


	/**
	 * Lists all models.
	 */
	public function actionIndex1()
	{
        $this->run('admin');
        Yii::app()->end();
		$dataProvider=new CActiveDataProvider('Message');
		$this->render('index1',array(
			'dataProvider'=>$dataProvider,
		));
	}

    public function actionStat(){
        $q = "
SELECT COUNT( c10 ) AS total, SUM( c10 ) AS c10, SUM( c15 ) AS c15, SUM( c20 ) AS c20, SUM( c25 ) AS c25, SUM( c30 ) AS c30
FROM (
SELECT count( id ) AS cnt, count( id ) >10 AS c10, count( id ) >15 AS c15, count( id ) >20 AS c20, count( id ) >25 AS c25, count( id ) >30 AS c30
FROM `message`
WHERE deleted =0
GROUP BY CONCAT( LEAST( id_from, id_to ) , GREATEST( id_from, id_to ) )
)t
        ";

        $dataProvider = new CSqlDataProvider($q);
        $this->render('stat',array('dataProvider'=>$dataProvider));
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Message('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Message']))
			$model->attributes=$_GET['Message'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Message::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionDeleteUserMessages($id)
    {
        if (!$anketa = Anketa::model()->findByPk($id))
            throw new CHttpException('404','Пользователь не найден');
        Yii::app()->db->createCommand('DELETE FROM message WHERE id_from=:id or id_to=:id')->execute(array(':id'=>$anketa->id));
        Yii::app()->db->createCommand('DELETE FROM `message_count` WHERE id1=:id or id2=:id')->execute(array(':id'=>$anketa->id));
        Yii::app()->user->setFlash('success','Переписка пользователя удалена');
        $url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/cp/message';
        $this->redirect($url);
    }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='message-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

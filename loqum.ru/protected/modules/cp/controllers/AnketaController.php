<?php

class AnketaController extends CpController
{

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
        return array(
      			array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array(
                        'admin', 'delete', 'create', 'update', '2big', 'index', 'view', 'addBalance', 'addContacts',
                        'zombie', 'clones', 'paid', 'ghosts', 'aboutemail', 'setbad', 'untop', 'setFingerprintBad',
                        'etag', 'bad', 'setIntimPhoto',
                    ),
                    'roles'=>array('admin'),
      			),
      			array('deny',  // deny all users
      				'users'=>array('*'),
      			),
      		);
	}

    public function actions()
    {
        return array(
            // setStatus
            'setIntimPhoto'=>array(
                'class'=>'ext.phaActiveColumn.ESetFlagAction',
                'modelClassName'=>'Photo',
                'fieldName'=>'intim',
                'redirectUrl'=>false,
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
		$model=new Anketa;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Anketa']))
		{
			$model->attributes=$_POST['Anketa'];
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

		if(isset($_POST['Anketa']))
		{
			$model->attributes=$_POST['Anketa'];
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $this->run('admin');
        Yii::app()->end();
		$dataProvider=new CActiveDataProvider('Anketa');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Anketa('search');
		$model->unsetAttributes();  // clear any default values
        $model->setPremium(null);
        $model->isdeleted = 0;
		if(isset($_GET['Anketa'])) {
			$model->attributes=$_GET['Anketa'];
            $model->setPremium($_GET['Anketa']['premium']);
        }

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionClones()
    {
        $model = new Anketa();
        $criteria = new CDbCriteria(array(
            'with' => array('a2cookie'=>array('joinType'=>'LEFT JOIN',)),
            'together' => true,
            'condition'=>'status_bad='.Anketa::BAD_STATUS_BAN.' OR a2cookie.cookie <> \'\'',

        ));


        $dataProvider =  new CActiveDataProvider('Anketa', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
                'pageVar'=>'page',
            ),
            'sort' => array('defaultOrder' => 't.id DESC')
        ));


        $this->render('clones', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionBad()
    {
        $ids = Yii::app()->db->createCommand("SELECT DISTINCT id_from
FROM `message`
WHERE datestamp > UNIX_TIMESTAMP( ) -3600 *24 *30
AND message LIKE '%150т%'")->queryColumn();

        $model = new Anketa();
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id',$ids);


        $dataProvider =  new CActiveDataProvider('Anketa', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
                'pageVar'=>'page',
            ),
            'sort' => array('defaultOrder' => 't.id DESC')
        ));


        $this->render('clones', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionEtag()
    {
        $model = new Anketa();
        $criteria = new CDbCriteria(array(
            //'together' => true,
            'join'=>'INNER JOIN anketa2etag a2e ON a2e.id = t.id ',
        ));


        $dataProvider =  new CActiveDataProvider('Anketa', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
                'pageVar'=>'page',
            ),
            'sort' => array('defaultOrder' => 't.id DESC')
        ));


        $this->render('etag', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionAboutemail()
    {
        $model = new Anketa();
        $criteria = new CDbCriteria(array(
            'condition'=>"
isdeleted=0
AND gender =1
AND 0 = `flags`&2
AND `first_visit` < UNIX_TIMESTAMP( ) -3600 *24 *3
AND `last_visit` > UNIX_TIMESTAMP( ) -3600 *24 *14
AND POSITION( '@'
IN `about` )
            ",

        ));


        $dataProvider =  new CActiveDataProvider('Anketa', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
                'pageVar'=>'page',
            ),
            'sort' => array('defaultOrder' => 't.id DESC')
        ));


        $this->render('about_email', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionPaid2()
    {
        $model = new Anketa();
        $criteria = new CDbCriteria(array(
            'with' => array('transactions'=>array('joinType'=>'INNER JOIN',)),
            'together' => true,
        ));


        $dataProvider =  new CActiveDataProvider('Anketa', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 6000,
                'pageVar'=>'page',
            ),
            'sort' => array('defaultOrder' => 't.id DESC')
        ));


        $this->render('paid', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionPaid()
    {
        $model=new Anketa('search');
        $model->unsetAttributes();  // clear any default values
        $model->setPremium(null);
        if(isset($_GET['Anketa'])) {
            $model->attributes=$_GET['Anketa'];
            $model->setPremium($_GET['Anketa']['premium']);
        }

        $criteria = new CDbCriteria(array(
            'condition' => 'id IN (SELECT DISTINCT id_user FROM `btransaction`)',
        ));

        $dataProvider = $model->search();
        $dataProvider->criteria->mergeWith($criteria);

        $this->render('paid', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Anketa::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='anketa-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    public function action2big($id=0){
        $models[]=$this->loadModel($id);
        $models[]=$this->loadModel($id);
        //$models[]=$this->loadModel(919091);
        $this->render('//anketa/2big',array('models'=>$models));
    }

    public function actionAddBalance($id) {
        if (!$model=$this->loadModel($id))
            throw new CHttpException('404','Анкета не найдена');
        if ($model->addBonusBalance(Yii::app()->request->getPost('balance'))) { //
            Yii::app()->user->setFlash('success','Бонус добавлен');
        } else {
            Yii::app()->user->setFlash('error','Ошибка добавления бонуса');
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }
    public function actionAddContacts($id) {
        if (!$model=$this->loadModel($id))
            throw new CHttpException('404','Анкета не найдена');
        if ($model->addBonusContacts(Yii::app()->request->getPost('contacts'))) { //
            Yii::app()->user->setFlash('success','Бонус добавлен');
        } else {
            Yii::app()->user->setFlash('error','Ошибка добавления бонуса');
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionZombie($id){
        if (!$model=$this->loadModel($id))
            throw new CHttpException('404','Анкета не найдена');
        $ips = Yii::app()->db->createCommand('select ip from anketa2ip where id=:id')->queryColumn(array(':id'=>$model->id));
        $ips = "'".implode("','",$ips)."'";

        $iparray = Yii::app()->db->createCommand("select id,ip from anketa2ip where ip in ({$ips}) ")->queryAll();
        $zombies = array();
        foreach($iparray as $k=>$v)
            $zombies[] = $v['id'];
        $zombies = Anketa::model()->findAllByPk($zombies,array('index'=>'id'));
        $this->render('zombie',compact('model','zombies','iparray'));
    }

    public function actionGhosts()
    {
        $model=new Anketa('search');
        $model->unsetAttributes();  // clear any default values
        $model->setPremium(null);
        if(isset($_GET['Anketa'])) {
            $model->attributes=$_GET['Anketa'];
            $model->setPremium($_GET['Anketa']['premium']);
        }

        $criteria = new CDbCriteria(array(
            'condition' => 'id NOT IN (SELECT DISTINCT id_anketa FROM `anketa_fingerprint` ) AND first_visit > 1370265543', //1370265543
        ));

        $dataProvider = $model->search();
        $dataProvider->criteria->mergeWith($criteria);

        $this->render('ghosts', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionSetbad($id=null){
        if (empty($id))
            $id = (int) $_POST['id'];
        if (!$model=$this->loadModel($id))
            throw new CHttpException('404','Анкета не найдена');
        if (!empty($_POST['unbad'])) {
            $model->setBad(0);
        } else if (!empty($_POST['setclone'])) {
            $model->setBad(Anketa::BAD_STATUS_CLONE);
        } else if (!empty($_POST['setban'])) {
            $model->setBad(Anketa::BAD_STATUS_BAN);
        }

        $this->redirect(Yii::app()->request->urlReferrer);

    }

    public function actionSetFingerprintBad(){
        if (empty($_POST))
            $this->redirect(Yii::app()->request->urlReferrer);
        $fb = new FingerprintBan();
        $fb->attributes = $_POST['FingerprintBan'];

        if (isset ($_POST['delete'])) {
            $cnt = FingerprintBan::model()->deleteAllByAttributes(array('type'=>$fb->type,'value'=>$fb->value));
            if ($cnt)
                Yii::app()->user->setFlash('success',Yii::t('test', 'Удалена {n} запись| Удалено {n} записи | Удалено {n} записей', $cnt));
            else
                Yii::app()->user->setFlash('error',"Подходящих записей не найдено");
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        $fb->time_start = time();
        if (isset ($_POST['ban']))
            $fb->status_bad = Anketa::BAD_STATUS_BAN;
        else if (isset ($_POST['clone'])) {
            $fb->status_bad = Anketa::BAD_STATUS_CLONE;
        } else die('NO VALID STATUS');

        if($fb->save()) {
            $txt = ($fb->status_bad == Anketa::BAD_STATUS_BAN) ? ' Бан ' : ' Клон ';
            $txt .= ($fb->isNewRecord) ? ' добавлен ' : ' обновлен ';
            Yii::app()->user->setFlash('success', $txt);
        } else {
            $txt = '';
            foreach($fb->getErrors() as $error) {
                $txt .= print_r($error,true).'<br>';
            }
            Yii::app()->user->setFlash('error',$txt);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionUntop(){
        $id = Yii::app()->request->getPost('id');
        if (!$model = $this->loadModel($id)) {
            throw new CHttpException(404,'Анкета не найдена');
        } /** @var $model Anketa */
        $model->setTop(0);
        $model->savePriority();
        Task::untopNow($model->id); // обновить Task-таймер
        Yii::app()->user->setFlash('success','Топ успешно отключён');
        $this->redirect(Yii::app()->request->urlReferrer);
    }

}

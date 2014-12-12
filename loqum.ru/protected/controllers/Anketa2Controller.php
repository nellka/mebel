<?php

class Anketa2Controller extends Controller
{
    public function beforeAction (){
        if (Yii::app()->user->isGuest){
            //Yii::app()->session->cookieMode = 'only';//  cookieMode' => 'only',
            Yii::app()->user->saveGuestLikes();
            Yii::app()->user->restoreGuestLikes();
        }
    return parent::beforeAction();
    }
    /**
     * Главная страница
     */
	public function actionIndex()
	{
        if (!Yii::app()->user->isGuest){
            Yii::app()->runController('profile/profile');
            Yii::app()->end();
        }

        $this->registerLightbox();
        $SearchForm = new SearchForm;
        $SearchForm->attributes = array('agefrom'=>18,'ageto'=>55,'location'=>'Москва');
        $LoginForm = new LoginForm;

        $model = new Anketa; //(array('gender'=>''));
        $models = array();
        if (0 && isset(Yii::app()->user->searchdata)) {
            $criteria = $model->getsearchcriteria(Yii::app()->user->searchdata);
            $res = $this->findWithUserCriteria($criteria);
            $models = $res['models'];$count1= $res['count'];
        } else {
            $criteria = $model->getsearchcriteria($SearchForm->attributes);
            $criteria2 = clone $criteria;
            $criteria->addCondition('gender=0');
            $criteria2->addCondition('gender=1');

            $count1 = Anketa::model()->count($criteria);
            $count2 = Anketa::model()->count($criteria2);
            $count1+=$count2;

            $models[1]=Anketa::model()->find($criteria2);
            $models[0]=Anketa::model()->find($criteria);
        }


		$this->render('index',array('SearchForm'=>$SearchForm,'LoginForm'=>$LoginForm,
            'models'=>$models,'count'=>$count1));
	}
    
    public function actionMylike() {
        $this->registerLightbox();
        if (Yii::app()->user->id){
            $model = Anketa::model()->findByPk(Yii::app()->user->id);
            $models = $model->mylike;
        } else if (Yii::app()->user->hasState('guestlikes')) {
            $models = Anketa::model()->findAllByPk (Yii::app()->user->guestlikes['like']);
        }
        $this->render('mylike',array('models'=>$models));
    }
    public function actionDislike() {
        $this->registerLightbox();
        if (Yii::app()->user->isGuest) {
        if (Yii::app()->user->hasState('guestlikes')) {
            $models = Anketa::model()->findAllByPk (Yii::app()->user->guestlikes['dislike']);
        }
        } else {
            $model = Anketa::model()->findByPk(Yii::app()->user->id);
            if ($model) $models = array_merge($model->mydislike1, $model->mydislike2);
        }
        $this->render('dislike',array('models'=>$models));
    }
    public function actionMelike() {
        $this->registerLightbox();
        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        $models = $model->melike;

        $this->render('melike',array('models'=>$models));
    }
    public function actionSetlike($id){
        if ($model = Anketa::model()->findByPk(Yii::app()->user->id))
            $model->updlike($id);
        else {
            $gl = Yii::app()->user->getState('guestlikes');
            if (is_array($gl['dislike']))
            $gl['dislike'] = array_diff($gl['dislike'],array($id));
            if (is_array($gl['like']))
            $gl['like'] = array_merge($gl['like'],array($id));
            Yii::app()->user->setState('guestlikes',$gl);
        }// nothing

        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    public function actionSetdislike($id){
        if($model = Anketa::model()->findByPk(Yii::app()->user->id))
            $model->upddislike($id);
        else {
            $gl = Yii::app()->user->getState('guestlikes');
            if (is_array($gl['like']))
            $gl['like'] = array_diff($gl['like'],array($id));
            if (is_array($gl['dislike']))
            $gl['dislike'] = array_merge($gl['dislike'],array($id));
            Yii::app()->user->setState('guestlikes',$gl);
        }

        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    public function actionWelike(){
        $this->registerLightbox();
        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        if ($model)
        $models = array_merge($model->mylike1,$model->melike1);

        
        //$models = Anketa::model()->with()
        //$models1=Anketa::model()->findByPk(Yii::app()->user->id)->with('melike1:simple')->findAll();
        //$models2=Anketa::model()->with('mylike1:we')->findByPk(Yii::app()->user->id);
        //$models = array_merge($models1,$models2);
        //$models=$models1;
        $this->render('welike',array('models'=>$models));
    }

    /**
     * Сброс всех лайков
     * только для тестовой базы
     */
    public function actionReset(){
        die ();
        if (!empty($_POST)) {
            Yii::app()->db->createCommand('truncate table `dislike`')->execute();
            Yii::app()->db->createCommand('truncate table `anketa`')->execute();
            Yii::app()->db->createCommand('insert into `anketa` select * from `anketa0`')->execute();
            Yii::app()->user->setFlash('reset_ok','База сброшена. Никто никому не нравится.');
            $this->refresh();
        }
        $this->render('reset');
    }

    /**
     * Сброс текущих симпатий пользователя-гостя.
     * Сброс кукисов + state guestlikes
     * @throws CHttpException удалить - через accessRules
     */
    public function actionResetCookie(){
        if (!Yii::app()->user->isGuest)
            throw new CHttpException(403,'Only Guest User');
        if (!empty($_POST['v1'])) {
            Yii::app()->user->clearGuestLikes();
            $session=Yii::app()->getSession();
            $session->regenerateID(true);
            Yii::app()->user->setState('guestlikes',null);
            Yii::app()->user->setFlash('reset_ok','Ваши симпатии сброшены.');
            $this->refresh();
        }
        if (!empty($_POST['v2'])) {
            Yii::app()->user->clearGuestLikes();
            Yii::app()->session->destroy();
            Yii::app()->user->setFlash('reset_ok','Ваши симпатии сброшены.');
            $this->refresh();
        }
        $this->render('reset',array('info'=>' текущие симпатии'));
    }

    public function actionViewCookie() {
        $data = print_r ($_COOKIE,true);
        $data .=print_r ($_SERVER,true);
        $data .= print_r ($_SESSION, true);

        file_put_contents(Yii::getPathOfAlias('application.runtime').'/cookielist',date("d.m.Y H:i:s\n").$data,FILE_APPEND);
        echo 'OK';
    }

    /**
     * хз
     */
    public function actionWas(){
        die('was');
    }

    /**
     * Просмотр своего профиля
     */

    public function actionProfile(){
        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        $this->render('view',array('model'=>$model));
    }

    /**
     * Выводит сообщения - список последних с группировкой по пользователю
     * отделить вывод сообщений отдельного пользователя
     * @param int $id - ID-шник пользователя для переписки
     * @throws CHttpException - незарегистрированный пользователь
     */
    public function actionMessages($id=0){
        // уберется в фильтре
        if (Yii::app()->user->isGuest)
            throw new CHttpException(403,'Чтобы просматривать эту страницу следует зарегистрироваться');

        if (empty ($id)) { // messages list
            $messages = Message::model()->active()->lastMessages();
            $users = Anketa::model()->with('mainphotoimage')->findAllByPk(array_keys($messages),array('index'=>'id'));
            $this->render('messages',array('messages'=>$messages,'users'=>$users));
            Yii::app()->end();
        }


        //$me = $this->loadModel($id);
        // сохранить в сессии
        $me = Anketa::model()->with('mainphotoimage')->findByPk(Yii::app()->user->id);
        $user = Anketa::model()->with('mainphotoimage')->findByPk($id);

        $welike = Anketa::isWelike($user->id,Yii::app()->user->id);

        $message = new Message('send');
        if (isset($_POST['Message'])) {
            if (!$welike) {
                Yii::app()->user->setFlash('error','Отправлять сообщения можно только по взаимной симпатии');
                $this->refresh();
            }
                $message->attributes = $_POST['Message'];
                $message->id_from = Yii::app()->user->id;
                $message->id_to = $user->id;
                if ($message->validate()) {
                    $message->save();
                    $this->refresh();
                }
        }

        $messages = Message::model()->active()->fromto($id)->findAll();
        if (empty($messages) && !$welike) {
            throw new CHttpException('403','Переписка возможна только по взаимной симпатии');
        }
        foreach ($messages as $message1)
            if ($message1->id_to==Yii::app()->user->id) {
                $message1->viewed=true;
                $message1->saveAttributes(array('viewed'));
            }

        $this->render('messages_one',array('messages'=>$messages,'me'=>$me,'user'=>$user,'posted'=>$message,'hideform'=>!$welike));
    }

    /**
     * регистрация скриптов галереи lightbox
     */
    private function registerLightbox() {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        //подключаем lightbox
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lightbox/js/jquery.lightbox-0.5.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/init_lightbox.js' ,CClientScript::POS_END);
        $cs->registerCssFile(Yii::app()->request->baseUrl.'/js/lightbox/css/jquery.lightbox-0.5.css');
        $cs->registerScript('lbx',"$('.simplesmall').each(function(i,el){
            $(this).find('a[rel*=lightbox]').lightBox(lightboxconfig);
        });");
    }

    /**
     * Просмотр анкеты $id обрабатывается в loadmodel
     * @param $id
     */
	public function actionView($id)
	{
        header("HTTP/1.0 404 Not Found");
        die('404 Not Found');
        throw new CHttpException('404','Страница не найдена');
        $this->registerLightbox();
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    /**
     * Список анкет
     */
    public function actionList()
	{
        throw new CHttpException('404');
        $dataProvider = new CActiveDataProvider(Anketa::model()->searchable(), array('pagination' => array('pageSize' => 30)));
        $this->render('list', array(
            'dataProvider' => $dataProvider,
        ));
	}

    /**
     * Предпросмотр своей анкеты
     */
    public function actionPreview(){
        $this->registerLightbox();
        $models = array();
        $user = $models[] = $this->loadModel(Yii::app()->user->id);
        //$models[] = $this->loadModel(865246);
        $criteria = new CDbCriteria();
        $criteria->compare('gender',$user->gender,true);
        $criteria->compare('sexual_orientation',$user->sexual_orientation,true);
//        $criteria->addCondition('id<>'.Yii::app()->user->id);
        $criteria->scopes = array('searchable','published');
        $criteria->order = ' rand()';
        $criteria->limit = 1;
        //$criteria->offset= rand(1,500);
        $models[]=Anketa::model()->find($criteria);
        $this->render('2big', array('models' => $models,'hidebuttons'=>true));
    }



    /**
     * Проверка, нужно ли регистрироваться пользователю
     * для дальнейших действий
     * @return bool
     */
    public function _needRegister()
    {
        if (Yii::app()->user->isGuest)
            if (Yii::app()->user->hasState('guestlikes')) {
                $cnt = 0; //$guestlikes = Yii::app()->user->guestlikes['like'];
                $guestlikes = Yii::app()->user->guestlikes;
                if (isset ($guestlikes['like']))
                    $cnt += count($guestlikes['like']);
                if ($cnt >= 7)
                    return true;
                if (isset ($guestlikes['dislike']))
                    $cnt += count($guestlikes['dislike']);
                if ($cnt >= 50) {
                    return true;
                }
            }
        return false;
    }


    public function actionMainSearch()
    {
        if (!empty ($_POST)){
            if (isset($_POST['SearchForm'])) {
                $model = new SearchForm;
                $model->attributes = $_POST['SearchForm'];
                if ($model->validate()) {
                    Yii::app()->user->setState('searchdata', $model->attributes);
                    Yii::app()->user->setState('guestlikes', array());
                    Yii::app()->user->setState('mainsearch',1);
                    $this->refresh();
                }
            }
        }
        $model = new Anketa; //(array('gender'=>''));
        $criteria = $model->getsearchcriteria(Yii::app()->user->getState('searchdata'));
        $count = Anketa::model()->count($criteria);
        echo $count;
    }

    /**
     * Поиск результатов по параметрам
     * @return mixed
     */
    public function actionSearch()
    {
        if ($this->_needRegister()) {
            $this->render('needregister');
            return;
        }

        if ((isset($_GET['clean']) || isset ($_GET['newsearch'])) && Yii::app()->user->getState('searchdata')) {
            //  очистить результаты поиска и в раздел "мне нравятся"
            Yii::app()->user->setState('searchdata', null, null);
            if (isset($_GET['clean']))
                $this->redirect(array('anketa/mylike'));
            else //newsearch
                $this->redirect(array('anketa/search'));
        }

        if (isset(Yii::app()->user->searchdata) && !Yii::app()->user->getState('mainsearch')) {
            // определить критерии поиска
            // echo Yii::app()->user->name;
            if (Yii::app()->user->isGuest) {
                $model = new Anketa; //(array('gender'=>''));
            } else {
                $model = Anketa::model()->findbypk(Yii::app()->user->id);
            }
            $criteria = $model->getsearchcriteria(Yii::app()->user->searchdata);
            $count = Anketa::model()->count($criteria);
            $criteria->limit = 2;
            $models = Anketa::model()->findAll($criteria);

            $this->render('2big', array('models' => $models, 'count' => $count));
        } else {
            $model = new SearchForm;
            Yii::app()->user->setState('mainsearch',0);
            if (Yii::app()->user->hasState('saveddata')) {
                $model->attributes = Yii::app()->user->getState('saveddata');
            }
            if (isset($_POST['SearchForm'])) {
                $model->attributes = $_POST['SearchForm'];
                if ($model->validate()) {
                    if (isset ($_POST['savedata']))
                        Yii::app()->user->setState('saveddata', $model->attributes);
                    Yii::app()->user->setState('searchdata', $model->attributes);
                    Yii::app()->user->setState('guestlikes', array());
                    $this->refresh();
                } else print_r ($model->getErrors());
            }
            $this->render('search', array('model' => $model));
        }
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
     * не ипользуется
     */
    public function actionShow()
	{
        die ();
		$this->render('show');
	}

    public function findWithUserCriteria($criteria){
        if (Yii::app()->user->hasState('searchdata')) {
            $searchdata = Yii::app()->user->getState('searchdata');

            if  (isset($searchdata['gender']) && $searchdata['gender']) {
                    $count = Anketa::model()->count($criteria);
                    $criteria->limit = 2;
                    $models = Anketa::model()->findAll($criteria);
                } elseif (isset (Yii::app()->user->searchdata['mygender'])
                        && (array_key_exists($searchdata['mygender'],Anketa::$getGenders))) {
                    $params = array();
                    $criteria->addCondition('sexual_orientation<>2');// && $params[':sexorient'] = 2;
                    $criteria->addCondition('gender<>'.Yii::app()->user->searchdata['mygender']);
                    $count = Anketa::model()->count($criteria);
                    $criteria->limit = 2;
                    $models = Anketa::model()->findAll($criteria);
                } else { // мальчики налево, девочки направо
                    $models = array();
                    $count = Anketa::model()->count($criteria);
                    $criteria->limit = 1;
                    $condition = $criteria->condition;
                    $criteria->addCondition('gender=1');
                    $models[]=Anketa::model()->find($criteria);
                    $criteria->condition=$condition;
                    $criteria->addCondition('gender=0');
                    $models[]=Anketa::model()->find($criteria);
                }
        } else {
            $count = Anketa::model()->count($criteria);
            $criteria->limit = 2;
            $models = Anketa::model()->findAll($criteria);
        }

        return array('models'=>$models,'count'=>$count);
    }
    /**
     * Отображение 2 фоток - болванка
     * Вывод 2х фоток на главной
     */
    public function action2big(){
        if ($this->_needRegister()) {
            $this->renderPartial('needregister');
            Yii::app()->end();
        }
        if (Yii::app()->user->isGuest) {
            $model = new Anketa; //(array('gender'=>''));
        } else {
            $model = Anketa::model()->findbypk(Yii::app()->user->id);
        } /** @var $criteria CDbCriteria */

        $criteria = $model->getsearchcriteria(Yii::app()->user->getState('searchdata'));

      //  list($models,$count) = $this->findWithUserCriteria($criteria);
        $res = $this->findWithUserCriteria($criteria);
        $models = $res['models'];
        $count = $res['count'];

//        $count = Anketa::model()->count($criteria);
//        $criteria->limit = 2;
//        $models = Anketa::model()->findAll($criteria);

        $this->renderPartial('2big', array('models' => $models, 'count' => $count));
        Yii::app()->end();

        $models = array();
        $models[] = $this->loadModel(865246);
        $models[] = $this->loadModel(919091);
        $this->render('2big',array('models'=>$models));
    }

    /**
     * получить следующую фотку по параметрам
     * с учетом уже отображённой $id
     * @param $id
     */
    public function actionGetajax($id)
    {
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header('Content-Type: text/html; charset=utf-8', TRUE);
        if ($this->_needRegister()) {
            $this->renderPartial('needregister');
            Yii::app()->end();
        }
        if (isset ($_POST['dislike'])) {
            if ($who = Anketa::model()->findByPk($_POST['dislike'])) {
                if ($me = Anketa::model()->findByPk(Yii::app()->user->id))
                    $me->adddislike($who->id);
                else {
                    $guestlikes = Yii::app()->user->getState('guestlikes');
                    if (isset ($guestlikes['dislike']))
                        $guestlikes['dislike'][] = (int)$_POST['dislike'];
                    else
                        $guestlikes['dislike'] = array((int)$_POST['dislike']);
                    Yii::app()->user->setState('guestlikes', $guestlikes);
                    $this->refresh();
                }
                ; // do nothing
            }
        }
        if (isset ($_POST['like'])) {
            if ($who = Anketa::model()->findByPk($_POST['like'])) {
                if ($me = Anketa::model()->findByPk(Yii::app()->user->id))
                    $me->addlike($who->id);
                else {
                    $guestlikes = Yii::app()->user->getState('guestlikes');
                    if (isset ($guestlikes['like']))
                        $guestlikes['like'][] = (int)$_POST['like'];
                    else
                        $guestlikes['like'] = array((int)$_POST['like']);
                    Yii::app()->user->setState('guestlikes', $guestlikes);
                    $this->refresh();
                }
                ; // do nothing
            }
        }
        if (isset ($_POST['next'])) {
            $searchdata = Yii::app()->user->searchdata;
            if (isset ($searchdata['was']))
                $searchdata['was'][] = (int)$_POST['next'];
            else
                $searchdata['was'] = array((int)$_POST['next']);
            Yii::app()->user->setState('searchdata', $searchdata);
            $this->refresh();
        }
        //$id = nextfinder;
        $criteria = Anketa::model()->getsearchcriteria(Yii::app()->user->getState('searchdata'));
        $data = $this->findWithUserCriteria($criteria);
        $models = $data['models'];
//        $criteria->limit = 2;
//        $models = Anketa::model()->findAll($criteria);//with('mainphotoimage')->
        if ($models[0]->id == $id)
            $models[0] = $models[1];
        $model = $models[0];
        $this->renderPartial('_simplebig', array(
            'model' => $model,
        ));
    }

    /**
	 * Manages all models.
	 */
	public function _actionAdmin()
	{
		$model=new Anketa('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Anketa']))
			$model->attributes=$_GET['Anketa'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function _actionUpdate($id)
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
     * не используется?
     * @return mixed
     */
    public function _actionForm()
    {
        $model = new Anketa('search');
        // uncomment the following code to enable ajax-based validation
        /*
        if(isset($_POST['ajax']) && $_POST['ajax']==='anketa-anketaform-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

        if (isset($_POST['Anketa'])) {
            $model->attributes = $_POST['Anketa'];
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }
        $this->render('anketaform', array('model' => $model));
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
     * Не используется
     */
    public function _actionDelete($id)
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
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
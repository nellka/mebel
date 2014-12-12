<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
                'testLimit'=>10,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
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

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
                if (!Yii::app()->user->isGuest)
                    $message = 'Пользователь # '.Yii::app()->user->id."\n";
                $message .= $model->body;
                $deps = ContactForm::getDepartments();
                $message .= "\n\nСообщение отправлено в ".$deps[$model->departament];
                $message .= "\n\nОбратная связь сайта ".$_SERVER['HTTP_HOST'];
				mail(Yii::app()->params['adminEmail'],$model->subject,$message,$headers);
				Yii::app()->user->setFlash('contact','Спасибо за обращение. Мы ответим Вам в ближайшее время.');
				$this->refresh();
			}
		} else if (!Yii::app()->user->isGuest){
            $anketa = Anketa::model()->findByPk(Yii::app()->user->id);
            $model->email = $anketa->email;
            $model->name = $anketa->name;

        }
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionPost(){
        if (Yii::app()->user->isGuest || empty($_POST))
            throw new CHttpException(404, 'Страница не найдена');
        echo Yii::app()->user->getState('AnketaFingerprint',0);
        if (Yii::app()->user->getState('AnketaFingerprint',0))
            return;
        $af = new AnketaFingerprint;
        $af->unsetAttributes();
        if (!empty($_POST))
            $af->attributes = $_POST;
        $af->accept = $_SERVER['HTTP_ACCEPT'];
        $af->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $af->id_anketa = Yii::app()->user->id;
        $af->user_agent_md5 = md5($af->user_agent);
        $af->fonts_md5 = md5($af->fonts);
        $af->plugins_md5 = md5($af->plugins);
        $dp = $af->search();
        if ($dp->totalItemCount == 0) {
            $af->save();
            $anketaFingerprint = $af->id;
        } else {
            $d = $dp->getData();
            if (is_array($d))
                $d = $d[0];
            $anketaFingerprint = $d->id;
        }
        Yii::app()->user->setState('AnketaFingerprint',$anketaFingerprint);

    }

    public function actionRobots(){
        header('Content-Type:text/plain');
        $this->renderPartial('robots');
    }

    /**
     * Etag action for test from loading /images/0x0.gif
     */
    public function action0x0() {
        // disable web logging
        foreach (Yii::app()->log->routes as $route)
            if ($route instanceof CWebLogRoute)
                $route->enabled = false;

        $etag = new EtagFingerprint(array('sessionDir'=>Yii::getPathOfAlias('application.runtime.etagsessions')));
        if (!Yii::app()->user->isGuest) {
            if (empty($etag->session))
                $etag->session = array();
            $etag->session = array_unique(array_merge($etag->session,array(Yii::app()->user->id)));
            if ($etaglist = Yii::app()->db->createCommand('SELECT cookie FROM anketa2etag WHERE id =:id')->queryScalar(array(':id' => Yii::app()->user->id))) {
                $etaglist = explode(':',$etaglist);
                $etag->session = array_unique(array_merge($etag->session,$etaglist));
            }
            if (count($etag->session)>=2)
                Yii::app()->db->createCommand('REPLACE INTO {{anketa2etag}} SET id=:id, cookie=:cookie')->execute(array(':id'=>Yii::app()->user->id,':cookie'=>implode(':',$etag->session)));
        }
        $etag->sendFile();
    }
}
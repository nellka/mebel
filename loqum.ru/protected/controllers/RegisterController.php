<?php

class RegisterController extends Controller
{
    public $layout = '//layouts/column1';

    public function actions()
   	{
   		return array(
   			// captcha action renders the CAPTCHA image displayed on the contact page
   			'captcha'=>array(
   				'class'=>'CCaptchaAction',
   				'backColor'=>0xFFFFFF,
   			),
   		);
   	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
//            array('allow', // allow admin user to perform 'admin' and 'delete' actions
////                'actions'=>array('admin','delete','create','update','2big','index','view'),
//  //              'roles'=>array('admin'),
//            ),
//            array('deny',  // deny all users
//                'actions'=>array('register'),
//                'users'=>array('@'),
//            ),
        );
    }

//    public function filters()
//    {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//        );
//    }


	public function actionIndex()
	{
		$this->redirect(array('register/register'));
	}

	public function actionRemember()
	{
        if (!Yii::app()->user->isGuest) {
            throw new CHttpException('500','Восстановление пароля недоступно');
        }
		$model = new Anketa('remember');
        if (isset($_POST['Anketa'])) {
            $model->attributes = $_POST['Anketa'];
            if ($model->validate()) {
                $model = Anketa::model()->findByAttributes(array('email'=>$model->email));
                if ($model===null)
                    throw new CHttpException('500','Пользователь не найден');
                $model->password = Anketa::randomSalt(7);// 'xNhd9po';
                //echo $model->password; //die();
                if ($model->saveAttributes(array('password'))) {
                    // email sender
                    $email = Yii::app()->email;
                    $email->view = 'remember';
                    $email->viewVars = array('model' => $model);
                    $email->subject = 'Восстановление пароля на ' . Yii::app()->name;
                    $email->from = Yii::app()->params['noreplyEmail'];
                    $email->to = $model->email;
                    $email->send();
                    Yii::app()->user->setFlash('remember','Информация о восстановлении пароля отправлена на указанный ящик');
                    $this->refresh();
                } else {

                    throw new CHttpException('500','Ошибка сохранения');
                }
            }
        }
        $this->render('remember',array('model'=>$model));
	}

	public function actionReset()
	{
		$this->render('reset');
	}

    public function actionDeletePhoto(){
        if(Yii::app()->user->hasState('registerPhoto')){
            $model = new Anketa;
            $file = $model->getRegisterPhotoFile();
            if (is_file($file))
                    unlink ($file);
            Yii::app()->user->setState('registerPhoto',null);
        }
        $this->redirect(array('register'));
    }

    public function actionRegister()
    {
        if (!Yii::app()->user->isGuest)
            $this->redirect(array('ok'));
        $model=new Anketa('register');

        // uncomment the following code to enable ajax-based validation
        /*
        if(isset($_POST['ajax']) && $_POST['ajax']==='anketa-register-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

        if(isset($_POST['Anketa']))
        {
            $model->attributes=$_POST['Anketa'];
            if (!empty($model->description))
            $model->description = implode("\n",$model->description);
            if (!empty($model->sex_role))
                if (is_array($model->sex_role))
                $model->sex_role = implode(",",array_intersect($model->sex_role,array_keys(Anketa::$getSexRoles)));
            $model->last_site = preg_replace('#^www\.#i','',$_SERVER['HTTP_HOST']);

            // если загружен файл - сохраняем во временный каталог
            if ($image = CUploadedFile::getInstance($model,'file')) {
                $model->file = CUploadedFile::getInstance($model,'file');
                if ($model->validate(array('file'))) {
                    if (Yii::app()->user->hasState('registerPhoto')) {
                        // delete old uploaded file
                        unlink($model->getRegisterPhotoFile());
                    }
                    $fileName = $image->getName();
                    $pi = pathinfo($fileName);
                    $tmpname = time().'.'.$pi['extension'];
                    $image->saveAs($model->getRegisterPhotoFile($tmpname));
                    Yii::app()->user->setState('registerPhoto',$tmpname);
                }
//                echo "IMAGE DETECTED:".$image->getName();
//                echo "tmp:".$image->getTempName();
//                Yii::app()->end(); //die();
            }
             // файл уже был загружен - заполним  file
                if (Yii::app()->user->hasState('registerPhoto'))
                    $model->file = Yii::app()->user->getState('registerPhoto');

            $model->priority =
            $model->first_visit = time();
            // Базовый аккаунт действует 36 часов. И 15 контактов для мужчин. И 25 для девушек.
            $model->trial_end = time()+36*3600;
            $model->contact_count = $model->gender == Anketa::GENDER_WOMAN ? 25:15;

            $model->trial_end = 1701647178; // лет так на 10
            $model->contact_count = 100; // тоже много

            $model->id_sess = Yii::app()->session->itemAt('id_stat');
            if($model->validate())
            {
                // form inputs are valid, do something here

                if ($model->save(false)) {

                    //Photo Save (!)only when was uploaded
                    if (Yii::app()->user->hasState('registerPhoto')) {
                    $photo = new Photo;
                    $photo->id_photo = $photo->getMaxIdPhoto($model->id);
                    $photo->id_user = $model->id;
                    $photo->path = $photo->getLargeImagePath(); // в модель
                    $photo->intim = $model->intimPhoto;

                    if (!$photo->saveFullImage($model->getRegisterPhotoFile()))
                        throw new CHttpException('500','Ошибка сохранения фотографии');
                    $photo->saveSmallPictures();
                    $photo->save(false); //not validate

                    //update anketa mainphoto
                    $model->mainphoto = $photo->id_photo;
                    $model->saveAttributes(array('mainphoto'));


/*
                    //$file_name = '/p/9000/'.$model->id.'_'.$photo->id_photo.'_l.JPG';
                    $file_name = $photo->getFullImagePath();

                    if (!copy($model->getRegisterPhotoFile(),$_SERVER['DOCUMENT_ROOT'].$file_name)) {
                        throw new Exception('Ошибка сохранения фотографии');
                    }
*/
/*
                    $image = Yii::app()->image->load($_SERVER['DOCUMENT_ROOT'].$file_name);
                    $file_name = '/p/6000/'.$model->id.'_'.$photo->id_photo.'_l.JPG';

                    if ($imginfo[0] > Photo::$sizes['full'][0] || $imginfo[1] > Photo::$sizes['full'][1]) {
                        $image->resize(Photo::$sizes['full'][0], Photo::$sizes['full'][1]);
                        $image->quality(100)->save();
                    }

                    if ($imginfo[0] > Photo::$sizes['large'][0] || $imginfo[1] > Photo::$sizes['large'][1])
                        $image->resize(Photo::$sizes['large'][0], Photo::$sizes['large'][1]);
                    $image->save($_SERVER['DOCUMENT_ROOT'].$file_name);

                    TmpHelper::addLogo($_SERVER['DOCUMENT_ROOT'].'/'.$file_name);

                    $photo->path = '/p/6000/'.$model->id.'_'.$photo->id_photo.'_l.JPG';*/

                    unlink($model->getRegisterPhotoFile());
                    Yii::app()->user->setState('registerPhoto',null);
                    }





                    //Send Email
                    $email = Yii::app()->email;
                    $email->view = 'register';
                    $email->viewVars = array('model' => $model);
                    $email->subject = 'Регистрация на ' . Yii::app()->name;
                    $email->from = Yii::app()->params['noreplyEmail'];
                    $email->to = $model->email;
                    $email->send();
                    Yii::app()->user->setFlash('registered','Вы успешно зарегистрированы');

                    // add like|dislike from cookie to likes
                    if (Yii::app()->user->hasState('guestlikes')) {
                        $models = Anketa::model()->findAllByPk(Yii::app()->user->guestlikes['dislike']);
                        foreach ($models as $anketa) {
                            $model->adddislike($anketa->id);
                        }
                        $likes = array_diff(Yii::app()->user->guestlikes['like'],Yii::app()->user->guestlikes['dislike']);
                        $models = Anketa::model()->findAllByPk($likes);
                        foreach ($models as $anketa) {
                            $model->addlike($anketa->id);
                        }

                        Yii::app()->user->setState('guestlikes', null); // чистим сессию
                        Yii::app()->user->clearGuestLikes(); // и куки (!) незарегистрированного пользователя

                    }

                    $loginform = new LoginForm;
                    $loginform->attributes = array('username'=>$model->email,'password'=>$model->password,'rememberMe'=>1);
                    $loginform->login();

                    //Yii::app()->user->setFlash('profile','');

                    $this->redirect (array('/register/ok'));
                } else {
                    throw new CHttpException(500,'Ошибка при сохранении.'.$model->getErrors(),true);
                }
                return;
            }
        }
        $this->render('register',array('model'=>$model));
    }

    public function actionOk(){
        if (Yii::app()->user->isGuest)
            $this->redirect(array('register'));
        Yii::app()->user->me->checkClone();
        $this->render('ok');
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
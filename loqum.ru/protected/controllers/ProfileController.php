<?php
/**
 * Подъем анкет работает по схеме:
 * priority - порядок вывода анкет
 *
 */


class ProfileController extends Controller
{
    public $layout = '//layouts/column1';
	public function actionIndex()
	{
		$this->render('index');
	}
    public $defaultAction='profile';

    public function accessRules()
   	{
           return array(
         			array('allow', // allow admin user to perform 'admin' and 'delete' actions
         				'users'=>array('@'),
         			),
         			array('deny',  // deny all users
         				'users'=>array('?'),
         			),
         		);
   	}

    public function actionPhotoIntim($id_photo=0){
        $photo = Photo::model()->findByPk(array('id_user'=>Yii::app()->user->id,'id_photo'=>$id_photo));
        if ($photo) {
            $photo->intim = !$photo->intim;
            $photo->saveAttributes(array('intim'));
            Yii::app()->user->setFlash('success','Фотография обновлена');
        }
        $url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/profile/photos';
        $this->redirect($url);
    }

	public function actionPhotos()
	{
        if (!empty($_POST)) {
            if (isset($_POST['deletephotos'])) {
                $anketa = Anketa::model()->findByPk(Yii::app()->user->id);
                if (!$anketa)
                    throw new CException('Error user');
                if (isset ($_POST['delete']) && is_array($_POST['delete'])) {
                foreach ($_POST['delete'] as $k=>$v){
                    if ($k==$anketa->mainphoto) {
                        $anketa->mainphoto = null;
                        $anketa->saveAttributes(array('mainphoto'));
                    }
                    if($model = Photo::model()->findByPk(array('id_user'=>Yii::app()->user->id,'id_photo'=>$k)))
                        $model->delete();
                }
                Yii::app()->user->setFlash('profile','Информация обновлена');
                } else {
                    Yii::app()->user->setFlash('profile','Не выбраны фото для удаления');
                }
                $this->refresh();
            } else if (isset($_POST['mainphoto'])) {
                $id = array_keys($_POST['mainphoto']);
                $id = $id[0];
                $model=Anketa::model()->findByPk(Yii::app()->user->id);
                if (!$model)
                    throw new CException('Error user');
                $photo = Photo::model()->findByPk(array('id_photo'=>$id,'id_user'=>$model->id));
                if (!$photo)
                    throw new CException('Error photo');
                $model->mainphoto = $id;
                $model->saveAttributes(array('mainphoto'));
                Yii::app()->user->setFlash('profile','Основная фотография изменена');
                $this->refresh();
            }
        }
		$models = Photo::model()->findAllByAttributes(array('id_user'=>Yii::app()->user->id));
        $user = Anketa::model()->findByPk(Yii::app()->user->id);
        $this->render('photos',compact('models','user'));
	}


    public function actionPhoto()
    {
        $model=new Photo('upload');
        if(isset($_POST['Photo']))
        {
            $model->attributes=$_POST['Photo'];
            if($model->validate())
            {
                $model->id_user = Yii::app()->user->id;
                $model->id_photo = Photo::getMaxIdPhoto(); //max(id_photo) where current user
                if (!$model->save())
                    throw new CHttpException('500','Ошибка записи в БД');

                $model->file=CUploadedFile::getInstance($model,'file');
                if ($model->file!=NULL) {/** @var $model->file CUploadedFile */

//                    $model->file->

                    $model->file->saveAs(Yii::getPathOfAlias('webroot').'/'.$model->getFullImagePath());
                    $model->path = $model->getLargeImagePath();
                    $model->saveSmallPictures();
                    $model->save(false); //not validate (WHY???)

                    // if it's first photo, make it mainphoto
                    if ($model->id_photo==1){
                        $user = Anketa::model()->findByPk(Yii::app()->user->id);
                        $user->mainphoto = $model->id_photo; // not const, for next changing
                        $user->saveAttributes(array('mainphoto'));
                    }
/*

                    $file_name = '/p/9000/'.Yii::app()->user->id.'_'.$model->id_photo.'_l.JPG';

                    $imginfo = getimagesize($_SERVER['DOCUMENT_ROOT'].$file_name);

                    $image = Yii::app()->image->load($_SERVER['DOCUMENT_ROOT'].$file_name);
                    if ($imginfo[0]>Photo::$sizes['full'][0] || $imginfo[1]>Photo::$sizes['full'][1] )
                        $image->resize(Photo::$sizes['full'][0], Photo::$sizes['full'][1]);
                    $image->quality(100)->save();

                    $file_name = '/p/6000/'.Yii::app()->user->id.'_'.$model->id_photo.'_l.JPG';
                    if ($imginfo[0]>Photo::$sizes['large'][0] || $imginfo[1]>Photo::$sizes['large'][1] )
                        $image->resize(Photo::$sizes['large'][0], Photo::$sizes['large'][1]);
                    $image->quality(100)->save($_SERVER['DOCUMENT_ROOT'].$file_name);
                    TmpHelper::addLogo($_SERVER['DOCUMENT_ROOT'].$file_name);

                    $model->path = $file_name;

                    $file_name = '/p/7000/'.Yii::app()->user->id.'_'.$model->id_photo.'_l.JPG';
                    if ($imginfo[0]>Photo::$sizes['small'][0] || $imginfo[1]>Photo::$sizes['small'][1])
                        $image->resize(Photo::$sizes['small'][0], Photo::$sizes['small'][1]);
                    $image->quality(100)->save($_SERVER['DOCUMENT_ROOT'].$file_name);
                    TmpHelper::addLogo($_SERVER['DOCUMENT_ROOT'].$file_name);

                    $model->saveAttributes(array('path')); */
                }
                //echo 'uploaded';
                Yii::app()->user->setFlash('profile','Фотография загружена');
                $this->redirect (array('/profile/photos'));
                // form inputs are valid, do something here
                return;
            }
        }
        $this->render('_photo',array('model'=>$model));
    }

    public function actionNotify(){
        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        if (!$model) die();
        $model->setScenario('updateNotify');
        if(isset($_POST['Anketa'])) {
            $model->attributes=$_POST['Anketa'];
            if($model->validate())
            {
                $model->save();
                Yii::app()->user->setFlash('profile','Информация обновлена');
                $this->refresh();
            }
        }
            $this->render('notify',array('model'=>$model));
    }

	public function actionProfile()
	{
        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        $model->splitBirthday(); // not afterFind.. no need in All pieces
        /** @var $model Anketa */
        if (!$model)
            throw new CException('Error User');
        if ($model->isdeleted) {Yii::app()->user->logout(false);Yii::app()->end();}
        $model->setScenario('edit');

        if(isset($_POST['Anketa']))
        {
            $model->attributes=$_POST['Anketa'];
            if ($model->description) {
//                foreach ($model->description as $k=>$v)
//                    $model->description[$k] = trim($v);
                $model->description = implode("\n",$model->description);
            }
            if (!empty($model->sex_role))
                if (is_array($model->sex_role))
                    $model->sex_role = implode(",",array_intersect($model->sex_role,array_keys(Anketa::$getSexRoles)));

            if($model->save())
            {
                // form inputs are valid, do something here
                //$model->save();
                Yii::app()->user->setFlash('profile','Информация обновлена');
                $this->refresh();
            }
        }
        $this->render('profile',array('model'=>$model));//('89.169.186.44'==$_SERVER['REMOTE_ADDR']?2:'')
	}

    private function actionPayservices(){
        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        $this->render('payservices',compact('model'));
    }

    public function actionChangePassword()
   	{
           $model = Anketa::model()->findByPk(Yii::app()->user->id);
           /** @var $model Anketa */
           if (!$model)
               throw new CException('Error User');
           $model->setScenario('changePassword');
           if (empty ($model->email)) {
               $model->addError('email','Следует заполнить поле email в профиле');
           }

           // uncomment the following code to enable ajax-based validation
           /*
           if(isset($_POST['ajax']) && $_POST['ajax']==='anketa-_profile-form')
           {
               echo CActiveForm::validate($model);
               Yii::app()->end();
           }
           */

           if(isset($_POST['Anketa']))
           {
               if (empty($model->password)) {
                   $model->attributes = $_POST['Anketa'];
                   $model->saveAttributes(array('password'));
                   Yii::app()->user->setFlash('profile','Пароль успешно изменён');
                   $this->refresh();
               }
               $model->attributes=$_POST['Anketa'];
               if($model->validate())
               {
                   // form inputs are valid, do something here
                   $model->save();
                   Yii::app()->user->setFlash('profile','Пароль успешно изменён');
                   $this->refresh();
               }
           } else {
               $model->password = '';
           }
           $this->render('change_password',array('model'=>$model));
   	}

    public function actionDelete(){
        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        /** @var $model Anketa */
        if (!$model)
            throw new CException('Error User');
        $model->setScenario('deleteUser');
        if (isset($_POST['Anketa'])) {
            $model->attributes=$_POST['Anketa'];
            if($model->validate(array('oldPassword'))) {
                $model->delete();
                Yii::app()->user->logout(false);
                Yii::app()->user->setFlash('deleted','Благодарим за пользование сайтом');
                $this->redirect(array('site/page','view'=>'deleted'));
            } else {
               // die(print_r($model->errors));
            }
//            echo $model->errors;
        }
        $this->render ('delete',compact('model'));
    }

    public function actionWallet(){
        $anketa = Anketa::model()->findByPk(Yii::app()->user->id);
        $this->render('wallet',compact('anketa'));
    }

    public function _actionPremium(){
        $me = Anketa::model()->findByPk(Yii::app()->user->id);
        $this->render('premium',compact('me'));
    }

    public function _actionContacts(){
        $me = Anketa::model()->findByPk(Yii::app()->user->id);
        $this->render('contacts',compact('me'));
    }

    public function actionUp(){
        $this->render('up',array('me'=>Yii::app()->user->me));
    }
    public function actionTop(){
        $this->render('top',array('me'=>Yii::app()->user->me));
    }

    /**
     * Аццкий говнокод
     *
     */
    public function actionOrderService()
    {
        $service = Yii::app()->request->getPost('service');

        $model = Anketa::model()->findByPk(Yii::app()->user->id);
        $transaction = new Btransaction();
        $transaction->id_user = $model->id;
        $transaction->time_end =
        $transaction->time_start = time();
        $transaction->info = array('ip'=>$_SERVER['REMOTE_ADDR']);

        $time_task = $time_top = $time_premium = 0;

        switch ($service){
            case 1: // подъем анкеты
                if (Btransaction::model()->count('id_user = :id_user AND time_start > :delta AND description = :description',
                    array(':id_user'=>$transaction->id_user,':delta' => time()-60 * 5,':description'=>'Поднятие анкеты')))
                    //Yii::app()->end();
                    $this->redirect(Yii::app()->request->getUrlReferrer()); // если чаще, чем в 5 минут - не списываем
                $transaction->amount = - 100;
                $transaction->description = 'Поднятие анкеты';
                $transaction->status = 1;
                $model->setUp();
                break;
            case 2:
                $transaction->amount =  -250;
                $transaction->description = 'ТОП на 2 недели';
                $transaction->status = 1;
                $time_top = 14 * 24 * 3600;
                break;
            case 3:
                $transaction->amount =  -400;
                $transaction->description = 'ТОП на 30 дней ';
                $transaction->status = 1;
                $time_top = 30*24*3600;
                break;
            case 4:
                $transaction->amount =  - ServiceManager::getPrice(4);
                $transaction->description = 'ПРЕМИУМ 2 недели';
                $transaction->status = 1;
                $time_premium = 14*24*3600;
                break;
            case 5:
                $transaction->amount =  - ServiceManager::getPrice(5);
                $transaction->description = 'ПРЕМИУМ на 30 дней';
                $transaction->status = 1;
                $time_premium = 30*24*3600;
                break;
            case 6:
                $transaction->amount =  - ServiceManager::getPrice(6);
                $transaction->description = 'ПРЕМИУМ на 3 дня';
                $transaction->status = 1;
                $time_premium = 3*24*3600;
                break;


            default:
                Yii::app()->user->setFlash('error','Неверная операция');
                $this->redirect(Yii::app()->request->getUrlReferrer());
        }

        if ($time_top) {
            $model->top = 1;
            $time_task = $time_top;
            $task = 'untop';
        }
        if ($time_premium) {
            /**
             * Если человек с пробным аккаунтом проплачивает прем – неизрасходованный пробник в двойном размере
             * прибавляется к прему. Т.е. человек, мгновенно оплативший прем после регистрации получит 72 часа к прему.
             */
            $bonus_time = 0;
            if ($model->getAccountType() == Anketa::ACCOUNT_TRIAL)
                $bonus_time = ($model->trial_end - time()) * 2;
            if ($bonus_time<=0) $bonus_time = 0;
            $model->setPremium(1);
            $time_task = $time_premium + $bonus_time;
            $task = 'unpremium';
        }

        if ($model->balance + $transaction->amount < 0) {
            Yii::app()->user->setFlash('error', 'Недостаточно средств');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }

        if ($time_task) {
            $q =
            'INSERT INTO `task` (id_user, `type`,time_task,`data`,status)
VALUES (:id_user,:type,:time_task+UNIX_TIMESTAMP(),:data,:status)
ON DUPLICATE KEY UPDATE
 time_task = GREATEST(time_task,UNIX_TIMESTAMP()) + :time_task,status=:status;';
            Yii::app()->db->createCommand($q)->execute(array(
                ':id_user'=>$transaction->id_user,
                ':type'=>$task,
                ':time_task'=>$time_task,
                ':data'=>'',
                ':status'=>1
            ));
        }

        $transaction->info = serialize($transaction->info);
        if ($transaction->save(false)) { // без валидации..
            $model->addBalance($transaction->amount);
            $model->savePriority();
        }
        Yii::app()->user->setFlash('success','Услуга &laquo;'.$transaction->description.'&raquo; успешно активирована');
        $this->checkUnBadStatus($model,$service);
        $this->redirect(Yii::app()->request->getUrlReferrer());
    }

    public function filters()
   	{
   		// return the filter configuration for this controller, e.g.:
   		return array(
   			'accessControl',
//   			array(
//   				'class'=>'path.to.FilterClass',
//   				'propertyName'=>'propertyValue',
//   			),
   		);
   	}

    /**
     * @param $model Anketa
     * @param $service
     * б) автоматически.
     * Для девченок – оплата поднятия анкеты.
     * Для мужиков – при переводе анкеты в статус премиума.
     */
    public function checkUnBadStatus($model,$service){
        if ($model->status_bad == Anketa::BAD_STATUS_CLONE)
            if ($model->gender == Anketa::GENDER_WOMAN && $service == 1 ||
                $model->gender == Anketa::GENDER_MAN && ($service == 4 || $service == 5 || $service == 6)
            ) {
                $model->setBad(Anketa::BAD_STATUS_CLONE_RESET);
            }
    }

    public function actionFingerprints(){
        Yii::app()->user->me->checkClone();
        $fp = Yii::app()->user->getState('AnketaFingerprint');
        $fp = AnketaFingerprint::model()->findByPk($fp);
        echo $fp->fonts;
    }

    /** Заявки МЖ */
    public function actionRequest() {
        //throw new CHttpException(404,'Страница временно недоступна');
        $me = Yii::app()->user->me; /** @var $me Anketa */
        $me->setLastRequestVisit(time());
        Request::checkStatus();
        if (!$request = Request::model()->find('id_user = :id_user and isdeleted = 0', array(':id_user'=>Yii::app()->user->id))) {
            $request = new Request;
        }
        if (!empty ($_POST)) {
            //echo $me->getAccountType(), '= ', Anketa::ACCOUNT_PREMIUM; die();
            $request->attributes = $_POST['Request'];
            if ($request->isNewRecord) {
                $request->id_user = Yii::app()->user->id;
                $request->time_start = time();
                $request->city = $me->city;
                $request->time_end =$request->time_start + Request::DEFAULT_REQUEST_TIME;
            }
            if ($me->disallowMessageTo($me))
                $request->addError('text','Вы не можете оставлять заявки!');
//            else if ($me->getAccountType()!=Anketa::ACCOUNT_PREMIUM)
//                $request->addError('text','Вы не можете оставлять заявки! Следует приобрести <a href="/profile/premium">Премиум-аккаунт</a>');
            else if ($request->save())
                $this->refresh();
        }

        $dataProvider = new CActiveDataProvider(Request::model()->published()->sorted()->byCity($me->city),array('pagination'=>array('pageSize'=>1000,'pageVar'=>'page')));

        $this->render('request',compact('request','dataProvider'));
    }

    public function actionRequestMark() {
        $id_request = Yii::app()->request->getParam('id_request');
        $on = Yii::app()->request->getParam('on');
        Request2anketa::mark($id_request,Yii::app()->user->id,$on);
        echo 1;
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
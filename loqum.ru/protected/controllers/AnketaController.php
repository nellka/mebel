<?php

class AnketaController extends Controller
{

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';


    public function actionIndex() {
        if ($_SERVER['REQUEST_URI']=='/anketa')
            throw new CHttpException(404,'Страница не найдена');
            $SearchForm = new AnketaSearch;
        $SearchForm->loadDefaults();
        $LoginForm = new LoginForm;

        if (Yii::app()->name=='sodeline.ru') // для odeline только московские анкеты
            $condition = 'gender=0 AND age>18 AND last_visit>=UNIX_TIMESTAMP()-259200 AND NOT status_bad & 1'
                ." AND (location LIKE '%Москва%')";
        else
            $condition = 'gender=0 AND age>18 AND last_visit>=UNIX_TIMESTAMP()-259200 AND NOT status_bad & 1'
                ." AND (location LIKE '%Москва%' OR location LIKE '%Петербург%')";


//        $womanProvider = new CActiveDataProvider('Anketa',array(
//            'criteria'=>array('limit'=>24, 'order'=>'id = 4932795 DESC,rand()','scopes'=>array('published','withphoto'),
//                'condition'=>$condition,
//            ),
//            'pagination'=>false,
//        ));

        $manProvider = new CActiveDataProvider('Anketa',array(
            'criteria'=>array('limit'=>40,'order'=>'rand()','scopes'=>array('published','withphoto'),
                'condition'=>'gender=1 AND age>29 AND last_visit>UNIX_TIMESTAMP()-259200*10 AND NOT status_bad & 1'
                ." AND (location LIKE '%Москва%' OR location LIKE '%Петербург%')",
//                'with'=>array('mainphotoimage'),
            ),
            'pagination'=>false,
        ));

        $this->render('index',compact('womanProvider','manProvider','SearchForm','LoginForm'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        if ($id != Yii::app()->user->id) {
            $statViewed = new StatViewed();
            $statViewed->attributes = array('id_user'=>Yii::app()->user->id,'id_viewed'=>$id,'datestamp'=>time());
            $statViewed->save();
        }
        $contactForm = new AnketaContactForm();
        if (isset($_POST['AnketaContactForm'])) {
            $contactForm->attributes=$_POST['AnketaContactForm'];
            if ($contactForm->validate())
                Yii::app()->user->setFlash('contact','Ваше сообщение отправлено.');
        }
        $this->render('view',array(//.($_SERVER['REMOTE_ADDR']=='89.169.186.44'?'1':'')
            'model'=>$model,
            'contactForm'=>$contactForm,
        ));
    }

    public function actionFakeView($id) {
        $id = strrev ($id);
        $this->actionView($id);
    }

    public function actionSearch(){
        $model = new AnketaSearch;
        $model->loadDefaults();
        if (isset ($_GET['AnketaSearch'])) {
            $model->attributes = $_GET['AnketaSearch'];
            $model->saveAsDefaults();
        }
        $this->render('search',array( //($_SERVER['REMOTE_ADDR']=='89.169.186.44'?'2':'')
            'model'=>$model,
        ));
    }

    /**
     * Перенос переписок в папки
     * @throws CHttpException
     */
    public function actionSortMessages() {
        if (Yii::app()->user->isGuest || empty ($_POST)) // переписать через фильтр(?)
            throw new CHttpException(404,'Страница не найдена');
        $ids = Yii::app()->request->getPost('id');
        if (empty($ids) || !is_array($ids))
            throw new CHttpException(404,'Переписки не найдены');
        $ids_binds = implode(',', array_fill(0, count($ids), '?'));

        if (isset($_POST['folder'])) {
            $folder = Yii::app()->request->getPost('folder');
            $params = array_merge(array(Yii::app()->user->id,Yii::app()->request->getPost('folder')),$ids);
//            var_dump ($params); var_dump($ids); die();
            Yii::app()->db->createCommand("REPLACE INTO message2folder (`id_from`,`id_to`,`id_folder`)
            SELECT ?, a.id, ? FROM anketa a WHERE a.id IN ({$ids_binds}) ")->execute (
                $params
            );
        } else {
//            Yii::app()->db->createCommand("DELETE FROM message2folder
//            WHERE `id_from`=? AND `id_to` IN ({$ids_binds})")->execute(
//                array_merge(array(Yii::app()->user->id),$ids)
//            );
        }
        $this->redirect(Yii::app()->request->getUrlReferrer());
    }

    public function actionMessages2($id = 0, $folder = 0, $mode=0)
    {
        if (Yii::app()->user->isGuest)
            $this->actionFakeMessages($id);
        if (Yii::app()->user->id == $id) // нельзя писать самому себе
            throw new CHttpException(404,'Страница не найдена');

        if (!$currentFolder = MessageFolder::model()->findByPk($folder))
            throw new CHttpException(404,'Папка не найдена');

        if (empty ($id)) { // messages list
            $messages = Message::model()->active()->lastMessages(null,$folder);
            $users = Anketa::model()->with('mainphotoimage')->findAllByPk(array_keys($messages),array('index'=>'id',));//'scopes'=>'published'
            $me = $users[Yii::app()->user->id];
            //if (!$me || $me->isdeleted) {Yii::app()->user->logout(false);Yii::app()->end();}
            $this->render('messages',array('messages'=>$messages,'users'=>$users,'currentFolder'=>$currentFolder));
            Yii::app()->end();
        }

        if (empty ($id)) { // messages list
            $messages = MessageCount::model()->lastMessages(null,$folder);
            $users = Anketa::model()->with('mainphotoimage')->findAllByPk(array_keys($messages),array('index'=>'id',));
            $newCnt = MessageCount::newMessages(null,array_keys($messages));
            $this->render('messages2',array('messages'=>$messages,'users'=>$users,'currentFolder'=>$currentFolder,'newCnt'=>$newCnt));
            Yii::app()->end();
        }
    }


    /**
     * Выводит сообщения - список последних с группировкой по пользователю
     * отделить вывод сообщений отдельного пользователя
     * @param int $id - ID-шник пользователя для переписки
     * @throws CHttpException - незарегистрированный пользователь
     */
    public function actionMessages($id = 0, $folder = 0, $mode=0)
    {
        if (Yii::app()->user->isGuest)
            $this->actionFakeMessages($id);
        if (Yii::app()->user->id == $id) // нельзя писать самому себе
            throw new CHttpException(404,'Страница не найдена');

        if (!$currentFolder = MessageFolder::model()->findByPk($folder)) {
            throw new CHttpException(404,'Папка не найдена');
        }

        if (empty ($id)) { // messages list
            $messages = MessageCount::model()->lastMessages(null,$folder);
            $users = Anketa::model()->with('mainphotoimage')->findAllByPk(array_keys($messages),array('index'=>'id',));
            $newCnt = MessageCount::newMessages(null,array_keys($messages));
            $this->render('messages',array('messages'=>$messages,'users'=>$users,'currentFolder'=>$currentFolder,'newCnt'=>$newCnt));
            Yii::app()->end();
        }

        // сохранить в сессии не будем, т.к. см ниже
        $me = Anketa::model()->with('mainphotoimage')->findByPk(Yii::app()->user->id);
        $user = Anketa::model()->with('mainphotoimage')->findByPk($id);

        if (!$me || $me->isdeleted) {Yii::app()->user->logout(false);Yii::app()->end();}
       // if (!user || $user->isdeleted) {throw new CHttpException(403,'Анкета удалена');}

        $welike = 1; // Anketa::isWelike($user->id,Yii::app()->user->id);

        $message = new Message('send');
        if (isset($_POST['Message'])) {
            if (!$welike) {
                Yii::app()->user->setFlash('error','Отправлять сообщения можно только по взаимной симпатии');
                $this->refresh();
            }
            if ($me->disallowMessageTo($user)){
                Yii::app()->user->setFlash('error','Отправка сообщения запрещена');
                $this->refresh();
            }
            $message->attributes = $_POST['Message'];
            $message->id_from = Yii::app()->user->id;
            $message->id_to = $user->id;
            if ($message->validate()) {
                // вычитаем контакт, если диалога раньше не было
                if (!$me->wasDialogTo($user)) {
                    MessageFolder::addDefaultFolder($me->id,$user->id);
                    $me->updateCounters(array('contact_count'=>-1),'id='.$me->id);
                }
                $message->save();
                $this->refresh();
            }
        }

        $all = (bool) $mode;
        $count = Message::model()->active()->fromto($id)->count();
        $all = ($count < 25 || $all);
        if ($all) {
            $messages = Message::model()->active()->fromto($id)->findAll(array('order'=>'id'));
        } else {
            $messages = Message::model()->active()->fromto($id)->findAll(array('order'=>'id DESC','limit'=>10));
            $messages = array_reverse($messages);
        }
        if (empty($messages) && !$welike) {
            throw new CHttpException('403','Переписка возможна только по взаимной симпатии');
        }
        foreach ($messages as $message1)
            if ($message1->id_to==Yii::app()->user->id && $message1->viewed == false) {
                $message1->viewed=true;
                $message1->saveAttributes(array('viewed'));
            }

        $this->render('messages_one',array('messages'=>$messages,'me'=>$me,'user'=>$user,'posted'=>$message,'hideform'=>!$welike,'all'=>$all));
    }

    public function actionFakeMessages($id=0){
        if (empty($id))
            //throw new CHttpException(404,'Страница не найдена');
            $this->redirect(Yii::app()->user->loginUrl);
        if ($this->action->id != 'messages')
            throw new CHttpException(404,'Страница не найдена');
        if (strpos($_SERVER['REQUEST_URI'],'/all')) {
            $this->redirect(str_replace('/all','',$_SERVER['REQUEST_URI']));
        }
        $me = new Anketa;
        $user = Anketa::model()->with('mainphotoimage')->findByPk($id);
        $message = new Message('send');
        $messages = array();
        $this->render('messages_one',array('messages'=>$messages,'me'=>$me,'user'=>$user,'posted'=>$message,'hideform'=>0,'all'=>true));
        Yii::app()->end();
    }

    public function actionVisitors($id=0){
        if (!$id = Yii::app()->user->id)
            $this->redirect(Yii::app()->user->loginUrl);
        if (!$model=Anketa::model()->findByPk($id))//
            throw new CHttpException(404,'Not found');
        Yii::app()->db->createCommand('REPLACE INTO `stat_visitors` set id=:id, datestamp = :time')->execute(array(':id' => $model->id, ':time' => time()));
        $this->render('visitors',array('visitors'=>$model->visitors));
    }

    public function loadModel($id)
    {
        $model=Anketa::model()->findByPk($id,array('scopes'=>'published'));
        if($model===null)
            throw new CHttpException(404,'Страница не найдена.');
        if ($model->isBad() && $model->id != Yii::app()->user->id)
            throw new CHttpException(404,'Страница не найдена.');
        return $model;
    }

    public function actionViewCookie() {
//        echo (int) setcookie('PHPSESSID',555,time()+5,'/','www.atolin.ru',0,true); //exit();
//        echo (int) setcookie('PHPSESSID',555,0,'/','www.atolin.ru',0,true); //exit();
//        echo (int) setcookie('PHPSESSID',555,time()+5,'/','.www.atolin.ru',0,true); //exit();
//        echo (int) setcookie('PHPSESSID',555,0,'/','.www.atolin.ru',0,true); //exit();
        $data = print_r ($_COOKIE,true);
        $data .=print_r ($_SERVER,true);
        $data .= print_r ($_SESSION, true);

        //file_put_contents(Yii::getPathOfAlias('application.runtime').'/cookielist',date("d.m.Y H:i:s\n").$data,FILE_APPEND);
        echo $data;
        echo 'OK';
    }

    /**
     * рандомное обновление даты посещения у старых анкет
     */
    public function actionFakeVisit($city=''){
        Anketa::model()->reFakeVisit($city);
    }

    public function actionTest(){
        //var_dump(Yii::app()->user); die();
    }

    public function actionGetPhoto(){
        //header_remove ();
        //var_dump(Yii::app()->user->isGuest);die();
        //var_dump(Yii::app()->user); die();
        if ($_SERVER['REMOTE_ADDR'] == '195.208.50.49') {
//            var_dump(Yii::app()->user); die();
        }
        $file = $_SERVER['REQUEST_URI'];
        if (preg_match('#(\d+)_(\d+)#',$_SERVER['REQUEST_URI'],$matches)) {//504783_1 {
            $photo = Photo::model()->findByPk(array('id_user'=>$matches[1],'id_photo'=>$matches[2]));
            if ($photo->intim && $photo->checkIntim())
                $file = Photo::PATH_INTIM;
        }
        $file = $_SERVER['DOCUMENT_ROOT'].$file;
        header('Content-type:image/jpeg');
        readfile($file);
        exit();
    }
}
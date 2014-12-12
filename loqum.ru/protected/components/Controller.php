<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * @property DatingUser $user the user session information
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column2';
    public $pageTitle = '';
    public $metaKeywords;
    public $metaDescription;
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function beforeAction($action){
        if(!Yii::app()->getSession()->getIsStarted())
        {
            Yii::app()->session->sessionID = $sid = 'd4k0alsr9l4387u8lnmivd4ks0';
            Yii::app()->session->open();
        }

        if (Yii::app()->params['innerStat'])
            StatHelper::stat_save()
        ;
        if (!Yii::app()->user->isGuest) {
            Yii::app()->db->createCommand('INSERT INTO {{anketa_update}} set last_visit = :timestamp , id=:id_user
            ON DUPLICATE KEY UPDATE last_visit = :timestamp')
                ->execute(array(':id_user'=>Yii::app()->user->id,':timestamp'=>time()));

            // проверяем на наличие адреса в "белом" диапазоне
            if (!
                Yii::app()->db->createCommand("
SELECT id FROM `ip_range`
WHERE :ipint
BETWEEN `ip_from`  AND `ip_to` LIMIT 0 , 1
")->queryRow(true, array(':ipint'=>ip2long($_SERVER['REMOTE_ADDR'])))
            )

if ('127.0.0.1'!=$_SERVER['REMOTE_ADDR'])
            Yii::app()->db->createCommand('
INSERT IGNORE INTO `anketa2ip` SET
id = :id,
ip = :ip,
last_time = :timestamp
            ')->execute(array(':id'=>Yii::app()->user->id,':ip'=>$_SERVER['REMOTE_ADDR'],':timestamp'=>time()));
            $cookie = Yii::app()->request->cookies['uids']->value;
            $cookie = str_replace(array('|','!','_'),',',$cookie);
            $cookie = explode(',',$cookie);
            //if (!in_array(Yii::app()->user->id,$cookie)) {
            if (1) {
                $cookie[] = Yii::app()->user->id;
                $cookie = array_unique($cookie);
                $cookie = $cookie_text = implode('_',$cookie);
                $cookie = new CHttpCookie('uids', $cookie);
                $cookie->expire = time()+60*60*24*180;
                Yii::app()->request->cookies['uids'] = $cookie;
            }
            if ($cookie_text != '_' . Yii::app()->user->id) {
                Yii::app()->db->createCommand('INSERT IGNORE INTO anketa2cookie SET id=:id, cookie=:cookie')
                    ->execute(array(':id' => Yii::app()->user->id, ':cookie' => $cookie_text));
                Yii::app()->user->me->checkClone();
            }

            if (!Yii::app()->user->getState('FingerprintChecked', 0) || (time() - Yii::app()->user->getState('LastFingerprintCheck', 0) > 60)) {
                Yii::app()->user->setState('LastFingerprintCheck',time());
                Yii::app()->user->me->checkClone();
            }
            //Yii::app()->user->setState('FingerprintChecked',0);
        }
        return parent::beforeAction($action);//$action
    }
}
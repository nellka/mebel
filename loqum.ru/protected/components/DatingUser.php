<?php
/**
 * Класс пользователя
 * добавлены функции сохранения/получения инфы
 */
class DatingUser extends CWebUser {
    private $me;

    /**
     * Получить пол текущего пользователя (если был введён либо
     * при поиске либо при авторизации
     * @return int - возвращает пол текущего пользователя
     */
    public function getGender() {
        if ($this->hasState('gender'))
        return $this->getState('gender');
        else return 0;
    }

    /**
     * @return Anketa
     */
    public function getMe(){
        if ($this->me === null)
            $this->me = Anketa::model()->findByPk($this->id);
        return $this->me;
    }

    /**
     * Сохраняем в сессии пол текущего юзера
     * @param $gender - ID пола
     * @see Anketa::getGender
     */
    public function setGender($gender) {
        $this->setState('gender',$gender);
    }

    /**
     * Сохраняем в куках для незарегистрированного пользователя
     * результаты выборки нравится-не нравится (лайки)
     * @return mixed
     */
    public function saveGuestLikes(){
        if (!$this->getState('guestlikes'))
            return;
        $cookie = new CHttpCookie ('guestLikes',serialize($this->getState('guestlikes')));
        $cookie->expire = time()+3600*24*30*3;
        Yii::app()->getRequest()->getCookies()->add($cookie->name,$cookie);
    }

    /**
     * Вычистка лайков из куков
     */
    public function clearGuestLikes(){
        $cookie = new CHttpCookie ('guestLikes',null);
        $cookie->expire = time()-99999999;
        Yii::app()->getRequest()->getCookies()->add($cookie->name,$cookie);
    }

    /**
     * Восстановить лайки из куков в сессию, если сессия пустая
     * @return mixed
     */
    public function restoreGuestLikes(){
        if ($this->getState('guestlikes'))
            return;
        $cookie=Yii::app()->getRequest()->getCookies()->itemAt('guestLikes');
        if($cookie && !empty($cookie->value)){
            $this->setState('guestlikes',unserialize($cookie->value));
        } else {
            $this->setState('guestlikes',array());
        }
    }
    
    /**
     * Получить роль текущего пользователя
     * возможно, вынести в CpUser
     * @return int - роль (пока guest|admin)
     */
    public function getRole() {
        $admins = array(503783,503894);
        if (in_array($this->id,$admins))
            return 'admin';
        return 'guest';
    }

    public function canMessageTo($anketa){
        if (Yii::app()->user->isGuest && Yii::app()->user->id != $anketa->id)
            return false;
        return $this->getMe()->canMessageTo($anketa);
    }
}
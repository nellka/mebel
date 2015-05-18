<?php
/**
 * Класс пользователя
 * добавлены функции сохранения/получения инфы
 */
class DatingUser extends CWebUser {
    private $me;

     /**
     * messages.php
     */
    const SHOW_PRESENT = 1;

    /**
     * @return Anketa
     */
    public function getMe(){
//        if ($this->id == 1) {
//            exit();
//        }

        if ($this->me === null)
            $this->me = User::model()->findByPk($this->id);
        if (empty ($this->me)) {
            Yii::app()->user->logout();
            header('Location: /');
            exit();
        }
        return $this->me;
    }      
       
    /**
     * Получить роль текущего пользователя
     * возможно, вынести в CpUser
     * @return int - роль (пока guest|admin)
     */
    public function getRole() {
        $admins = array(1);//4932797,
        if (in_array($this->id,$admins))
            return 'admin';
        if ($this->id == 4932798)
            return 'manager';
        return 'guest';
    }
}
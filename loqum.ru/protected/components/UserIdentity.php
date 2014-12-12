<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $_gender;
    public function getId(){
        return $this->_id;
    }
    public function getGender(){
        return $this->_gender;
    }

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
/*	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}	*/
    public function authenticate()
	{
		//ищем пользователя по номеру(!)
		$record=Anketa::model()->findByPk($this->username);

		if($record===null) {
            // второй вход по email
            $record = Anketa::model()->findByAttributes(array('email' => $this->username,'isdeleted'=>'0'));
            if ($record === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else if ($record->password !== $this->password) // пароль = ID
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            else
            {
                $this->_id = $record->id;
                //$this->_gender = $record->gender;
                $this->setState('gender',$record->gender);
                $this->setState('name', $record->name); //
                $record->last_visit = time();
                $record->last_site = preg_replace('#^www\.#i','',$_SERVER['HTTP_HOST']);
                $record->saveAttributes(array('last_visit','last_site'));
                $record->checkClone();
                $this->errorCode = self::ERROR_NONE;
            }


        } else if($record->id!==$this->password) // пароль = ID
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
            $this->_gender = $record->gender;
            $this->_id=$record->id;
            $this->setState('gender',$record->gender);
            $this->setState('name',$record->name);//
            $record->last_visit = time();
            $record->last_site = preg_replace('#^www\.#i','',$_SERVER['HTTP_HOST']);
            $record->saveAttributes(array('last_visit','last_site'));
            $record->checkClone();
            $this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
	}
}
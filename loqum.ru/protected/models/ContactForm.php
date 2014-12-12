<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $departament;
	public $body;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email,departament, subject, body', 'required'),
			array('departament', 'CRangeValidator','range'=>array_keys(self::getDepartments())),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
            'name'=>'Имя',
            'email'=>'Адрес e-mail',
            'departament'=>'Отдел',
            'subject'=>'Тема письма',
            'body'=>'Сообщение',
			'verifyCode'=>'Картинка',
		);
	}
    public static function getDepartments(){
        return array(
            1=>'Технические вопросы',
            2=>'Служба поддержки',
            3=>'Отдел рекламы',
        );
    }
}
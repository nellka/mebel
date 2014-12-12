<?php

class SearchForm extends Anketa
{
	public $location;
	public $gender;
	public $mygender;
	public $agefrom;
	public $ageto;
	public $heigthfrom;
	public $heigthto;
	public $weightfrom;
	public $weightto;
	public $withphoto;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('location, gender', 'required'),
            array('mygender,agefrom,ageto,withphoto,gender,location,heigthfrom,heigthto,weightfrom,weightto','safe'),
			// email has to be a valid email address
//			array('email', 'email'),
			// verifyCode needs to be entered correctly
//			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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
			'location'=>'Город',
			'gender'=>'Пол',
		);
	}
}
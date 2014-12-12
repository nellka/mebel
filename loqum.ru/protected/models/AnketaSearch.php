<?php

class AnketaSearch extends Anketa
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
	public $goals;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('location, gender', 'required'),
            array('mygender,agefrom,ageto,gender,location,goals,heigthfrom,heigthto,weightfrom,weightto','safe'),//withphoto,
            array('goals','in','range'=>Anketa::goalsArray()),
            array('last_visit','in','range'=>array_keys(self::getLastVisitValues()),'allowEmpty'=>true),// отключено
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

    public function behaviors()
    {
        return array(
            'defaults'=>array(
                'class'=>'ext.behaviors.model.AttributeDefaultsPersister',
                //'attributes'=>$this->attributeNames(),
                'attributes'=>array('agefrom','ageto','location','gender','mygender','goals','last_visit'),//
            ),
        );
    }

    /**
     *  default values form AttributeDefaultsPersister behavior
     */
    public function attributeDefaults(){
        if (Yii::app()->name=='sodeline.ru')
            return  array('agefrom'=>null,'ageto'=>null,'location'=>'Москва','mygender'=>Anketa::GENDER_MAN,'gender'=>Anketa::GENDER_WOMAN,'last_visit'=>'');//-24 hour
        return  array('agefrom'=>null,'ageto'=>null,'location'=>'Москва','last_visit'=>'');//-24 hour
        return  array('agefrom'=>null,'ageto'=>null,'location'=>'Москва','last_visit'=>'');//-24 hour
    }

    public function getLastVisitValues(){
        return
            array(
                'online'  => 'Online',
//                '-30 minutes'  => 'Online',
                '-24 hour'  => '24 часа',
                '-3 day'    => '3 дня',
                '-1 week'   => 'неделя',
                '-1 month'  => 'месяц',
//                'all'       => 'все время',
            );
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
//        if (empty ($_GET['AnketaSearch']))
//            return null;
        $criteria=new CDbCriteria;
        $this->isdeleted = 0;

        $criteria->compare('gender',$this->gender,true);
        $criteria->compare('age','>='.$this->agefrom,true);
        $criteria->compare('age','<='.$this->ageto,true);
        $criteria->compare('location',$this->location,true);

        if ($this->last_visit) {
            $timeAdd = $this->last_visit;
            if ($this->last_visit == 'online')
                $timeAdd = '-15 minutes';
            $criteria->compare('last_visit','>'.strtotime($timeAdd));
        }

        $criteria->compare('heigth','>'.$this->heigthfrom,true);
        $criteria->compare('heigth','<'.$this->heigthto,true);
        $criteria->compare('weight','>'.$this->weightfrom,true);
        $criteria->compare('weight','<'.$this->weightto,true);
        $criteria->compare('isdeleted',$this->isdeleted);
        $criteria->compare('isinactive',$this->isinactive);
        $criteria->addCondition('NOT status_bad & 1'); // bit one - clon || ban

        $topcriteria = new CDbCriteria;
        $topcriteria->compare('location',$this->location,true);
        $topcriteria->compare('isdeleted',$this->isdeleted);
        $topcriteria->compare('isinactive',$this->isinactive);
        $topcriteria->compare('gender',$this->gender,true);
        $topcriteria->addCondition('flags & 1'); // bit one
        $topcriteria->addCondition('NOT status_bad & 1'); // bit one clon || ban

        $criteria->mergeWith($topcriteria,false);

        if (!empty($this->goals)) {
            $goalscriteria = new CDbCriteria();
            foreach ($this->goals as $goal)
                $goalscriteria->compare('t.description',$goal,true,'OR');
            $criteria->mergeWith($goalscriteria);
        }

        $criteria->order = 'priority DESC, id desc';
//        if ($this->withphoto)
//            $criteria->compare('mainphoto','>0',true);
        $criteria->with = 'mainphotoimage';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 25,
                'pageVar'=>'page',
            ),
        ));
    }
}
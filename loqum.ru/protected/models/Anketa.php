<?php

/**
 * This is the model class for table "anketa".
 *
 * The followings are the available columns in table 'anketa':
 * @property string $id
 * @property string $name
 * @property string $gender
 * @property string $age
 * @property string $email
 * @property string $password
 * @property string $zodiac
 * @property string $heigth
 * @property string $weight
 * @property string $birthday
 * @property string $about
 * @property string $marital_status
 * @property string $sexual_orientation
 * @property string $description
 * @property string $location
 * @property string $icq
 * @property string $phone
 * @property integer $last_visit
 * @property integer $trial_end
 * @property integer $status_bad
 * @property integer $contact_count
 * @property integer $balance
 * @property integer $isdeleted
 * @property integer $isinactive
 * @property integer $flags битовые флаги 1 - top 2 - paid 4 - ..
 */
class Anketa extends CActiveRecord
{
    const GENDER_MAN = 1;
    const GENDER_WOMAN = 0;

    const ACCOUNT_BASE = 0;
    const ACCOUNT_TRIAL = 1;
    const ACCOUNT_PREMIUM = 2;

    public $datestamp;
    public static $fakeMaxId = 4932948;
    private $premium = 0;
    public $agree=null;
    public $intimPhoto;

    public $birthDay;
    public $birthMonth;
    public $birthYear;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Anketa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'anketa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('gender','default','value'=>1), // мужики
            array('sexual_orientation','default','value'=>2), // гомо
            array('name, email, gender, sexual_orientation, location', 'required','on'=>'edit'),
            array('email','filter','filter'=>'trim','on'=>'register,remember'),

			array('email, password, name, gender, sexual_orientation, location ', 'required','on'=>'register'),
			array('agree', 'required','on'=>'register','requiredValue'=>'1','message'=>'Следует согласиться с правилами и договором офертой'),
            array('email','email', 'message'=>'Неверный e-mail','on'=>'register'),
            array('email','unique' ,'on'=>'register'),
            array('email','safe' ,'on'=>'update'),
            array('icq, phone','safe'),

            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'on'=>'register,remember'),
            array('verifyPassword', 'compare', 'compareAttribute'=>'password','on'=>'register', 'message' => 'Пароли не совпадают'),

            array('sexual_orientation','CRangeValidator','range'=>array_keys(self::$getSexOr), 'message'=>'Неверное значение'),
            array('gender','CRangeValidator','range'=>array_keys(self::$getGenders), 'message'=>'Неверное значение'),

            array('birthDay,birthMonth,birthYear', 'safe', 'on' => 'register,edit,update'),
            array('birthday', 'makeBirthday', 'on' => 'register,edit,update'),

            array('birthday', 'required', 'on' => 'register,edit,update'),
            array('birthday', 'date', 'format' => 'dd.mm.yyyy', 'message' => 'Неверное значение для Даты рождения', 'on' => 'register,edit,update'),
            array('name, location, icq, phone', 'length', 'max' => 255),

            //array('isinactive','bool','on'=>'edit,update' ),
            array('description','required','on'=>'register,update,edit','message'=>'Следует указать цель знакомства'),
            array('isinactive','CRangeValidator', 'range'=>array(1,0), 'on'=>'edit,update' ),
            array('isdeleted','CRangeValidator', 'range'=>array(1,0), 'on'=>'update' ),

            array('heigth, weight', 'numerical', 'integerOnly'=>true),
			array('heigth, weight', 'length', 'max'=>4),

            array('file', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1024* 1024 *  8, 'allowEmpty'=>true,'on'=>'register'),
            array('about,description', 'safe', ),//'on'=>'register'

            //remember
            array('email,verifyCode','required','on'=>'remember'),
            array('email','email','allowEmpty'=>false,'on'=>'remember'),
            array('email','exist','on'=>'remember','message'=>'Пользователь не найден'),

            array('password,verifyPassword','required','on'=>'changePassword'),//oldPassword
            array('verifyPassword', 'compare', 'compareAttribute'=>'password','on'=>'changePassword', 'message' => 'Пароли не совпадают'),
            array('oldPassword', 'authenticate','on'=>'changePassword'),
            array('oldPassword','required','on'=>'deleteUser'),
            array('oldPassword', 'authenticate','on'=>'deleteUser'),
            array('n_msg,n_vwd', 'numerical', 'integerOnly'=>true,'on'=>'updateNotify'),

            array('find_from,find_to', 'numerical', 'integerOnly'=>true,'min'=>18,'max'=>99, 'on' => 'register,edit,update', 'message' => 'Возраст желаемого партнера должен быть целым числом от 18 до 99','tooSmall'=>'Указан маленький возраст (минимум 18 лет)','tooBig'=>'Указан большой возраст'),
            array('find_from', 'compare', 'compareAttribute'=>'find_to','operator'=>'<=','allowEmpty'=>true,'strict'=>false,'message' => 'Возраст "от" должен быть меньше возраста "до"'),
            array('sex_role','safe','on'=>'register,edit,update'),
            array('intimPhoto','safe','on'=>'register,edit,update'),
//            array('find_from,find_to', 'CRangeValidator', 'integerOnly', 'on' => 'register,edit,update', 'message' => 'Неверный возраст желаемого партнера'),

			// The following rule is used by get.
			// Please remove those attributes that should not be searched.
			array('id, name, email, gender, age, zodiac, heigth, weight, about, marital_status, sexual_orientation, description, location, balance,contact_count,premium, icq, phone, last_visit,last_site,isinactive,isdeleted,status_bad', 'safe', 'on'=>'search'),
		);
	}

    public function authenticate($attribute,$params) {
        if (!$this->hasErrors()) {
            $identity = new UserIdentity($this->email, $this->oldPassword);
            if (!$identity->authenticate())
                $this->addError('oldPassword', 'Неверный пароль');
        }
    }

    public function makeBirthday(){
        if (!empty ($this->birthDay)) {
            $birthtime = mktime(10,0,0,$this->birthMonth, $this->birthDay,$this->birthYear);
            $this->birthday = date('d.m.Y',$birthtime);
            //$this->birthday = "{$this->birthDay}.{$this->birthMonth}.{}";
        }
    }

    public function splitBirthday(){
        list ($this->birthYear, $this->birthMonth, $this->birthDay) = explode('-', $this->birthday);
        $this->birthYear = (int)$this->birthYear;
        $this->birthMonth = (int)$this->birthMonth;
        $this->birthDay = (int)$this->birthDay;
    }

    public function isOnline(){
        if (time()-$this->last_visit<900)
            return true;
        else return false;
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $alias = $this->getTableAlias(false,false);
		return array(
            'photos'=>array(self::HAS_MANY,'Photo','id_user','index'=>'id_photo'), // мои фото //,'index'=>'id_photo' //'order'=>$alias.'.mainphoto=photo.id_photo DESC'
            'mainphotoimage' => array(self::HAS_ONE,'Photo',array('id_user'=>'id','id_photo'=>'mainphoto')),
            'top_end'=>array(self::HAS_ONE,'Task',array('id_user'=>'id',),'condition'=>"type='untop'"),
            'premium_end'=>array(self::HAS_ONE,'Task',array('id_user'=>'id',),'condition'=>"type='unpremium'"),
            'a2cookie' => array(self::HAS_ONE,'Anketa2cookie',array('id'=>'id')),
            'fingerprints'=>array(self::HAS_MANY,'AnketaFingerprint','id_anketa'), // мои фото //,'index'=>'id_photo' //'order'=>$alias.'.mainphoto=photo.id_photo DESC'
//            'trial_end'=>array(self::HAS_ONE,'Task',array('id_user'=>'id',),'condition'=>"type='untrial'"),
            //'mainphotoimage'=>array(self::HAS_ONE,'Photo','','on'=>"`$alias`.id=id_user and $alias.`mainphoto`=id_photo",'together'=>true),
            //'mainphotoimage'=>array(self::HAS_ONE,'Photo','','on'=>"`$alias`.id=id_user and $alias.`mainphoto`=id_photo",'together'=>true),
            'regsession'=>array(self::BELONGS_TO,'StatSessions','id_sess'),//'on'=>"regsession.id_sess=$alias.id_sess",'together'=>true
            'visitors'=>array(self::MANY_MANY,'Anketa','stat_viewed(id_viewed,id_user)',
                'select'=>$alias.'.*,max(datestamp) as datestamp',
                'condition'=>'`datestamp` > '.(time()-3600*24*14) . ' AND (1 & `status_bad` = 0)', // 2 недели + без клонов
                'group'=>'id_user',
                'order'=>'datestamp DESC',
            ),
            //'mainphoto'=>array(self::HAS_ONE,'Photo','','condition'=>"{$this->id}=`id_user` and {$this->mainphoto}=`id_photo`"),
            //'mainphotoimage'=>array(self::HAS_ONE,'Photo','id_user','condition'=>'mainphoto=id_photo'),
            'mylike'=>array(self::MANY_MANY,'Anketa','dislike(id_my,id_who)',
                'condition'=>'status1=1 and status2=0',
                'order'=>'date1 desc',
            ), // мне нравятся
            'melike'=>array(self::MANY_MANY,'Anketa','dislike(id_who,id_my)',
                'condition'=>'status1=1 and status2=0',
                'order'=>'date1 desc',
            ), // я нравлюсь
            'melike1'=>array(self::MANY_MANY,'Anketa','dislike(id_who,id_my)',
                'condition'=>'status1=1 and status2=1',
            ), // я нравлюсь+
            'mylike1'=>array(self::MANY_MANY,'Anketa','dislike(id_my,id_who)',
                'condition'=>'status1=1 and status2=1',
            ), // я нравлюсь+
            'mydislike1'=>array(self::MANY_MANY,'Anketa','dislike(id_my,id_who)',
                'condition'=>'status1=-1',
                'order'=>'date1 desc',
            ), // мне не нравятся 1 -> 2
            'mydislike2'=>array(self::MANY_MANY,'Anketa','dislike(id_who,id_my)',
                'condition'=>'status2=-1',
                'order'=>'date1 desc',
            ), // мне не нравятся 1 <- 2
            'totalPaid'=>array(self::STAT,'Btransaction','id_user',
                'condition'=>'status=1',
                'select'=>'SUM(amount_real)',
            ),
            'transactions' => array(self::HAS_MANY,'Btransaction','id_user'),
            'totalMessagesFrom'=>array(self::STAT,'Message','id_from'),
            'totalMessagesTo'=>array(self::STAT,'Message','id_to'),
            // мне не нравятся 1 <- 2
//            'melike'=>array(self::HAS_MANY,'dislike','id_who'),// я нравлюсь
		);
	}
    public function scopes()
    {
        return array(
            'we'=>array(
                'condition'=>'status1=1 and status2=1',
            ),
            'simple'=>array(
                'condition'=>'status1=1'
            ),
            'published'=>array(
              'condition'=>'isdeleted=0 ',//AND mainphoto>0
              'order'=>'first_visit desc, id desc',
            ),
            'withphoto'=>array(
                'condition'=>'mainphoto>0'
            ),
            'searchable'=>array(
                'condition'=>'isdeleted=0 AND isinactive=0',
            )
        );
    }



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Номер',
			'name' => 'Имя на сайте',
			'email' => 'E-mail',
			'password' => 'Пароль',
			'oldPassword' => 'Текущий пароль',
			'verifyPassword' => 'Повторите пароль',
			'gender' => 'Пол',
			'birthday' => 'Дата рождения',
			'age' => 'Возраст',
			'zodiac' => 'Знак зодиака',
			'heigth' => 'Рост',
			'weight' => 'Вес',
			'about' => 'Несколько слов о себе',
			'find_from' => 'Ищу мужчину возрастом',
			'find_to' => ' ',
			'sex_role' => 'Роль в сексе',
			'marital_status' => 'Семейное положение',
			'sexual_orientation' => 'Сексуальная ориентация',
			'description' => 'Цель знакомства',
			'location' => 'Откуда',
			'icq' => 'Icq',
			'phone' => 'Телефон',
			'file' => 'Ваша фотография',
			'verifyCode' => 'Защита от спама',
			'last_visit' => 'Последний визит',
			'first_visit' => 'Зарегистрирован',
			'last_site' => 'Сайт',
			'isinactive' => 'Скрыть из поиска',
			'n_vwd' => 'Уведомлять о просмотрах моей анкеты',
			'n_msg' => 'Уведомлять о новых сообщениях на email',
			'isdeleted' => 'Удалить',
			'balance' => 'Баланс',
			'contact_count' => 'Контактов',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('age',$this->age,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('zodiac',$this->zodiac,true);
		$criteria->compare('heigth',$this->heigth,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('marital_status',$this->marital_status,true);
		$criteria->compare('sexual_orientation',$this->sexual_orientation,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('icq',$this->icq,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('last_visit',$this->last_visit);		
		$criteria->compare('last_site',$this->last_site,1);
		$criteria->compare('isdeleted',$this->isdeleted);
		$criteria->compare('isinactive',$this->isinactive);
        $criteria->compare('balance',$this->balance,true);
        $criteria->compare('status_bad',$this->status_bad,true);
        $criteria->compare('contact_count',$this->contact_count,true);
        $criteria->compare ('flags & 2',$this->premium,false);
//        $criteria->order = 'first_visit desc, id desc';
//        $criteria->compare('mainphoto','>0',true);
        //$criteria->with = 'mainphotoimage';

		return new CActiveDataProvider($this, array(
           'criteria' => $criteria,
           'pagination' => array(
               'pageSize' => 50,
               'pageVar'=>'page',
           ),
            'sort' => array('defaultOrder' => 't.id DESC')
        ));
    }
	
	public function delete(){
        $this->about = $this->about . ' |' . $this->email;
        $this->email = 'f'.$this->id.'@atolin.ru';
		$this->isdeleted = 1;
        $this->mainphoto = null;

		$this->saveAttributes(array('isdeleted','email','mainphoto','about'));
        if ($this->photos)
        foreach ($this->photos as $photo)
            $photo->deleteFiles();
		return 1;
	}

    public function getSearchPlace(){
        return 155;
    }

    protected function afterFind(){
        //static $search = array('Россия, Хабаровский край,','Россия, Московская область,');
        //substr($this->location,strpos($this->location,','))
        //$this->location=str_replace($search,'',$this->location);
        // moved to profile page and admin/anketa
        //$this->birthday = self::dateconvert($this->birthday);
//        if (strpos($this->location,'Москва'))
//            $this->location = 'Москва';
//        elseif (strpos($this->location,'Санкт-Петербург'))
//            $this->location = 'Санкт-Петербург';
//        else
        if (preg_match('#,.*,(.*)$#is', $this->location, $matches)) {
            $this->location = $matches[1];
           // $this->saveAttributes(array('location'));
        }
        parent::afterFind();
    }

    public static function date2base($date)
    {
        if (preg_match('#^(\d{2}).(\d{2}).(\d{4})$#is', $date, $matches)) {
            $date = "{$matches[3]}-{$matches[2]}-{$matches[1]}";
        }
        return $date;
    }

    public function beforeSave() {
        $this->birthday = self::date2base($this->birthday);
        $correctdate = false;
        if (preg_match('#^(\d{4}).(\d{2}).(\d{2})$#is', $this->birthday, $matches)) {
            if (checkdate($matches[2],$matches[3],$matches[1])) {
                if ($matches[1]>1900 && $matches[1]<2013)
                    $correctdate = true;
            }
        }
        if (!$correctdate) {
            $this->addError('birthday','Некорректная дата');
            return false;
        }
        $this->age = self::calculateAge($this->birthday);
        $this->zodiac = self::getZodiacByDate($this->birthday) ;// посчитать
        return true;
    }

    public static function isWelike($id1=0,$id2=0){
        $command = Yii::app()->db->createCommand("
            select status1,status2 from dislike
            where id_my in(:my,:who) and
            id_who in(:my,:who)
        ");
        $command->bindParam(':my',$id1,PDO::PARAM_INT);
        $command->bindParam(':who',$id2,PDO::PARAM_INT);
        $row = $command->queryRow();

        return ($row['status1']==$row['status2'] and $row['status1']==1 );
    }

    public static function getZodiacByDate($date) { //$month, $day) {
        $dates = explode('-',$date); //1988-01-14
        $month = (int) $dates[1]; $day = (int) $dates[2];
//        $signs = array(0=>"Козерог", 1=>"Водолей", "Рыбы", "Овен", "Телец", "Близнецы", "Рак", "Лев", "Девы", "Весы", "Скорпион", "Стрелец");
        $signsstart = array(1=>20, 2=>19, 3=>21, 4=>20, 5=>21, 6=>21, 7=>23, 8=>23, 9=>23, 10=>23, 11=>22, 12=>22,13=>20);
        $innersign = $day < $signsstart[$month] ? $month - 1 : $month % 12 ;
        $innersign = ($innersign+10)%12;
        if ($innersign==0) $innersign = 12;
        return $innersign;
      }

    public static function dateconvert($date){
        {
            if ( substr_count($date, ".")>0 )
            {
                return implode ("-",array_reverse(explode(".",$date)));
            }
            if ( substr_count($date, "/")>0 )
            {
                return implode ("-",array_reverse(explode("/",$date)));
            }
            if ( substr_count($date, "-")>0 )
            {
                return implode (".",array_reverse(explode("-",$date)));
            }
            else return $date;
        }
    }
//$this->shipdate=($this->shipdate);

    public function addlike($id) {
//        if ($id==$this->id)
//            return false;
        $command = Yii::app()->db->createCommand
            ('REPLACE INTO dislike(id_my, id_who,status1,status2,date1) VALUES(:me,:who,1,0,:now)');
        $command->bindParam(':me',$this->id,PDO::PARAM_INT);
        $command->bindParam(':who',$id,PDO::PARAM_INT);
        $command->bindParam(':now',time(),PDO::PARAM_INT);
        $command->execute();
    }
    public function adddislike($id) {
//        if ($id==$this->id)
//            return false;
        $command = Yii::app()->db->createCommand
            ('REPLACE INTO dislike(id_my, id_who,status1,status2,date1) VALUES(:me,:who,-1,0,:now)');
        $command->bindParam(':me',$this->id,PDO::PARAM_INT);
        $command->bindParam(':who',$id,PDO::PARAM_INT);
        $command->bindParam(':now',time(),PDO::PARAM_INT);
        $command->execute();
    }
    public function updlike($id){
        $this->setlike($id,1);
    }
    public function upddislike($id){
        $this->setlike($id,-1);
    }
    public function setlike($id,$status) {
//        if ($id==$this->id)
//            return false;
        $command = Yii::app()->db->createCommand(
            // id_my = :me - current user = 1st use
            'update dislike set
            date1=if (id_my=:me,:now,date1), status1= if (id_my=:me,:status,status1),
            date2=if (id_who=:me,:now,date2), status2= if (id_who=:me,:status,status2)
            where (id_my=:me and id_who=:who) or (id_who=:me and id_my=:who)'
        );
        $command->bindParam(':me',$this->id,PDO::PARAM_INT);
        $command->bindParam(':who',$id,PDO::PARAM_INT);
        $command->bindParam(':now',time(),PDO::PARAM_INT);
        $command->bindParam(':status',$status,PDO::PARAM_INT);
        $rows = $command->execute(); // количество рядов.. по идее 0/1
    }

    public function getsearchcriteria(&$searchdata) {
        $id = YII::app()->user->id;
        $criteria = new CDbCriteria(); $params = array();
        // параметры формы
        if (isset ($searchdata['location']))
                $criteria->addSearchCondition('location',$searchdata['location']);
        if (isset ($searchdata['gender']))
            if (!empty($searchdata['gender']))
            {
                $criteria->addInCondition('gender', $searchdata['gender']);
                if (isset($searchdata['mygender'])) {
                    //$searchdata['mygender'] != 
                    if (in_array($searchdata['mygender'],$searchdata['gender'])) { // убираем нормальных...
                        $criteria->addCondition('sexual_orientation<>:sexorient') && $params[':sexorient'] = 1;
                    } else { // убираем гомиков
                        $criteria->addCondition('sexual_orientation<>:sexorient') && $params[':sexorient'] = 2;
                    }
                }
            }



        if (isset($searchdata['agefrom']) && $searchdata['agefrom']>0)
                $criteria->addCondition('age>=:agefrom') && $params[':agefrom']=$searchdata['agefrom'];
        if (isset($searchdata['ageto']) && $searchdata['ageto']>0)
            $criteria->addCondition('age<=:ageto') && $params[':ageto']=$searchdata['ageto'];

        if (isset($searchdata['heigthfrom']) && $searchdata['heigthfrom'] > 0)
            $criteria->addCondition('heigth>=:heigthfrom') && $params[':heigthfrom'] = $searchdata['heigthfrom'];
        if (isset($searchdata['heigthto']) && $searchdata['heigthto'] > 0)
            $criteria->addCondition('heigth<=:heigthto') && $params[':heigthto'] = $searchdata['heigthto'];

        if (isset($searchdata['weightfrom']) && $searchdata['weightfrom'] > 0)
            $criteria->addCondition('weight>=:weightfrom') && $params[':weightfrom'] = $searchdata['weightfrom'];
        if (isset($searchdata['weightto']) && $searchdata['weightto'] > 0)
            $criteria->addCondition('weight<=:weightto') && $params[':weightto'] = $searchdata['weightto'];

        // уже есть в таблице лайков
//        if ($id) { // user
//            $criteria->join = ' LEFT JOIN `dislike` d1 on d1.id_my=' . $id . ' and d1.id_who=`t`.`id` ' .
//                              ' LEFT JOIN `dislike` d2 on d2.id_who=' . $id . ' and d2.id_my=`t`.`id` ';
//            $criteria->addCondition('ISNULL(d1.id_who) and ISNULL(d2.id_my) '); // нет в таблице лайков
//        } else { // guest
//            $guestlikes = Yii::app()->user->getState('guestlikes');
//            $viewed = array();
//            if (isset ($guestlikes['like']))
//                $viewed = array_merge($viewed,$guestlikes['like']);
//            if (isset ($guestlikes['dislike']))
//                $viewed = array_merge($viewed,$guestlikes['dislike']);
//            $criteria->addNotInCondition('id', $viewed);
//
//        }
        // просмотрен недавно - нажата "дальше"
        if (isset ($searchdata['was']))
                $criteria->addNotInCondition('id',$searchdata['was']);
        if (!Yii::app()->user->isGuest)
                        $criteria->addNotInCondition('id',array(Yii::app()->user->id));

        if (!empty ($params))
            $criteria->params = array_merge($params,$criteria->params); //array('agefrom'=>$searchdata['agefrom']);
        $criteria->scopes=array('searchable','published');
        return $criteria;
    }

    public static function getGenders() {
        return array ('1'=>'мужчина','0'=>'женщина');
    }
    public static $getZodiac =
         array(
            1 => 'Овен',
            2 => 'Телец',
            3 => 'Близнецы',
            4 => 'Рак',
            5 => 'Лев',
            6 => 'Дева',
            7 => 'Весы',
            8 => 'Скорпион',
            9 => 'Стрелец',
            10 => 'Козерог',
            11 => 'Водолей',
            12 => 'Рыбы',
        );

    public static $getSexOr = array(
          1=>'Нормальная',
          2=>'Гомо',
          3=>'Би',
    );

    public static $getSexRoles = array(
        '1'=>'актив',
        '2'=>'пассив',
        '3'=>'универсал',
        '4'=>'уни-пассив',
        '5'=>'уни-актив',
    );
    public static $getGenders =array ('1'=>'мужчина','0'=>'женщина');
    public static $getGendersGenitive =array ('1'=>'мужчину','0'=>'женщину');
    public $verifyCode;
    public $verifyPassword;
    public $oldPassword;
    public $file;
    public function getRegisterPhotoFile($filename=''){
        if (empty($filename))
            if (Yii::app()->user->hasState('registerPhoto')) {
                $filename = Yii::app()->user->getState('registerPhoto');
            }
        return //Yii::app()->basePath
            $_SERVER['DOCUMENT_ROOT'] . Yii::app()->params['tmpDir'].$filename;
    }
    public function getRegisterPhotoPath($filename=''){
        if (empty($filename))
            if (Yii::app()->user->hasState('registerPhoto')) {
                $filename = Yii::app()->user->getState('registerPhoto');
            }
        return //Yii::app()->basePath
            Yii::app()->params['tmpDir'].$filename;
    }

    public function getMainPhotoUrl($big = false){
        if (!$this->isdeleted) //!$this->isinactive &&
/*        if ($this->mainphotoimage) //  longer then per one
            return $this->mainphotoimage->pathSmall; */
        if ($this->photos) {
            if (!isset($this->photos[$this->mainphoto])) {
                $this->mainphoto = key($this->photos);
                $this->saveAttributes(array('mainphoto'));
            }
            if (!$big)
                return $this->photos[$this->mainphoto]->pathSmall;
            else
                return $this->photos[$this->mainphoto]->pathLarge;
        }
        return '/images/default_'.($this->gender?'m':'w').($big?'':'_tmb').'.gif';
    }

    public function getGenderIcon($self=true){
        return '/images/icon/icon_'.($self&&$this->gender?'m':'w').'.gif';
    }

    public function getLastVisitInfoArray()
    {
        if ($this->isOnline()) {
            $result = array(
                'status' => 'online',
                'text' => 'Сейчас на сайте',
            );
        } else if (($diff = time() - $this->last_visit) < 39600) { // 10:59 hours
            if ($diff > 3600) {
                $h = (int)($diff / 3600);
                $daily = Yii::t("app", '{n} час|{n} часа|{n} часов', $h);
            } else if ($diff > 60) {
                $h = (int)($diff / 60);
                $daily = Yii::t("app", '{n} минуту|{n} минуты|{n} минут', $h);
            }
            $daily .= ' назад';

            $result = 'Был' . ($this->gender ? '' : 'a') . ' ' . $daily;

            $result = array('status' => 'offline', 'text' => $result);
        } else {
            // $
            $daily = '';
            $last_visit = date('Ymd', $this->last_visit);
            if ($last_visit == date('Ymd'))
                $daily = 'сегодня в ' . date('H:i', $this->last_visit);
            else if ($last_visit == date('Ymd', time() - 86400))
                $daily = 'вчера в ' . date('H:i', $this->last_visit);

            $result = $this->last_visit ?
                'Был' . ($this->gender ? '' : 'a') . ' '
                    //date('d') == date('d',$this->last_visit)? 'Сегодня в '.date('H:i'):
                    . (
                $daily ? $daily :
                    str_replace('г.,', 'в', Yii::app()->dateFormatter->formatDateTime($this->last_visit, 'long', 'short'))
                )
                : 'Нет на сайте';
            $result = array(
                'status' => ($diff < 3600 * 24) ? 'offline' : 'oldline',
                'text' => $result
            );

        }
        return $result;
    }

    public function getLastVisitInfo(){
        if ($this->isOnline()) {
            $result = CHtml::tag('span',array('class'=>'online'),
                CHtml::image('/images/status_online.png').' Сейчас на сайте');
        } else if (($diff = time() - $this->last_visit) < 39600) { // 10:59 hours
            if ($diff > 3600) {
                $h = (int)($diff / 3600);
                $daily = Yii::t("app", '{n} час|{n} часа|{n} часов', $h);
            } else if ($diff > 60) {
                $h = (int)($diff / 60);
                $daily = Yii::t("app", '{n} минуту|{n} минуты|{n} минут', $h);
            }
            $daily .= ' назад';

            $result = 'Был' . ($this->gender ? '' : 'a') . ' ' . $daily;

            $result = CHtml::tag('span', array('class' => 'offline'),
                CHtml::image('/images/status_offline.png') . " $result");
        } else {
            // $
            $daily = '';
            $last_visit = date('Ymd',$this->last_visit);
            if ($last_visit == date('Ymd'))
                $daily = 'сегодня в ' . date('H:i', $this->last_visit);
            else if ($last_visit == date('Ymd', time() - 86400))
                $daily = 'вчера в ' . date('H:i', $this->last_visit);

            $result = $this->last_visit?
             'Был'.($this->gender?'':'a'). ' '
                //date('d') == date('d',$this->last_visit)? 'Сегодня в '.date('H:i'):
                 . (
             $daily ? $daily :
                 str_replace('г.,', 'в', Yii::app()->dateFormatter->formatDateTime($this->last_visit, 'long', 'short'))
             )
                :'Нет на сайте';
            $result = CHtml::tag('span', array('class'=>($diff<3600*24)?'offline':'oldline'),
                CHtml::image('/images/status_'.(($diff<3600*24)?'offline':'oldline').'.png')." $result");
        }
        return $result;
    }

    // Генерация "соли". Этот метод генерирует случайным образом слово
    // заданной длины. Длина указывается в единственном свойстве метода.
    // Символы, применяемые при генерации, указаны в переменной $chars.
    // По умолчанию, длина соли 32 символа.
    public static function randomSalt($length=32)
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime()*1000000);
        $i = 1;
        $salt = '' ;

        while ($i <= $length)
        {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $salt .= $tmp;
            $i++;
        }
        return $salt;
    }


    /**
     * new atolin functions
     */

    public function getLink(){
        return array('anketa/view','id'=>$this->id);
    }

    /**
     * Возвращает абсолютную ссылку с учётом сайта последнего визита
     */
    public function getAbsoluteLink(){
        $slugs = array('muksil.ru' => 'person');
        $link = isset ($slugs[$this->last_site]) ? $slugs[$this->last_site] : 'anketa';
        $link = 'http://www.' . $this->last_site . '/' . $link . '/' . $this->id;
        return $link;
    }

    public function getCountry(){
        return 'Россия';
    }
    public function getCity(){
        return $this->location;
    }
    public function getCountryCity(){
        return trim($this->city, '0, ');
        return trim($this->country . ', ' . $this->city, '0, ');
    }
    public static function goalsArray(){
//if ($_SERVER['REMOTE_ADDR']=='89.169.186.44')
    return explode ("||",'дружба, общение||постоянные отношения||совместное путешествие||совместная аренда жилья||регулярный секс||секс без обязательств||групповой секс||ищу спонсора||стану спонсором');
    return explode ("||",'постоянные отношения||провести вечер||ищу спонсора||стану спонсором||совместное путешествие||совместная аренда жилья');
        return explode ("\n",
'постоянные отношения
провести вечер
ищу спонсора
стану спонсором
совместное путешествие');
    }

    /* для php < 5.3*/
    public function calculateAge($birthday)
    {
        list($bYear, $bMonth, $bDay) = explode('-', $birthday);

        //function age($bMonth,$bDay,$bYear) {

        $cMonth = date('n');
        $cDay = date('j');
        $cYear = date('Y');

        if (($cMonth >= $bMonth && $cDay >= $bDay) || ($cMonth > $bMonth)) {
            return ($cYear - $bYear);
        } else {
            return ($cYear - $bYear - 1);
        }
    }

    public function reFakeVisit($city = ''){
        $q = 'UPDATE {{anketa}} set last_visit = UNIX_TIMESTAMP()
              WHERE last_visit < UNIX_TIMESTAMP()-10*24*3600 AND isdeleted=0 AND isinactive=0 AND id<4932948 ORDER BY rand() LIMIT 1';
        //$this->dbConnection->createCommand($q)->execute();
//        $q = 'UPDATE {{anketa}} set last_visit = last_visit + (UNIX_TIMESTAMP()-last_visit) * rand()
//              WHERE rand()>0.7 AND isdeleted=0 AND isinactive=0 AND isdeleted=0 AND id<4932948';

        if ($city)
            $city = " AND (location LIKE '%Москва%' OR location like '%етербург%' ) ";

        $q = 'SELECT id FROM anketa WHERE last_visit < UNIX_TIMESTAMP()-10*24*3600
            AND isdeleted=0 AND isinactive=0 AND id<4932948 '. $city .' ORDER BY rand() LIMIT 1';
        $id = $this->dbConnection->createCommand($q)->queryScalar();
        echo $id;

        $anketa = Anketa::model()->findByPk($id); /** @var $anketa Anketa */
        $anketa->last_visit = time();
        $anketa->setUp();
        $anketa->savePriority();
        $anketa->saveAttributes(array('last_visit'));
    }

    /**
     * update anketa.last_visist from MEMORY anketa_update table
     */
    public static function updateOnline(){
        $q = "UPDATE anketa a, anketa_update au
        SET a.last_visit = au.last_visit WHERE a.id = au.id;
        TRUNCATE anketa_update;";
        Yii::app()->db->createCommand($q)->execute();
    }

    public function setTop($on=true){
        if ($on) {
            if ($this->priority < 1e10)
                $this->priority += 1e10;
            $this->flags = $this->flags | (int) $on;
        } else if (!$on) {
            if ($this->priority >= 1e10)
                $this->priority -= 1e10;
            $this->flags = (int) $this->flags & (~ 1 );
        }
    }

    /**
     * @param $task untop
     * @param $time additional time
     */
    public function setTaskTimer($task,$time){
        $q =
            'INSERT INTO `task` (id_user, `type`,time_task,`data`,status)
VALUES (:id_user,:type,:time_task+UNIX_TIMESTAMP(),:data,:status)
ON DUPLICATE KEY UPDATE
 time_task = time_task + :time_task,status=:status;';
        Yii::app()->db->createCommand($q)->execute(array(
            ':id_user'=>$this->id,
            ':type'=>$task,
            ':time_task'=>$time,
            ':data'=>'',
            ':status'=>1
        ));
    }

    public function getTop(){
        return $this->flags & 1;
    }

    public function setUp(){
        $this->priority = time();
        if ($this->top)
            $this->priority += 1e10;
    }

    public function savePriority(){
        $this->saveAttributes(array('flags','priority'));
    }

    public function addBalance($balance) {
        return $this->updateCounters(array('balance'=>$balance),'id='.$this->id);
    }

    public function next(){
        if ($this->priority < 1e10)
            $addq = ' AND priority < 1e10 ';
        else $addq = '';

        $q = "select * from (
SELECT @n := @n +1 AS rownum, a.id FROM anketa AS a
WHERE a.id IN
( SELECT id FROM  `anketa`, (select @n:=0) as xx
WHERE isdeleted=0 AND isinactive=0 AND gender = :gender
and NOT ( 1 & status_bad) $addq
)
ORDER BY a.priority DESC, a.id DESC) x where rownum=:rownum";
        $res = Yii::app()->db->createCommand($q)->queryRow(true,array(':gender'=>$this->gender
        ,':rownum'=>$this->place+1));//':city'=>'%'.$this->city.'%'
        $model = Anketa::model()->findByPk($res['id']);
        return $model;
    }

    /**
     * Фильтрация контактов в имени. !Болванка
     * @return string
     */
    public function getPublicName(){
        $name = $this->attributes['name'];
//        if ($this->getAccountType() == self::ACCOUNT_PREMIUM)
//            return $name;
//        if (!Yii::app()->getUser()->isGuest && $this->id == Yii::app()->user->id)
//            return $name;
//        if (TmpHelper::filterContact($name) != $name)
//            return 'Без имени *';
        return $name;
    }

    public function getPlace(){
        static $place=array();
        if (!isset($place[$this->id])) {
            if ($this->priority < 1e10)
                $addq = ' AND priority < 1e10 ';
            else $addq = '';
        $q = "select * from (
SELECT @n := @n +1 AS rownum, a.id FROM anketa AS a
WHERE a.id IN
( SELECT id FROM  `anketa`, (select @n:=0) as xx
WHERE isdeleted=0 AND isinactive=0 AND gender = :gender
and NOT ( 1 & status_bad) $addq
)
ORDER BY a.priority DESC, a.id DESC) x where id=:id";
            //echo $q;
        $res = Yii::app()->db->createCommand($q)->queryRow(true,array(':gender'=>$this->gender
        ,':id'=>$this->id));//':city'=>'%'.$this->city.'%',
        $place[$this->id] = $res['rownum'];
        }
        return $place[$this->id];
    }

    public function getAccountType(){
        //static $account_type = null;
        //if ($account_type === null) {
            if ($this->getPremium()) $account_type = self::ACCOUNT_PREMIUM;
            elseif ($this->trial_end>time()) $account_type = self::ACCOUNT_TRIAL;
            else $account_type =  self::ACCOUNT_BASE;
       // }
        return $account_type;
    }

    public static function getAccountTypes()
    {
        return array(
            self::ACCOUNT_BASE => 'Базовый',
            self::ACCOUNT_TRIAL => 'Пробный',
            self::ACCOUNT_PREMIUM => 'Премиум',
        );
    }

    public function getAccountTypeText(){
        $types = self::getAccountTypes();
        return $types[$this->getAccountType()];
    }

    /**
     * @return int|mixed AccountEndTime
     */
    public function getAccountEndTime(){
        switch ($this->getAccountType()) {
            case self::ACCOUNT_BASE: return 0;
            case self::ACCOUNT_TRIAL: return $this->trial_end;
            case self::ACCOUNT_PREMIUM:
                if ($this->premium_end->time_task <=time()) {
                    $this->setPremium(0);
                    $this->savePriority();
                }
                return $this->premium_end->time_task;
            default: return 0;
        }
    }

    public function addBonusBalance ($balance){
        $data = array(
            'admin'=>Yii::app()->user->id,
            'ip'=>$_SERVER['REMOTE_ADDR'],
            'description'=>'Бонус от сервиса',
        );
        $transaction = new Btransaction;
        $transaction->amount = $balance;
        $transaction->id_user = $this->id;
        $transaction->id_operation = 2;
        $transaction->time_end =
        $transaction->time_start = time();
        $transaction->amount_real = 0;
        $transaction->time_end = time();
        $transaction->status = 1;
        $transaction->info = serialize($data);
        $transaction->description = 'Бонус от сервиса';
        if($transaction->save(false))
            $this->addBalance($transaction->amount);
        else
            return false;
        return true;
    }

    public function addBonusContacts($contacts) {
        return $this->updateCounters(array('contact_count'=>$contacts),'id='.$this->id);
    }

    public function getDialogCount(){
        $q = '
SELECT DISTINCT count(id_opponent) as dialog_count
FROM(
SELECT DISTINCT id_from as id_opponent FROM `message` WHERE id_to=:id
UNION
SELECT DISTINCT id_to as id_opponent FROM `message` WHERE id_from=:id) a';
        $dialog_count = Yii::app()->db->createCommand($q)->queryScalar(array(':id'=>$this->id));
        return $dialog_count;
    }

    public function getIsPaid(){
        return true;
    }

    //2 недели – 100 рублей и 30 дней – 180 рублей
    public function setPremium($on=true){
        // it's magic :)
        if ($on === null || $on === '')
            $this->premium = null;
        elseif ($on)
            $this->premium = $this->flags |= 2;
        else
            $this->premium = $this->flags &= ~2;
    }

    public function getPremium () {
        if ($this->premium===null)
            return null;
        return $this->flags & 2;
    }

    const DISALLOW_MESSAGE_NONE = 0;
    const DISALLOW_MESSAGE_NOPREMIUM = 3; //
    const DISALLOW_MESSAGE_NOCONTACTS = 4; //
    const DISALLOW_MESSAGE_WOMAN2WOMAN = 5; //

    const DISALLOW_MESSAGE_BAN = 17; //
    const DISALLOW_MESSAGE_CLONE = 18; //

    const DISALLOW_MESSAGE_IS_GUEST = 21; //

    const DISALLOW_MESSAGE_IGNORE_I = 31; //
    const DISALLOW_MESSAGE_IGNORE_ME = 32; //

    const DISALLOW_MESSAGE_ERROR = 999;
    const DISALLOW_MESSAGE_ERROR2 = 998;
    const DISALLOW_MESSAGE_BUG_1 = 801;

    const BAD_STATUS_NONE = 0;
    const BAD_STATUS_CLONE = 1; // 001
    const BAD_STATUS_CLONE_RESET = 2; // 010
    const BAD_STATUS_BAN = 3; // 011
    const BAD_STATUS_BAN_RESET = 4; // 100
    const BAD_STATUS_PAID = 8; // 1000

    const FOLDER_ID_IGNORE = 2; // черный список

    public static $bad_statuses = array (
        self::BAD_STATUS_NONE => '',
        self::BAD_STATUS_CLONE => 'Клон',
        self::BAD_STATUS_CLONE_RESET => 'Клон снят',
        self::BAD_STATUS_BAN => 'Забанен',
        self::BAD_STATUS_BAN_RESET => 'Бан снят',
        self::BAD_STATUS_PAID => 'Проплачен',
    );

    public static $bad_statuses_reset = array(
        self::BAD_STATUS_CLONE => 'Простить!',
        self::BAD_STATUS_BAN => 'Разбанить!',
    );

    public function checkIgnore($anketa){
        if(!$id_from = $this->dbConnection->createCommand('SELECT id_from FROM message2folder WHERE
        (id_from =:id_me AND id_to=:id_user AND id_folder=:id_folder) OR (id_from=:id_user AND id_to=:id_me AND id_folder=:id_folder)
        ORDER BY id_from=:id_me DESC')->queryScalar(array(':id_me'=>$this->id,':id_user'=>$anketa->id,':id_folder'=>self::FOLDER_ID_IGNORE)))
            return false;
        else if ($id_from == $this->id)
            return self::DISALLOW_MESSAGE_IGNORE_I;
        else
            return self::DISALLOW_MESSAGE_IGNORE_ME;
    }

    /**
     * @param $anketa Anketa
     * @return int
     */
    public function disallowMessageTo($anketa){
        if (is_int($anketa)) $anketa = Anketa::model()->findByPk($anketa);
        if (!$anketa || $anketa->isdeleted)
            return self::DISALLOW_MESSAGE_ERROR;
        if ($this->isAdmin || $anketa->isAdmin) return self::DISALLOW_MESSAGE_NONE; // ok Admin

        if ($ignore = $this->checkIgnore($anketa)) // Чёрный список - папка
            return $ignore;

        if ($this->status_bad == self::BAD_STATUS_BAN)
            return self::DISALLOW_MESSAGE_BAN;
        else if ($this->status_bad == self::BAD_STATUS_CLONE)
            return self::DISALLOW_MESSAGE_CLONE;


        // если они оплачивают абонентку
        if ($this->getAccountType() == Anketa::ACCOUNT_PREMIUM ||
            // или пробный аккаунт у мужчин
            $this->getAccountType() == Anketa::ACCOUNT_TRIAL && $this->gender == self::GENDER_MAN
        ) {
            if ($this->wasDialogTo($anketa))
                return self::DISALLOW_MESSAGE_NONE; // ok
            return $this->contact_count>0 ? self::DISALLOW_MESSAGE_NONE : self::DISALLOW_MESSAGE_NOCONTACTS;
        }
        //отключаем возможность переписки между девушками
        if ($this->gender == self::GENDER_WOMAN && $anketa->gender == self::GENDER_WOMAN) {
            if ($starter = $this->wasDialogTo($anketa)) // если уже общались
                if ($starter != $this->id // если пишет не тот, кто начал или у стартера есть прем
                    || $starter == $this->id && $this->getAccountType() == Anketa::ACCOUNT_PREMIUM )
                return self::DISALLOW_MESSAGE_NONE;
            if ($this->id == 4938278)//4938278
                return self::DISALLOW_MESSAGE_BUG_1;
            return self::DISALLOW_MESSAGE_WOMAN2WOMAN;
        }
        // ж
        if ($this->gender == self::GENDER_WOMAN) { //return self::DISALLOW_MESSAGE_NONE;
            if ($this->wasDialogTo($anketa))
                return self::DISALLOW_MESSAGE_NONE; // если уже общались
            return $this->contact_count>0 ? self::DISALLOW_MESSAGE_NONE : self::DISALLOW_MESSAGE_NOCONTACTS;
        }

        //при отключенной абонентке мужчина не может отвечать девушкам
        if ($this->gender == self::GENDER_MAN) return self::DISALLOW_MESSAGE_NOPREMIUM;
        // по идее, сюда не должно дойти
        return self::DISALLOW_MESSAGE_ERROR2;
    }
    /**
     * @param $anketa Anketa
     * @return bool
     */
    public function canMessageTo($anketa){
        return ! $this->disallowMessageTo($anketa);
    }

    public function getIsAdmin(){
        return $this->id == 4932794;
    }

    /**
     * Проверка, был ли ранее диалог с анкетой
     * @param $anketa напарник
     * @param null $id2 если не указан $this->id
     * @return mixed null или id того, кто начал беседу
     */
    public function wasDialogTo($anketa,$id2=null) {
        $id1 = is_a($anketa,'Anketa') ? $anketa->id : $anketa;
        $id2 = $id2 ? $id2 : $this->id;
        return Yii::app()->db->createCommand('SELECT id_from from {{message}} WHERE
        (id_from=:id1 AND id_to = :id2) OR (id_from=:id2 AND id_to=:id1) ORDER BY `datestamp` LIMIT 0,1')
            ->queryScalar(array(':id1'=>$id1,':id2'=>$id2));
    }

    public static function getCities() {
        $data = file_get_contents(Yii::getPathOfAlias('webroot.protected.data').'/cities.txt');
        $cities = explode("\n",$data);
        $cities = array_map("trim",$cities);
        $top_cities = array();
        $top_cities[] = array_shift($cities);
        $top_cities[] = array_shift($cities);
        return array(
            'Две столицы:'=>array_combine($top_cities,$top_cities),
            'Украина:'=>array('Украина'=>"Украина"),
            'Города России:'=>array_combine($cities,$cities)
        );
    }

    public function isBad(){
        return 1 & $this->status_bad;
    }

    public function setBad($status_bad=null){
        if (empty($status_bad)) { // unbad
            if ($this->status_bad & 1)
                $this->status_bad = $this->status_bad + 1;
        } else {
            $this->status_bad = $status_bad;
            $this->disableRequests();
        }
        if ($this->status_bad == self::BAD_STATUS_CLONE) {
            // $this->contact_count = 0;
        }
        $this->saveAttributes(array('status_bad','contact_count'));
    }

    /**
     * Возвращает клонов, в том числе и СЕБЯ!
     * @return array Anketa clones
     */
    public function findClones(){
        if ($this->a2cookie) {
            $anketas = explode('_',trim($this->a2cookie->cookie,'_'));
            $clones = Anketa::model()->findAllByPk($anketas);
            return $clones;
        }
        return array();
    }

    public function findEtagClones(){
        if ($etag = Yii::app()->db->createCommand('SELECT cookie FROM anketa2etag WHERE id =:id')->
            queryScalar(array(':id' => $this->id))) {
            $ids = explode(':',$etag);
            return Anketa::model()->findAllByPk($ids);
        }
        return null;
    }

    public function getLastClone(){
        if ($this->a2cookie) {
            $anketas = explode('_',trim($this->a2cookie->cookie,'_'));
            $anketas = array_diff($anketas,array(Yii::app()->user->id));
            $clones = Anketa::model()->findByPk($anketas,array('order'=>'first_visit DESC','limit'=>1));

            return $clones;
        }
    }

    public function checkClone(){
        if ($this->getAccountType() == Anketa::ACCOUNT_PREMIUM)
            return; // премиум(?)
        if ($this->status_bad)
            return; // уже клон/бан или снятый клон/бан
        static $wasHere = 0;
        if ($this->id == Yii::app()->user->id)
        Yii::log($this->id.' fp='.Yii::app()->user->getState('AnketaFingerprint').' | '.$_SERVER['REQUEST_URI'],CLogger::LEVEL_INFO,'checkClone');
        $status_bad = self::BAD_STATUS_NONE;
        foreach ($this->findClones() as $clone) { /** @var $clone Anketa */
            if ($this->first_visit <= $clone->first_visit) // если анкета зарегистрирована раньше клона
                continue;
            if ($clone->status_bad == self::BAD_STATUS_BAN)
                $status_bad = self::BAD_STATUS_BAN;
            else
                $status_bad = self::BAD_STATUS_CLONE;
            Yii::log('bad_status '.$status_bad. ' '.$this->id .' <- '.$clone->id,CLogger::LEVEL_INFO,'ban');
        }

        if ($status_bad == self::BAD_STATUS_NONE)
            if ($this->findEtagClones())
            foreach ($this->findEtagClones() as $clone) { /** @var $clone Anketa */
                if ($this->first_visit <= $clone->first_visit) // если анкета зарегистрирована раньше клона
                    continue;
                if ($clone->status_bad == self::BAD_STATUS_BAN)
                    $status_bad = self::BAD_STATUS_BAN;
                else
                    $status_bad = self::BAD_STATUS_CLONE;
                Yii::log('bad_status '.$status_bad. ' '.$this->id .' <- Etag '.$clone->id,CLogger::LEVEL_INFO,'ban');
            }


        if ($status_bad == self::BAD_STATUS_NONE)
        if ($this->id == Yii::app()->user->id) {

            $attributes = array();
            $attributes[] = array('type'=>FingerprintBan::TYPE_IP,'value'=>$_SERVER['REMOTE_ADDR']);
            if (Yii::app()->user->getState('FingerprintChecked',0)===false) {
                $wasHere ++;
            }

            if ($fp = Yii::app()->user->getState('AnketaFingerprint'))
            if ($fp = AnketaFingerprint::model()->findByPk($fp)) { // бан по fingerprints
            foreach (FingerprintBan::$types as $k=>$v) {
                $attributes[] = array('type'=>$v,'value'=>md5($fp->$k));
            }
            }

            foreach ($attributes as $k=>$v) {
                if ($fb = FingerprintBan::model()->findByAttributes($v)) {
                    $status_bad = $fb->status_bad;
                    break;
                }
            }

            if ($status_bad != self::BAD_STATUS_NONE) {
                Yii::log('bad_status '.$status_bad. ' '. $this->id. ' <- '. FingerprintBan::$typesText[$fb->type].' '.$fb->value. ' ',CLogger::LEVEL_INFO,'ban');
            }
            if ($fp || !$wasHere)
                Yii::app()->user->setState('FingerprintChecked',1);
            else
                Yii::app()->user->setState('FingerprintChecked',false);
        }

        // За клонов до введения оплаты не блокируем.
        if ($status_bad == self::BAD_STATUS_CLONE)
            $status_bad = self::BAD_STATUS_NONE;

        // авторазбан при входе
        if ($status_bad != self::BAD_STATUS_NONE)
            if ($this->totalPaid > 0)
                $status_bad = self::BAD_STATUS_PAID;
        $this->setBad($status_bad);
        if ($status_bad & 1) {
            $this->trialReset();
        }
    }
    public function trialReset() {
        $this->trial_end = time();
        $this->saveAttributes(array('trial_end'));
    }

    public function getNewVisitors() {
        if (!$lastcheck = Yii::app()->db->createCommand('SELECT datestamp FROM stat_visitors WHERE id = :id')->queryScalar(array(':id'=>$this->id)))
            $lastcheck = 1381297949; // magick. Time to start checking
        $lastcheck = max($lastcheck, time()-3600*24*14); // 2 недели

        $q = 'SELECT count(id_user) as cnt FROM stat_viewed WHERE id_viewed = :id and datestamp>:lastcheck';
        /* AND datestamp > (
SELECT datestamp FROM (
SELECT datestamp FROM stat_visitors WHERE id = :id
UNION
SELECT 1381297949) t
LIMIT 0,1) t1 */
        if (!$cnt = Yii::app()->db->createCommand($q)->queryScalar(array(':id'=>$this->id,':lastcheck'=>$lastcheck)))
            $cnt = 0;
        return $cnt;
    }


    /**
     * Блок работы с заявками
     * @return mixed|null
     */
    public function getLastRequestVisit(){
        $v = AnketaVar::model()->findByPk(array('id'=>$this->id,'id_var'=>1));
        if (!$v)
            return null;
        else
            return $v->value;
    }
    public function setLastRequestVisit($value){
        AnketaVar::setValue(array('id'=>$this->id,'id_var'=>1,'value'=>$value));
    }

    public function disableRequests(){
        Yii::app()->db->createCommand('UPDATE request SET isdeleted=1 WHERE id_user = :id_user')
            ->execute(array(':id_user'=>$this->id));
    }

    /**
     * @return int число для отображения в меню, заявок или ответов.
     */
    public function getNewRequestCount() {
        //return null;
        $time = $this->getLastRequestVisit();
        $ret = array(0,0);
        //if ($this->gender == self::GENDER_MAN) { // количество откликов на текущую заявку
            if ($request = Request::model()->find('id_user = :id_user and isdeleted = 0', array(':id_user'=>Yii::app()->user->id))) {
                $cnt = Request2anketa::model()->newer($time)->countByAttributes(array('id_request'=>$request->id, 'status'=>1));
                $ret[1] = $cnt;
            }

        //} else { // количество новых заявок в этом городе для женщин
            $cnt = Request::model()->published()->byCity($this->city)->newer($this->getLastRequestVisit())
                ->count();
            $ret[0] = $cnt;
        //}
        if ($ret[0] > 0 || $ret[1] > 0)
            $ret = implode('/', $ret);
        else
            $ret = null;
        return $ret;
    }
}
// ALTER TABLE `anketa` ADD `status_bad` TINYINT NOT NULL DEFAULT '0' AFTER `flags`
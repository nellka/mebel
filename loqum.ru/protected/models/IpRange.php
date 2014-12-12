<?php

/**
 * This is the model class for table "ip_range".
 *
 * The followings are the available columns in table 'ip_range':
 * @property string $id
 * @property string $ip_from
 * @property string $ip_to
 * @property string $timestamp
 * @property string $description
 */
class IpRange extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IpRange the static model class
	 */
    public $_ip1;
    public $_ip2;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ip_range';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip_from, ip_to, timestamp', 'length', 'max'=>11),
			array('description', 'length', 'max'=>500),
            array('ip1,ip2','filter','filter'=>'trim'),
            array('_ip1, _ip2','ext.validators.ipvalidator.IPValidator','version' => 'v4','message'=>'{attribute} не является правильным IP-адресом'),
            array('ip_from','compare','compareAttribute'=>'ip_to','operator'=>'<','message'=>'Начало диапазона должно быть меньше конца'),
            array('ip2','length','max'=>55),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip_from, ip_to, timestamp, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ip_from' => 'Начало',
			'ip_to' => 'Конец',
			'timestamp' => 'Добавлен',
			'description' => 'Примечание',
		);
	}

    public function beforeSave() {
        if ($this->isNewRecord && !$this->timestamp)
            $this->timestamp = time();
        if ($this->_ip1)
            $this->ip_from = ip2long($this->_ip1);
        if ($this->_ip2)
            $this->ip_to = ip2long($this->_ip2);
        return parent::beforeSave();
    }

    public function beforeValidate(){
        if ($this->ip1 && empty ($this->ip_from))
            $this->ip_from = ip2long($this->ip1);
        if ($this->ip2 && empty ($this->ip_to))
            $this->ip_to = ip2long($this->ip2);
        return true;
    }

    public function afterSave(){
        $this->deleteIpData();
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('ip_from',$this->ip_from,true);
		$criteria->compare('ip_to',$this->ip_to,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array('pageSize' => 50),
		));
	}

    public function getIp1(){
        if (empty ($this->_ip1))
            $this->_ip1 = long2ip($this->ip_from);
        return $this->_ip1;
    }
    public function getIp2(){
        if (empty ($this->_ip2))
            $this->_ip2 = long2ip($this->ip_to);
        return $this->_ip2;
    }

    public function setIp1($data){
        $this->_ip1 = trim($data);
        //$this->ip_from = ip2long($data);
    }
    public function setIp2($data){
        $this->_ip2 = trim($data);
        //$this->ip_to = ip2long($data);
    }

    public function deleteIpData(){
        $q = "DELETE FROM anketa2ip WHERE INET_ATON(ip) BETWEEN {$this->ip_from} AND {$this->ip_to}";//GK
        $this->dbConnection->createCommand($q)->execute();
    }

}
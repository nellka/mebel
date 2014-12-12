<?php

/**
 * This is the model class for table "stat_viewed".
 *
 * The followings are the available columns in table 'stat_viewed':
 * @property string $id
 * @property string $id_user
 * @property string $id_viewed
 * @property string $timestamp
 * @property integer $sent
 */
class StatViewed extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatViewed the static model class
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
		return 'stat_viewed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, datestamp', 'required'),
			//array('sent', 'numerical', 'integerOnly'=>true),
			array('id_user, id_viewed, datestamp', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, id_viewed, datestamp, sent', 'safe', 'on'=>'search'),
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
			'id_user' => 'Id User',
			'id_viewed' => 'Id Viewed',
			'timestamp' => 'Timestamp',
			'sent' => 'Sent',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('id_viewed',$this->id_viewed,true);
		$criteria->compare('datestamp',$this->datestamp,true);
		$criteria->compare('sent',$this->sent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
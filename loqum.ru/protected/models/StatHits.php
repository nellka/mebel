<?php

/**
 * This is the model class for table "stat_hits".
 *
 * The followings are the available columns in table 'stat_hits':
 * @property string $id_hit
 * @property string $id_sess
 * @property string $timestamp
 * @property string $page
 */
class StatHits extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatHits the static model class
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
		return 'stat_hits';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('timestamp', 'required'),
			array('id_sess, timestamp', 'length', 'max'=>11),
			array('page', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_hit, id_sess, timestamp, page', 'safe', 'on'=>'search'),
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
			'id_hit' => 'Id Hit',
			'id_sess' => 'Id Sess',
			'timestamp' => 'Timestamp',
			'page' => 'Page',
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

		$criteria->compare('id_hit',$this->id_hit,true);
		$criteria->compare('id_sess',$this->id_sess,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('page',$this->page,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
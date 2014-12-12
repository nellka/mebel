<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $id
 * @property string $id_user
 * @property integer $id_service
 * @property integer $amount
 * @property integer $amount_real
 * @property integer $time_start
 * @property integer $time_end
 * @property string $src
 * @property string $info
 * @property integer $status
 */
class Order extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_service, amount, amount_real, time_start, time_end, status', 'required'),
			array('id_service, amount, amount_real, time_start, time_end, status', 'numerical', 'integerOnly'=>true),
			array('id_user', 'length', 'max'=>20),
			array('src', 'length', 'max'=>10),
			array('info', 'length', 'max'=>1022),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, id_service, amount, amount_real, time_start, time_end, src, info, status', 'safe', 'on'=>'search'),
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
			'id_service' => 'Id Service',
			'amount' => 'Amount',
			'amount_real' => 'Amount Real',
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
			'src' => 'Src',
			'info' => 'Info',
			'status' => 'Status',
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
		$criteria->compare('id_service',$this->id_service);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('amount_real',$this->amount_real);
		$criteria->compare('time_start',$this->time_start);
		$criteria->compare('time_end',$this->time_end);
		$criteria->compare('src',$this->src,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
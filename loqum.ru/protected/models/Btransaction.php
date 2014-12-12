<?php

/**
 * This is the model class for table "btransaction".
 *
 * The followings are the available columns in table 'btransaction':
 * @property string $id
 * @property string $id_user
 * @property integer $id_operation
 * @property integer $amount
 * @property integer $amount_real
 * @property integer $time_start
 * @property integer $time_end
 * @property string $src
 * @property string $info
 * @property integer $status
 */
class Btransaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Btransaction the static model class
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
		return 'btransaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_operation, amount, time_start', 'required'),//amount_real, time_start, time_end, status
			array('id_operation, amount, amount_real, time_start, time_end, status', 'numerical', 'integerOnly'=>true),
			array('id_user', 'length', 'max'=>20),
			array('src', 'length', 'max'=>10),
			array('info', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, id_operation, amount, amount_real, time_start, time_end, src, info, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        //         $alias = $this->getTableAlias(false,false);
        return array(
            'user' => array(self::BELONGS_TO, 'Anketa', 'id_user'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Пользователь',
			'id_operation' => 'Операция',
			'amount' => 'Сумма',
			'amount_real' => 'Сумма Реал',
			'time_start' => 'Начало',
			'time_end' => 'Завершение',
			'description' => 'Описание',
			'src' => 'Src',
			'info' => 'Info',
			'status' => 'Статус',
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
		$criteria->compare('id_operation',$this->id_operation);
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
    public function searchFront()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $this->status = 1;
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('id_user',$this->id_user,true);
        $criteria->compare('id_operation',$this->id_operation);
        $criteria->compare('amount',$this->amount);
        $criteria->compare('amount_real',$this->amount_real);
        $criteria->compare('time_start',$this->time_start);
        $criteria->compare('time_end',$this->time_end);
        $criteria->compare('src',$this->src,true);
        $criteria->compare('info',$this->info,true);
        $criteria->compare('status',$this->status);
        $criteria->limit = 50;
        $criteria->order = 'time_start  DESC';


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,

        ));
    }
}
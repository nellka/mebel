<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $product_id
 * @property string $model
 * @property string $sku
 * @property integer $quantity
 * @property string $image
 * @property string $price
 * @property integer $status
 * @property string $date_added
 * @property integer $viewed
 */
class Order extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	const STATUS_CREATED = 0;
    const STATUS_IN_WORK = 1;    
    
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
	        /*array('order_id,user_id,order_status_id', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>500),
			array('ip', 'length', 'max'=>255),			
			array('date', 'safe'),*/
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('order_id,user_id,order_status_id,comment,ip,date', 'safe', 'on'=>'search'),
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
			'product_id' => 'ProductID',
			'model' => 'Название',
			'sku' => 'Артикул',
			'quantity' => 'Количество',
			'image' => 'Изображение',
			'price' => 'Цена',
			'status' => 'Отображать',
			'date_added' => 'Дата добавления',
			'viewed' => 'Просмотров',
			'category_id' => 'Категория'
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('order_status_id',$this->order_status_id,true);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
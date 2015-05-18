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
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
     public static $getStatus =array ('1'=>'Да','0'=>'Нет');
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model', 'required'),			
			array('quantity, status, viewed, category_id', 'numerical', 'integerOnly'=>true),			
			array('model', 'length', 'max'=>64),
			array('sku', 'length', 'max'=>150),
			array('image', 'length', 'max'=>255),
			array('price', 'length', 'max'=>15),
			array('date_added', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_id,category_id, model, sku, quantity, image, price, status, date_added, viewed', 'safe', 'on'=>'search'),
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

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('viewed',$this->viewed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
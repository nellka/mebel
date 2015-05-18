<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $category_id
 * @property integer $parent_id
 * @property integer $disabled
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
     public static $getDisabled =array ('1'=>'Да','0'=>'Нет');
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, disabled', 'numerical', 'integerOnly'=>true),		
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_id, parent_id,title, disabled', 'safe', 'on'=>'search'),
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
			'parent'=>array(self::BELONGS_TO, 'category', 'parent_id'),
		);
	}
    public function all($category_id=0){
    	$criteria = Yii::app()->db->createCommand()
		    ->select(array('category_id','title'))
		    ->from('category');				       
		if($category_id){
			$criteria->where('category_id <>:category_id', array(':category_id'=>$category_id));
		}  
		$Categories = array();
		foreach ($criteria->queryAll() as $cat){
			$Categories[$cat['category_id']] = $cat['title'] ;
		}
		return $Categories;	
    }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => 'CatID',
			'title' => 'Название категории',
			'parent_id' => 'Родительская категория',
			'disabled' => 'Отключено',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function getTitle($category_id)
	{
		$category = Category::model()->findByPk($category_id);
		return $category->title;
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('title',$this->title);
		$criteria->compare('disabled',$this->disabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
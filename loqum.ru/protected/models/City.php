<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property integer $id
 * @property string $alias
 * @property string $name
 * @property string $status
 * @property integer $order
 */
class City extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return City the static model class
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
		return 'city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, order', 'numerical', 'integerOnly'=>true),
			array('alias, name', 'length', 'max'=>75),
			array('status', 'length', 'max'=>1),
            array('alias','ext.components.translit.ETranslitFilter','translitAttribute'=>'name'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, alias, name, status, order', 'safe', 'on'=>'search'),
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
			'alias' => 'Alias',
			'name' => 'Name',
			'status' => 'Status',
			'order' => 'Order',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getLink()
    {
        return '/city/' . $this->alias;
    }

    public function getSeoParams()
    {
        $domain = isset($_GET['d']) ? $_GET['d'] : $_SERVER['HTTP_HOST'];
        $domain = preg_replace('#^www\.#','',$domain);
        return 'id=' . $this->id . '&d=' . $domain;
    }

    public function behaviors() {
        return array(
            'SEOBehavior' => array(
                'class' => 'ext.behaviors.model.SEOBehavior',
                'route' => 'city/view',
            ),
        );
    }

}
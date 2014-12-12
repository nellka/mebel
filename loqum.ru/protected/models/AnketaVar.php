<?php

/**
 * This is the model class for table "anketa_var".
 *
 * The followings are the available columns in table 'anketa_var':
 * @property string $id
 * @property string $id_var
 * @property string $value
 */
class AnketaVar extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnketaVar the static model class
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
		return 'anketa_var';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_var, value', 'required'),
			array('id, value', 'length', 'max'=>20),
			array('id_var', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_var, value', 'safe', 'on'=>'search'),
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
			'id_var' => 'Id Var',
			'value' => 'Value',
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
		$criteria->compare('id_var',$this->id_var,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     *
     */
    public static function setValue($data){
        $q = " INSERT INTO anketa_var SET id = :id, id_var = :id_var, value = :value
                ON DUPLICATE KEY UPDATE value = :value";
        Yii::app()->db->createCommand($q)->execute(array(
            ':id'=>$data['id'],
            ':id_var'=>$data['id_var'],
            ':value'=>$data['value'],
        ));
    }
}
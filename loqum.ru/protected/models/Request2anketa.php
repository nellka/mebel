<?php

/**
 * This is the model class for table "request2anketa".
 *
 * The followings are the available columns in table 'request2anketa':
 * @property string $id_request
 * @property string $id_anketa
 * @property string $time
 */
class Request2anketa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Request2anketa the static model class
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
		return 'request2anketa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_anketa, time', 'required'),
			array('id_anketa', 'length', 'max'=>20),
			array('time', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_request, id_anketa, time', 'safe', 'on'=>'search'),
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
            'user'=>array(self::HAS_ONE,'Anketa',array('id'=>'id_anketa',)),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_request' => 'Id Request',
			'id_anketa' => 'Id Anketa',
			'time' => 'Time',
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

		$criteria->compare('id_request',$this->id_request,true);
		$criteria->compare('id_anketa',$this->id_anketa,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function mark($id_request, $id_anketa = null, $on = true) {
        if (empty($id_anketa))
            $id_anketa = Yii::app()->user->id;
        $params = array(':id_request'=>$id_request, ':id_anketa'=>$id_anketa);
        if ($on) {
            $status = $on == 1 ? 1 : 0;
            $q = 'INSERT IGNORE into request2anketa SET id_request=:id_request, id_anketa=:id_anketa, time=:time, status=:status';
            $params[':time'] = time(); $params[':status'] = $status;
        } else {
            $q = 'DELETE FROM request2anketa WHERE id_request=:id_request AND id_anketa = :id_anketa';
        }
        Yii::app()->db->createCommand($q)->execute($params);
    }

    public static function checkAnswer($id_request, $id_anketa = null) {
        if (empty($id_anketa))
            $id_anketa = Yii::app()->user->id;
        $q = ' SELECT status FROM request2anketa WHERE id_request=:id_request AND id_anketa=:id_anketa ';
        return Yii::app()->db->createCommand($q)->queryScalar(array(':id_request'=>$id_request,':id_anketa'=>$id_anketa));
    }

    public function newer($time=null) {
        if ($time)
            $this->getDbCriteria()->mergeWith(array(
                'condition'=>'time>:time',
                'params'=>array(':time'=>$time)
            ));
        return $this;
    }

    // public static function checkRequest

}
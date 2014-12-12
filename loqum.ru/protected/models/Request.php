<?php

/**
 * This is the model class for table "request".
 *
 * The followings are the available columns in table 'request':
 * @property string $id
 * @property string $id_user
 * @property string $time_start
 * @property string $time_end
 * @property string $text
 * @property integer $isvisible
 * @property integer $isdeleted
 */
class Request extends CActiveRecord
{
    const DEFAULT_REQUEST_TIME = 43200;// 12*3600
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Request the static model class
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
		return 'request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, time_start, time_end, text', 'required'),
			array('isvisible, isdeleted', 'numerical', 'integerOnly'=>true),
			array('id_user', 'length', 'max'=>20),
			array('time_start, time_end', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, time_start, time_end, text, isvisible, isdeleted', 'safe', 'on'=>'search'),
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
            'user'=>array(self::HAS_ONE,'Anketa',array('id'=>'id_user',)),
            'answers'=>array(self::HAS_MANY,'Request2anketa',array('id_request'=>'id',),'order'=>'answers.time DESC', 'condition'=>'status = 1'),
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
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
			'text' => 'Текст заявки',
			'isvisible' => 'Isvisible',
			'isdeleted' => 'Isdeleted',
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
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('time_end',$this->time_end,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('isvisible',$this->isvisible);
		$criteria->compare('isdeleted',$this->isdeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function scopes()
    {
        $alias = $this->getTableAlias(false,false);
        return array(
            'published'=>array(
                'condition'=>"$alias.isvisible=1 AND $alias.isdeleted=0 AND $alias.time_end>UNIX_TIMESTAMP()",//count>0
            ),
            'sorted'=>array(
                'order'=>'time_start DESC',
            )
        );
    }

    public function byCity($city=''){
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'city = :city',
            'params'=>array(':city'=>$city),
        ));
        return $this;
    }

    public function newer($time_start=null) {
        if ($time_start)
            $this->getDbCriteria()->mergeWith(array(
                'condition'=>'time_start>:time_start',
                'params'=>array(':time_start'=>$time_start)
            ));
        return $this;
    }

    public static function checkStatus() {
        Yii::app()->db->createCommand('UPDATE request SET isdeleted = 1 WHERE time_end < UNIX_TIMESTAMP()')->execute();
    }

    public function saveReply($id_user = null, $delete = 0) {
        if (empty($id_user))
            $id_user = Yii::app()->user->id;
        if($delete) {
            Yii::app()->db->createCommand('DELETE FROM request2anketa WHERE id_request=:id_request AND id_anketa=:id_user ')
            ->execute(array(':id_request'=>$this->id,':id_user'=>$id_user));
        } else {
            Yii::app()->db->createCommand('INSERT IGNORE INTO request2anketa SET id_request=:id_request, id_anketa=:id_user, `time`=:time')
                ->execute(array(':id_request'=>$this->id,':id_user'=>$id_user,':time'=>time()));
        }
    }
}
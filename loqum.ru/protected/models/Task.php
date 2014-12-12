<?php

/**
 * This is the model class for table "task".
 *
 * The followings are the available columns in table 'task':
 * @property string $id
 * @property string $id_user
 * @property string $type
 * @property integer $time_task
 * @property string $data
 * @property integer $status
 */
class Task extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Task the static model class
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
		return 'task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, type, time_task, data', 'required'),
			array('time_task, status', 'numerical', 'integerOnly'=>true),
			array('id_user', 'length', 'max'=>20),
			array('type', 'length', 'max'=>55),
			array('data', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, type, time_task, data, status', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'time_task' => 'Time Task',
			'data' => 'Data',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('time_task',$this->time_task);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function scopes(){
        $alias = $this->getTableAlias(false,false);
        return array(
            'delayed' => array(
                'condition' => "`$alias`.status=1 AND `$alias`.time_task < UNIX_TIMESTAMP()",
            ),
        );
    }

    /**
     * Запуск задачи на исполнение.. взаимодействует с моделью пользователей..
     * пока лежит здесь
     */
    public function goTask(){
        if ($this->type == 'untop') {
            if($anketa = Anketa::model()->findByPk($this->id_user)) {
                $anketa->setTop(0);
                $anketa->savePriority();
                $this->status = 0;
                $this->saveAttributes(array('status'));
            }
        } else if ($this->type == 'unpremium') {
            if($anketa = Anketa::model()->findByPk($this->id_user)) {
                $anketa->setPremium(0);
                $anketa->savePriority();
                $this->status = 0;
                $this->saveAttributes(array('status'));
            }
        }
    }

    public static function untopNow($id_user=null) {
        Yii::app()->db->createCommand("UPDATE task
        SET time_task = UNIX_TIMESTAMP(), status = 0
        WHERE id_user=:id_user AND `type` = 'untop' ")
            ->execute(array(':id_user'=>$id_user));
    }
}
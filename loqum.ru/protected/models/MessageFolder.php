<?php

/**
 * This is the model class for table "message_folder".
 *
 * The followings are the available columns in table 'message_folder':
 * @property string $id
 * @property string $name
 * @property integer $id_user
 * @property integer $status
 * @property integer $action
 * @property integer $sort_order
 */
class MessageFolder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MessageFolder the static model class
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
		return 'message_folder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sort_order', 'required'),
			array('id_user, status, action, sort_order', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>80),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, id_user, status, action, sort_order', 'safe', 'on'=>'search'),
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

    public function scopes() {
        return array(
            'sorted'=>array(
                'order'=>'sort_order',
            ),
            'visible'=>array(
                'condition'=>'id_user IS NULL',
            ),
        );
    }


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'id_user' => 'Id User',
			'status' => 'Status',
			'action' => 'Action',
			'sort_order' => 'Sort Order',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('status',$this->status);
		$criteria->compare('action',$this->action);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Количество новых сообщений в папке
     * @return mixed
     */
    public function getUnreadCount($id_user=0){
        $id_user or $id_user = Yii::app()->user->id;
        return $this->dbConnection->createCommand('
        SELECT COUNT(*) from message m
        LEFT JOIN message2folder m2f ON m.id_from = m2f.id_to AND m.id_to = m2f.id_from
        WHERE m.id_to=:id_user  AND viewed=0 AND :id_folder = IFNULL(m2f.id_folder,0)')
            ->queryScalar(array(':id_user'=>$id_user,':id_folder'=>$this->id));
    }

    public function getMessagelistCount($id_user=0) {
        $id_user or $id_user = Yii::app()->user->id;
        $q = "SELECT COUNT(*) FROM message2folder m2f WHERE m2f.id_from=:id_user AND id_folder=:id_folder ";
        return $this->dbConnection->createCommand($q)
            ->queryScalar(array(':id_user'=>$id_user,':id_folder'=>$this->id));
    }

    public static function addDefaultFolder($id_from,$id_to) {
        Yii::app()->db->createCommand('REPLACE INTO message2folder (id_from,id_to,id_folder)
        VALUES (?,?,?),(?,?,?)')->execute(array($id_from,$id_to,0,$id_to,$id_from,0));
    }
}
/**
-- установка "нулевой" папки по умолчанию для старых сообщений
INSERT IGNORE INTO `message2folder`
SELECT * FROM
((SELECT DISTINCT id_from, id_to, 0 FROM message)
UNION (SELECT DISTINCT id_to,id_from,0 FROM message)) a
 */
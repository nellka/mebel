<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property string $id
 * @property string $id_from
 * @property string $id_to
 * @property string $datestamp
 * @property integer $viewed
 * @property integer $deleted
 * @property string $message
 */
class Message extends CActiveRecord
{
    public $cnt;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Message the static model class
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
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'required', 'on'=>'send'),
            array('deleted,viewed','safe','on'=>'update'),
//			array('viewed, deleted', 'numerical', 'integerOnly'=>true),
//			array('id_from, id_to', 'length', 'max'=>20),
//			array('datestamp', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_from, id_to, datestamp, viewed, deleted, message', 'safe', 'on'=>'search'),
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
            'from'=>array(self::BELONGS_TO,'Anketa','id_from'),
            'to'=>array(self::BELONGS_TO,'Anketa','id_to'),
		);
	}
    public function beforeValidate(){
        if (parent::beforeValidate()) {
            if (empty($this->datestamp))
                $this->datestamp = time();
        }
        return true;
    }
    public function afterFind(){
        $this->message = htmlspecialchars($this->message);
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '№',
			'id_from' => 'От',
			'id_to' => 'Кому',
			'datestamp' => 'Дата',
			'viewed' => 'Просмотрено',
			'deleted' => 'Удалено',
			'message' => 'Текст сообщения',
		);
	}

    public function defaultScope(){
        return array('order'=>'datestamp desc');
    }

    public function scopes() {
        return array(
            'active'=>array(
              'condition'=>'deleted=0',
            ),
            'new'=>array(
              'condition'=>'viewed=0',
            ),
        );
    }

    public function fromto($id1,$id2=0){
        if (empty($id2))
            $id2 = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id_from',array($id1,$id2));
        $criteria->addInCondition('id_to',array($id1,$id2));
        $criteria->addCondition('id_to<>id_from');
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    public function lastMessages($id=0,$folder=null){
        if (empty ($id))
            $id = Yii::app()->user->id;
//        if ($folder) {
//            $byfolder = ' AND m2f.id_folder = '.(int) $folder;
//        } else {
//            $byfolder = ' AND m2f.id_folder IS NULL ';
//        }
        #$byfolder = ' AND IFNULL(m2f.id_folder,0) = '.(int) $folder ;
        $byfolder = ' AND m2f.id_folder = '.(int) $folder ;

        $result = array();
        $command = Yii::app()->db->createCommand("SELECT m.id_from, m.id_to, max( datestamp ) AS datestamp
                    FROM `message` m
                    LEFT JOIN message2folder m2f on m2f.id_from = :id AND (m2f.id_to = m.id_from OR m2f.id_to=m.id_to)
                    WHERE (m.id_from = :id OR m.id_to = :id) {$byfolder}
                    GROUP BY m.id_from, m.id_to
                    ORDER BY 3 DESC,`datestamp` desc");
        $command->params=array(':id'=>$id,':id1'=>$id);
        foreach ($command->query() as $row){
            $opponent = $id == $row['id_from'] ? 'id_to':'id_from'; // где искать напарника
            if (isset ($result[$row[$opponent]]))
                continue;
            $result[$row[$opponent]] = $row;
        }
        return $result;
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
		$criteria->compare('id_from',$this->id_from,true);
		$criteria->compare('id_to',$this->id_to,true);
		$criteria->compare('datestamp',$this->datestamp,true);
		$criteria->compare('viewed',$this->viewed);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
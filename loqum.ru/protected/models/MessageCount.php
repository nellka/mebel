<?php

/**
 * This is the model class for table "message_count".
 *
 * The followings are the available columns in table 'message_count':
 * @property string $id1
 * @property string $id2
 * @property integer $cnt
 * @property integer $start_2
 * @property string $last_time
 */
class MessageCount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MessageCount the static model class
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
		return 'message_count';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id1, id2, last_time', 'required'),
			array('cnt, start_2', 'numerical', 'integerOnly'=>true),
			array('id1, id2', 'length', 'max'=>20),
			array('last_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id1, id2, cnt, start_2, last_time', 'safe', 'on'=>'search'),
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
            'from'=>array(self::BELONGS_TO,'Anketa','id1'),
            'to'=>array(self::BELONGS_TO,'Anketa','id2'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id1' => 'Id1',
			'id2' => 'Id2',
			'cnt' => 'Cnt',
			'start_2' => 'Start 2',
			'last_time' => 'Last Time',
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

		$criteria->compare('id1',$this->id1,true);
		$criteria->compare('id2',$this->id2,true);
		$criteria->compare('cnt',$this->cnt);
		$criteria->compare('start_2',$this->start_2);
		$criteria->compare('last_time',$this->last_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getId_from(){
        return $this->id1;
    }
    public function getId_to(){
        return $this->id2;
    }
    public function lastMessages($id=0,$folder=null){
        if (empty ($id))
            $id = Yii::app()->user->id;
        $byfolder = ' AND m2f.id_folder = '.(int) $folder ;

        $result = array();
/*
        $command = Yii::app()->db->createCommand("SELECT m.id1, m.id2, last_time
                    FROM `message_count` m
                    LEFT JOIN message2folder m2f on m2f.id_from = :id AND (m2f.id_to = m.id1 OR m2f.id_to=m.id2)
                    WHERE (m.id1 = :id OR m.id2 = :id) {$byfolder}
                    ORDER BY last_time desc");
*/
        $command = Yii::app()->db->createCommand("
SELECT m.id1, m.id2, cnt, last_time FROM
(
SELECT m.id1, m.id2, cnt, last_time
FROM `message_count` m
WHERE (m.id1 = :id)

UNION

SELECT m.id2, m.id1, cnt, last_time
FROM `message_count` m
WHERE (m.id2 = :id)
) m
WHERE m.id2 IN

(SELECT id_to FROM message2folder m2f
WHERE m2f.id_from = :id {$byfolder})

ORDER BY last_time desc;
        ");
        $command->params=array(':id'=>$id,);
        foreach ($command->query() as $row){
            $opponent = $id == $row['id1'] ? 'id2':'id1'; // где искать напарника
            if (isset ($result[$row[$opponent]]))
                continue;
            $result[$row[$opponent]] = $row;
        }
        return $result;
    }

    public function newMessages($id_to=0, $id_from = array()) {
        if (empty($id_from))
            return array();
        if (empty ($id_to))
            $id_to = Yii::app()->user->id;

        $id_from_list = implode(',',$id_from);
        $result = array();
        $q = "
SELECT id_from, COUNT( * ) as cnt
FROM `message` `t`
WHERE `t`.`id_to` =:id_to
AND viewed =0
AND id_from
IN ( {$id_from_list} )
GROUP BY id_from
        ";

        $command = Yii::app()->db->createCommand($q);
        $command->params=array(':id_to'=>$id_to,);
        foreach ($command->query() as $row) {
            $result[$row['id_from']] = $row['cnt'];
        }
        return $result;
    }
}
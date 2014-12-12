<?php

/**
 * This is the model class for table "anketa_fingerprint".
 *
 * The followings are the available columns in table 'anketa_fingerprint':
 * @property string $id
 * @property integer $id_anketa
 * @property string $user_agent_md5
 * @property string $plugins_md5
 * @property string $fonts_md5
 * @property string $accept
 * @property string $user_agent
 * @property string $video
 * @property string $timezone
 * @property string $supercookies
 * @property string $plugins
 * @property string $fonts
 * @property integer $timestamp
 * @property integer $status
 */
class AnketaFingerprint extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnketaFingerprint the static model class
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
		return 'anketa_fingerprint';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_anketa, accept, user_agent, video, timezone, supercookies, plugins, fonts', 'required'),
			array('id_anketa, timestamp, status', 'numerical', 'integerOnly'=>true),
			array('accept, user_agent', 'length', 'max'=>1300),
			array('video', 'length', 'max'=>60),
			array('timezone', 'length', 'max'=>15),
			array('supercookies', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_anketa, accept, user_agent, video, timezone, supercookies, plugins, fonts, timestamp, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
    public function relations()
    {
        return array(
            'anketa'=>array(self::BELONGS_TO,'Anketa','id_anketa'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_anketa' => 'Id Anketa',
			'accept' => 'Accept',
			'user_agent' => 'User Agent',
			'video' => 'Video',
			'timezone' => 'Timezone',
			'supercookies' => 'Supercookies',
			'plugins' => 'Plugins',
			'fonts' => 'Fonts',
			'timestamp' => 'Timestamp',
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
		$criteria->compare('id_anketa',$this->id_anketa);
		$criteria->compare('accept',$this->accept,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('video',$this->video,true);
		$criteria->compare('timezone',$this->timezone,true);
		$criteria->compare('supercookies',$this->supercookies,true);
		$criteria->compare('plugins',$this->plugins,true);
		$criteria->compare('fonts',$this->fonts,true);
		$criteria->compare('timestamp',$this->timestamp);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
/**
UPDATE `anketa_fingerprint` SET `user_agent_md5` = md5( user_agent ) ,
`plugins_md5` = md5( plugins ) ,
`fonts_md5` = md5( fonts )
 */
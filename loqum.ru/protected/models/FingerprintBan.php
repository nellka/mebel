<?php

/**
 * This is the model class for table "fingerprint_ban".
 *
 * The followings are the available columns in table 'fingerprint_ban':
 * @property integer $id
 * @property integer $id_anketa
 * @property integer $type
 * @property string $value
 * @property integer $status_bad
 * @property integer $status
 * @property string $time_start
 */
class FingerprintBan extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FingerprintBan the static model class
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
		return 'fingerprint_ban';
	}

    const TYPE_IP = 1;
    const TYPE_USER_AGENT = 2;
    const TYPE_FONTS = 3;
    const TYPE_PLUGINS = 4;

    static $types = array(
        'user_agent'=>self::TYPE_USER_AGENT,
        'fonts'=>self::TYPE_FONTS,
        'plugins'=>self::TYPE_PLUGINS,
    );

    static $typesText = array(
        self::TYPE_IP=>'ip',
        self::TYPE_USER_AGENT=>'user_agent',
        self::TYPE_FONTS=>'fonts',
        self::TYPE_PLUGINS=>'plugins',
    );

    public static function getTypes(){
        return array(
            'user_agent'=>self::TYPE_USER_AGENT,
            'fonts'=>self::TYPE_FONTS,
            'plugins'=>self::TYPE_PLUGINS,
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('type','checkUnique'),
			array('type, value, time_start', 'required'),
			array('id_anketa, type, status_bad, status', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>32),
			array('time_start', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_anketa, type, value, status_bad, status, time_start', 'safe', 'on'=>'search'),
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
			'id_anketa' => 'ID Anketa',
			'type' => 'Type',
			'value' => 'Value',
			'status_bad' => 'Status Bad',
			'status' => 'Status',
			'time_start' => 'Time Start',
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
		$criteria->compare('id_anketa',$this->id_anketa);
		$criteria->compare('type',$this->type);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('status_bad',$this->status_bad);
		$criteria->compare('status',$this->status);
		$criteria->compare('time_start',$this->time_start,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function drawForm($options) {
        $html = '';
        $html.= CHtml::beginForm('/cp/anketa/setFingerprintBad','post',array('class'=>'fingerprint-ban-form'));
        foreach ($options as $k=>$v) {
            $html.=CHtml::hiddenField('FingerprintBan['.$k.']',CHtml::encode($v));
        }
        if($fb = self::model()->findByAttributes(array('type'=>$options['type'],'value'=>$options['value'])))
        {
            $html .= '<span class="red">'.( $fb->status_bad == Anketa::BAD_STATUS_BAN ? 'BANNED':'CLONNED').'</span> ';
            $html .= CHtml::submitButton('Сброс',array('name'=>'delete','class'=>'red'));
        }
        $html.= CHtml::submitButton('Клон',array('name'=>'clone'));
        $html.= CHtml::submitButton('Бан',array('name'=>'ban'));
        $html.=CHtml::endForm();
        return $html;
    }

    public function checkUnique() {
        if ($model = self::model()->findByAttributes(array('type' => $this->type, 'value' => $this->value))) {
            $this->id = $model->id;
            $this->isNewRecord = false;
        }
    }
}
<?php

/**
 * This is the model class for table "photo".
 *
 * The followings are the available columns in table 'photo':
 * @property string $id_user
 * @property string $id_photo
 * @property string $path
 */
class Photo extends CActiveRecord
{
    const PATH_INTIM = '/images/intim.jpg';
    const PATH_INTIM_TMB = '/images/intim_tmb.jpg';
	/**
	 * Returns the static model of the specified AR class.
	 * @return Photo the static model class
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
		return 'photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('id_photo, path', 'required'),
//			array('id_user', 'length', 'max'=>20),
//			array('id_photo', 'length', 'max'=>10),
//			array('path', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_user, id_photo, path', 'safe', 'on'=>'search'),
            array('description','safe','on'=>'upload,edit'),
            array('intim','safe','on'=>'upload,edit'), //'message'=>'Размер файла не должен превышать 6Мб'
            array('file', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1024* 1024 *  8, 'allowEmpty'=>false,'on'=>'upload'),
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
			'id_user' => 'Id User',
			'id_photo' => 'Id Photo',
			'path' => 'Адрес',
			'description' => 'Описание',
			'intim' => 'Интим',
			'file' => 'Файл',
		);
	}

    public function getFullPath($type=''){
        $var = 'path'.$type;
        return $_SERVER['DOCUMENT_ROOT'].$this->$var;
    }


        public $file;
        public $pathLarge;
        public static $sizes = array(
            'full'=>array(1000,1000), // 9000/ не для юзеров без wm
            'large'=>array(800,600), //
            'small'=>array(200,200),
        );

    // temp function while 7k not empty
    public function afterFind()
    {
        $this->pathLarge = str_replace('/7000/', '/6000/', $this->path);
        if ($this->checkIntim()) {
            $this->pathLarge = self::PATH_INTIM;
        }
    }

    public function getPathSmall(){
        if ($this->checkIntim()) {
            return self::PATH_INTIM_TMB;
        }
        return  str_replace('/6000/','/3000/',$this->pathLarge);
    }
    public function checkIntim() {
        if (Yii::app()->user->getIsGuest() || Yii::app()->controller->module->id == 'cp')
            return ($this->intim);
        else return false; // для зарегистрированных
    }

        public function getFullImagePath(){
            if ($this->checkIntim())
                return self::PATH_INTIM;
            return '/p/9000/'.$this->id_user.'_'.$this->id_photo.'_l.JPG';
        }
        public function getLargeImagePath(){
            if ($this->checkIntim())
                return self::PATH_INTIM;
            return '/p/6000/'.$this->id_user.'_'.$this->id_photo.'_l.JPG';
        }
        public function getSmallImagePath(){
            if ($this->checkIntim())
                return self::PATH_INTIM;
            return '/p/3000/'.$this->id_user.'_'.$this->id_photo.'_l.JPG';
        }


        public function saveFullImage($filename){
            if (!copy($filename,Yii::getPathOfAlias('webroot').'/'.$this->getFullImagePath()))
                return false;
            //without! resize 1000x1000
            return true;
        }

        public function saveSmallPictures(){
            Yii::import('ext.wideimage.lib.WideImage');
            $sourceFile = Yii::getPathOfAlias('webroot').'/'.$this->getFullImagePath();
            $watermark = Yii::getPathOfAlias('webroot.images').'/watermark.jpg';

            $img = WideImage::load($sourceFile);
         	$overlay = WideImage::load($watermark);

            $img->resizeDown(Photo::$sizes['large'][0], Photo::$sizes['large'][1])
            ->merge($overlay,'right','bottom-1',100)
            ->saveToFile(Yii::getPathOfAlias('webroot').$this->getLargeImagePath());

            $img->resizeDown(Photo::$sizes['large'][0], Photo::$sizes['large'][1])
            //->merge($overlay,'right','bottom-1',100)
            ->resizeDown(Photo::$sizes['small'][0], Photo::$sizes['small'][1])
            //->merge($overlay, 'right', 'bottom-1', 100)
            ->saveToFile(Yii::getPathOfAlias('webroot').$this->getSmallImagePath());
            $this->path = $this->getLargeImagePath();
            if (!$this->isNewRecord)
                $this->saveAttributes(array('path'));
        }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deleteFiles();
            return true;
        } else {
            return false;
        }
    }

    public static function getMaxIdPhoto($id_user=0) {
        if(empty($id_user))
            $id_user = Yii::app()->user->id;
//.$this->tableName()
        $command = Yii::app()->db->createCommand('select max(`id_photo`) from photo where id_user = :id_user');
        //die ($id_user);
        $command->bindParam(":id_user",$id_user,PDO::PARAM_INT);
        $max = $command->queryScalar();
        return $max+1;

    }

    public function deleteFiles(){
        $files = array();
        $files[] = $this->getFullPath();
        $files[] = $this->getFullPath('Small');
        $files[] = $this->getFullPath('Large');
        foreach ($files as $fullPath)
            if(is_file($fullPath)){
                unlink($fullPath);
            }
    }
    public function deleteFile (){
        Yii::log('Photo::deleteFile is colled',CLogger::LEVEL_ERROR);
        $this->deleteFiles();
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

		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('id_photo',$this->id_photo,true);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
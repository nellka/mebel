<?php

class ToolsController extends CpController
{
    public function accessRules()
   	{
   		return array(
            array('allow','actions'=>array('getImages'),'users'=>array('*')),
   			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//   				'actions'=>array('index','test','rephoto','checkPhotoFile','phpInfo','testResize','testWI','getImages),
   				'roles'=>array('admin'),
   			),
   			array('deny',  // deny all users
   				'users'=>array('*'),
   			),
   		);
   	}

    public function actionRestat(){
        StatHelper::restat();
    }

    public function actionGetAllPhotoUrl(){

        $fh = fopen (Yii::app()->runtimePath.'/allphotos.txt','w');
        $command = Yii::app()->db->createCommand('SELECT * FROM `photo`');
        $reader = $command->query();
        while ($row = $reader->read()) {
            //echo $row['path'].'<br/>'; if ($i++==10) Yii::app()->end();
        	fwrite($fh, 'http://omen.ru'.str_replace('m','l',$row['path'])."\n");
        }
        fclose ($fh);
    }

    public function actionIndex(){
        $this->render('index');
    }

    public function actionRephoto(){
       echo Yii::app()->db->createCommand( 'update anketa a, photo p  set a.mainphoto = p.id_photo
        where  a.mainphoto=0 and p.id_user = a.id ')->execute();
        /*
         * //Выборка всех анкет с фото, но без mainphoto
select * from anketa inner join photo on photo.id_user = anketa.id
where anketa.mainphoto=0 or mainphoto is null
         */
    }

    public function actionCheckPhotoFile(){
        $dir = Yii::getPathOfAlias('webroot.p.from');
        $offset = (int) @$_GET['offset'];
        $limit = 5000;
        $models = Anketa::model()->with('photos')->findAll(array('condition'=>'4932794>id','offset'=>$offset,'limit'=>$limit,'order'=>'id desc'));
        if (empty ($models)) die ("$offset $limit" );
        foreach ($models as $model)
            foreach ($model->photos as $photo){
            if (is_file ($dir."/{$model->id}_{$photo->id_photo}_l.JPG"))
               // echo "{$model->id}_{$photo->id_photo}.JPG - OK";
                ;
                else {
                 //   echo  "{$model->id}_{$photo->id_photo}.JPG - !ERR";
                    if ($model->mainphoto==$photo->id_photo){
                        $model->mainphoto = null;
                        $model->saveAttributes(array('mainphoto'));
                    }
               // echo '<br/>';
                }
         //echo '<a target="_blank" href="'. $photo->path.'"><img src="'. $photo->path.'" alt=""/></a>      ';


        }
        $offset = $limit+$offset;
        header('Refresh:5;URL=/cp/tools/checkPhotoFile?offset='.$offset);
    }

    public function actionGetImages(){
        set_time_limit(0) or die('1');
        $photos = Photo::model()->findAll(array('limit'=>3500, 'offset'=>10000));
        foreach ($photos as $photo)
            $this->downloadPhoto($photo->path);
    }

    /**
     * @param $photo string - full name from db $photo = '/p/93/13/931317_1_l.JPG';
     */
    private function downloadPhoto($photo) {
        $root = $_SERVER['DOCUMENT_ROOT'];
        $photo = preg_replace ('#/p/\d+/\d+#','/p/omen',$photo);
        $filename = $root.$photo;
        if (!is_file($filename))
            copy('http://ls.iv-an.ru'.$photo,$filename);
    }

    /**
     * Наложить водяные знаки (watermark.jpg) на все файлы в каталоге /p/from
     * Файлы сохраняются туда же (перезаписываются)
     * Имеет смысл указать $filemtime до первого старта
     */
    public function actionTest()
    {
        //die('watermarking off');
        //echo time(); die();
        $filemtime = 1386747474; // файлы с датой записи после - не перезаписываются
        set_time_limit(0) or die('1');
        Yii::trace("start watermarking",'omen');
        $watermark = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].'/images/watermark.jpg');
        $wm = array('w'=>107,'h'=>25);
        $filenames = array('710580_3_l.JPG', '919091_1_l.JPG','927302_1_l.JPG');
        $path = $_SERVER['DOCUMENT_ROOT'] . '/tmp';
        $filenames = array();
        $path = $_SERVER['DOCUMENT_ROOT'].'/p/from';
        $dh = opendir($path);
        $cnt = 0;

        while ($file = readdir($dh)) {
            if ($file=='.'||$file=='..') continue;
            if (filemtime($path.'/'.$file)>$filemtime) continue; //echo date(" d.m.Y H:i",);
            if (strpos($file,'txt')||strpos($file,'html')) continue;
            $filenames[] = $file;
        }

        foreach ($filenames as $filename1) {
            Yii::trace("$filename1",'omen');
            $filename = $path.'/' . $filename1;
            $imginfo = getimagesize($filename);
            $img = imagecreatefromjpeg($filename);
            $poss = TmpHelper::getLogoPosition($img, $imginfo);
            //print_r($poss);
//            if (is_array($poss)) {
//                print_r ($poss);
//                echo " ". CHtml::link($filename1,'/p/from/'.$filename1);
//            }
//            else
//                echo " + $poss ". CHtml::link($filename1,'/p/from/'.$filename1);
//            echo "<br/>";
            if (is_array($poss)) {
                if ($poss['rb'] == $poss['lt'])
                    Yii::trace("$filename1 - rb=lt, lt selected",'omen');
                $poss = $poss['rb'] > $poss['lt'] ? 'rb' : 'lt';
            }

            $coord = TmpHelper::$wmpositions[$poss];
            list ($w,$h)=$imginfo;
            if ($coord['x'] < 0) $coord['x'] = $w + $coord['x'];
            if ($coord['y'] < 0) $coord['y'] = $h + $coord['y'];

            imagecopy($img, $watermark, $coord['x'], $coord['y'], 0, 0, $wm['w'], $wm['h']);
            imagejpeg ($img,  $filename);
//            die($filename);
        }
    }

    public function actionPhpInfo(){
        phpinfo();
    }

    public function actionTestResize(){
        $file = Yii::getPathOfAlias('webroot.p.6000')."/4932925_1_l.JPG";
        Yii::import('ext.phpthumb.EasyPhpThumb');
        $thumbs = new EasyPhpThumb();
        echo 'ok';
        $thumbs->init();
        $thumbs->setThumbsDirectory('/p/3000');
        $thumbs
        ->load($file)
        ->resize(Photo::$sizes['full'][0], Photo::$sizes['full'][1])
        //->crop($area['x'],$area['y'],$area['width'],$area['height'])
        ->save('4932925_1_l.JPG', "JPG")
        ->resize(Photo::$sizes['small'][0], Photo::$sizes['small'][1])
            ->save('4932925_1_l_.JPG', "JPG");
        echo ' ok';
    }

    public function actionReThumb($id=0){
        if (isset ($_GET['id']))
            $id = $_GET['id'];
        if (empty ($id)) {
            echo 'empty ID';
            Yii::app()->end();
        }
        $model = Anketa::model()->findByPk($id);

        foreach ($model->photos as $photo){
            $photo->saveSmallPictures();
        }
    }

    public function actionMassReThumb(){
        echo "<pre>";
        $models=Anketa::model()->findAll('id>503893');
        foreach ($models as $model){
            echo "{$model->id}\n";
            foreach ($model->photos as $photo){
                $photo->saveSmallPictures();
                echo "-{$photo->id_photo}\n";
            }
        }
    }

    public function actionTestWimage(){
        Yii::import('ext.wideimage.lib.WideImage');
        $sourceFile = Yii::getPathOfAlias('webroot.p.6000')."/4932925_1_l.JPG";
        $watermark = Yii::getPathOfAlias('webroot.images').'/watermark.jpg';
        $dstFile = Yii::getPathOfAlias('webroot.p.3000').'/4932925_1_l_5.JPG';

        $img = WideImage::load($sourceFile);
     	$overlay = WideImage::load($watermark);

       // $res = $img->resizeDown(Photo::$sizes['small'][0], Photo::$sizes['small'][1]);
        //$res2 = $res->merge($overlay,'right','bottom-1',100);
        $img->resizeDown(Photo::$sizes['large'][0], Photo::$sizes['large'][1])
            ->saveToFile($dstFile);
        $img->resizeDown(Photo::$sizes['small'][0], Photo::$sizes['small'][1])
            ->merge($overlay,'right','bottom-1',100)
            ->saveToFile(Yii::getPathOfAlias('webroot.p.3000').'/4932925_1_l_6.JPG');


//        $res = $res->merge($overlay, 0, 0, 0);
//        $res->merge($overlay, 'center', 'bottom – 10', 50);
        //$res2->saveToFile($dstFile);
        echo '0k';
    }
	
	
    public function actionStat(){
        $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM {{stat_sessions}}')->queryScalar();
        $sql='SELECT * FROM {{stat_sessions}}';

        $dataProvider=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'sort'=>array(
                'attributes'=>array(
                     //'datestamp'=>'desc'//, 'username', 'email',
                   'timestamp',
                ),
                'defaultOrder'=>array(
                    'timestamp'=>'desc'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>50,
            ),
        ));
        $this->render('stat',compact('dataProvider'));
    }
    public function actionStatInfo($id){
        $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM {{stat_hits}} where id_sess = :id_sess')
        ->queryScalar(array(':id_sess'=>$id));
        $sql='SELECT * FROM {{stat_hits}} where id_sess = :id_sess';

        $dataProvider=new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'params'=>array(':id_sess'=>$id),
            'sort'=>array(
                'attributes'=>array(
                     //'datestamp'=>'desc'//, 'username', 'email',
                   'timestamp',
                ),
                'defaultOrder'=>array(
                    'timestamp'//=>'asc'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>50,
            ),
        ));
        $this->render('stat_info',compact('dataProvider'));
    }

    public function actionFakeVisit(){
        Anketa::model()->reFakeVisit();
    }

    public function actionCities(){
        $cities = Anketa::getCities();
        $cities = $cities['Города России:'];
        //$cities = $cities['Две столицы:'];
        $cmd = Yii::app()->db->createCommand('SELECT count(id) FROM anketa where location LIKE :city');
//        $delCmd = Yii::app()->db->createCommand('DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE :city LIMIT :limit');
//        $cmdcity = Yii::app()->db->createCommand('INSERT IGNORE INTO anketa_in_city SELECT id FROM anketa where location LIKE :city');
        $result = array();
        $sum = 0;
        foreach ($cities as $city) {
            $result[$city] = $cmd->queryScalar(array(':city'=>"%$city%"));
//            $cmdcity->execute(array(':city'=>"%$city%"));
//            if ($result[$city] > 70) {
//                $delCmd->bindValue(':limit', intval($result[$city] * 0.7), PDO::PARAM_INT);
//                $delCmd->bindValue(':city',"%$city%" , PDO::PARAM_STR);
//                $delCmd->execute();
//                echo $city;
//            }
            $sum += $result[$city];
        }
        array_multisort($result);

//        foreach ($result as $k=>$v) {
//            if ($v<15) $q[] = "UPDATE anketa SET location = '$k' WHERE location LIKE '%Саратов%' LIMIT 13;";
//        }
//        echo implode('<br>',$q); die();

        print_r ($result);
        echo '<br>Total: '.$sum;
        exit();

    }

}
/**
 *
 Восстановление анкеты залогиненых пользователей
INSERT IGNORE INTO anketa( id, name, last_visit, isdeleted )
SELECT id_from, concat( 'Anketa ', id ) , datestamp, 0
FROM message
WHERE `datestamp` >1363508140;
 *
-- Синхронизация последнего посещения
UPDATE anketa a, anketa_update au
SET a.last_visit = au.last_visit WHERE a.id = au.id;
TRUNCATE anketa_update;
 *
UPDATE anketa SET `last_visit` = UNIX_TIMESTAMP( ) - RAND( ) *3600 *24 *30;
 */
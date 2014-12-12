<?php
class CityController extends Controller
{
    public $layout = '//layouts/column1';

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $cities = City::model()->findAll('status=1');
        $this->render('index', compact('cities'));
    }

    public function actionViewList($id = false, $alias = false)
    {
        if ($_SERVER['REMOTE_ADDR']=='195.208.50.30')
            $this->actionView2($alias);
        if ($id) $city = City::model()->findByAttributes(array('alias' => $id));
        if ($alias) $city = City::model()->findByAttributes(array('alias' => $alias));
        if (!$city)
            throw new CHttpException(404, 'Not found');

        $model = new AnketaSearch;
        $model->loadDefaults();
        if (isset ($_GET['AnketaSearch'])) {
            $model->attributes = $_GET['AnketaSearch'];
            $model->saveAsDefaults();
        }
        $model->location = $city->name;
        $this->render('view', array('city' => $city, 'model'=>$model,));
    }

    public function actionView($alias=false) {
        if ($alias) $city = City::model()->findByAttributes(array('alias' => $alias));
        if (!$city)
            throw new CHttpException(404, 'Not found');

        $SearchForm = new AnketaSearch;
        $SearchForm->loadDefaults();
        $SearchForm->location = $city->name;
        $SearchForm->saveAsDefaults();
        // echo $SearchForm->location; d
        $LoginForm = new LoginForm;

        $condition = 'gender=0 AND age>18 AND  NOT status_bad & 1'
                    ." AND (location LIKE :city)"; //last_visit>=UNIX_TIMESTAMP()-259200 AND

        $womanProvider = new CActiveDataProvider('Anketa',array(
            'criteria'=>array('limit'=>24, 'order'=>'mainphoto DESC,rand()','scopes'=>array('published'),//,'withphoto'
                'condition'=>$condition,
                'params'=>array(':city'=>'%'.$city->name.'%')
            ),
            'pagination'=>false,
        ));

        $manProvider = new CActiveDataProvider('Anketa',array(
            'criteria'=>array('limit'=>16,'order'=>'mainphoto DESC,rand()','scopes'=>array('published'),//,'withphoto'
                'condition'=>'gender=1 AND NOT status_bad & 1'
                    ." AND (location LIKE :city)", // AND last_visit>UNIX_TIMESTAMP()-259200
                'params'=>array(':city'=>'%'.$city->name.'%')
            ),
            'pagination'=>false,
        ));

        $this->render('view',compact('womanProvider','manProvider','SearchForm','LoginForm','city'));
        exit();
    }

}
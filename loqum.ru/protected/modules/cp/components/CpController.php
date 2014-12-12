<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CpController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
    public $layout='//layouts/column2';
    public $metaKeywords;
    public $metaDescription;
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function filters()
   	{
   		return array(
   			'accessControl', // perform access control for CRUD operations
   			'basicAuth',
   		);
   	}
    public function accessRules()
   	{
   		return array(
   			array('deny',  // deny all users
   				'users'=>array('*'),
   			),
   		);
   	}
    public function filterBasicAuth($filterChain){
        if (!isset($_SERVER['PHP_AUTH_USER']) ||
            !('petr' == $_SERVER['PHP_AUTH_USER'] && 'pass'==$_SERVER['PHP_AUTH_PW']) ) {
            header('WWW-Authenticate: Basic realm="Test Authentication System"');
            header('HTTP/1.0 401 Unauthorized');
            echo "You must enter a valid login ID and password to access this resource\n";
            exit;
        }
        $filterChain->run();
    }
}
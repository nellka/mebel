<?php
return CMap::mergeArray(
    // наследуемся от main.php
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'user'=>array(
                'class'=>'DatingUser',
                'allowAutoLogin'=>true,
//			'autoRenewCookie'=>true,
                'identityCookie' => array('domain' => '.loqum.ru','path'=>'/'),
            ),
            'session' => array(
                'autoStart'=>true,
                'cookieParams' => array(
                    'path' => '/',
                    'domain' => '.loqum.ru', // to keep session id visible into subdomains
                    'httpOnly' => true, // change if needed
                ),
            ),
            // переопределяем компонент db
            'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=loqum',
                'emulatePrepare' => true,
                'username' => 'loqum',
                'password' => 'loqum2loqum',
                'charset' => 'utf8',
                'enableParamLogging'=>true,
                'tablePrefix'=>'',
//            'schemaCachingDuration'=>'3600',
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                'rules'=>array(
                    'p'=>'anketa/getPhoto',
                    'feedback'=>'site/contact',
                    'oferta'=>array('site/page','defaultParams'=>array('view'=>'oferta')),
                    'contact'=>array('site/page','defaultParams'=>array('view'=>'contact')),
                    'about'=>array('site/page','defaultParams'=>array('view'=>'about')),
                    'rules'=>array('site/page','defaultParams'=>array('view'=>'rules')),
                    'deleted'=>array('site/page','defaultParams'=>array('view'=>'deleted')),
                    'howto'=>array('site/page','defaultParams'=>array('view'=>'howto')),
                    'cp/<_c>/<_a>/<id:\d+>'=>'cp/<_c>/<_a>',
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),
//            'db'=>array(
//                // настройки для конфигурации разработчика
//			'connectionString' => 'mysql:host=u259956.mysql.masterhost.ru;dbname=u259956_5',
//			'emulatePrepare' => true,
//			'username' => 'u259956_4',
//			'password' => 'carmophi9i',
//            ),
        ),
    )
);
<?php
return CMap::mergeArray(
// наследуемся от main.php
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'user'=>array(
                'class'=>'DatingUser',
                'allowAutoLogin'=>true,
                'identityCookie' => array('domain' => '.muksil.ru','path'=>'/'),
            ),
            'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=loqum',
                'emulatePrepare' => true,
                'username' => 'loqum',
                'password' => 'loqum2loqum',
//                'enableParamLogging' => true,
//                'enableProfiling'=>true,
                'schemaCachingDuration'=>3600 ,// false, //'3600',
            ),
            'session' => array(
                'cookieParams' => array(
                    'path' => '/',
                    'domain' => '.muksil.ru', // to keep session id visible into subdomains
                    'httpOnly' => true, // change if needed
                ),
            ),
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',//,trace
                        'logFile'=>'application_s.log',
                    ),
                    array(
                        'class' => 'CEmailLogRoute',
                        'levels' => 'info',
                        'emails' => 'ilevchunets@gmail.com',
                        'categories'=>'payment',
                    ),
                ),
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                'rules'=>array(
                    'person/<id:\d+>' => 'anketa/view',
                    'personid/<id:\d+>' => 'anketa/fakeView',
                    'feedback'=>'site/contact',
                    'oferta1'=>array('site/page','defaultParams'=>array('view'=>'oferta')),
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
        ),
        'params'=>array(
            'noreplyEmail'=>'noreply@muksil.ru',
            'ik_shop_id'=>'32791A0A-7E03-5375-DA48-03C06078FBA9',
            'ik_secret_key'=>'ThN92pFdlDsLfCZe',
//            'ik_shop_id'=>'2F9AD0D5-293A-7F73-C0EA-3206561E9543',
//            'ik_secret_key'=>'ABCmAAJd9zFGT53w',
            'body_class' => false,
        ),
        'theme'=>'muksil',
        'name'=>'muksil.ru',
    )
);
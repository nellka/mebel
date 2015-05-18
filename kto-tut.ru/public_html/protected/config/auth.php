<?php
return array(
// operations
    'adminpage'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminorder'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'admintools'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminother'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminprovider'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminproducer'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'admincategory'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminproduct'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminmessage'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminip'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminrequest'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'adminmoney'=>array(
        'type'=>CAuthItem::TYPE_OPERATION,
    ),
    'shopproduct2cat'=>array(
            'type'=>CAuthItem::TYPE_OPERATION,
    ),
// roles
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'manager' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Manager',
        'children' => array(
            'guest', // позволим менеджеру всё, что позволено гостю
            'adminmessage',
            'adminip',
//            'adminpage',
//            'adminorder',
//            'admincategory',
//            'adminproduct',
//            'admintools',
//            'adminother',
//            'adminprovider',
//            'adminproducer',
//            'shopproduct2cat',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'manager', // позволим админу всё, что позволено менеджеру
            'adminmoney',
            'adminrequest',
        ),
        'bizRule' => null,
        'data' => null
    ),
);
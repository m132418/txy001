<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Shanghai', //time zone affect the formatter datetime format
    'language' => 'zh-CN',
    'name' => '会员管理系统',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'Y-m-d',
            'datetimeFormat' => 'Y-m-d H:i:s',
            'timeFormat' => 'H:i:s',
            'locale' => 'zh-CN', //your language locale
            'defaultTimeZone' => 'Asia/Shanghai', // time zone
        ],
//         'session' => [
//             'class' => 'yii\redis\Session',
//             'redis' => [
//                 'hostname' => 'localhost',
//                 'port' => 6379,
//                 'database' => 10,
//             ],
//         ],
        
    ],
//     'i18n' => [
//         'translations' => [
//             'app' => [
//                 'class' => 'yii\i18n\PhpMessageSource',
//                 'basePath' => '@app/messages',
//             ],
//             'kvgrid' => [
//                 'class' => 'yii\i18n\PhpMessageSource',
//                 'basePath' => '@app/messages',
//             ],
//             ]
//     ]

];
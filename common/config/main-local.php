<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=advanced',            
            'username' => 'root',
            'password' => 'root',
//             'dsn' => 'mysql:host=localhost;dbname=ytx001',            
//             'username' => 'ytx001',
//             'password' => 'NYeBthYmr5',
            'charset' => 'utf8',
        ],
        'urlManager' => [
        'showScriptName' => false,        
        'enablePrettyUrl' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];

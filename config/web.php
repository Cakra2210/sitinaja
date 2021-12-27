<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules'=>[
      'gridview' =>  [
        'class' => '\kartik\grid\Module',
      ],
      'pdfjs' => [
       'class' => '\yii2assets\pdfjs\Module',
   ],
    ],
    'aliases' => [
    '@mdm/autonumber' => 'path/to/your/yii2-autonumber'
    ],
    'components' => [
        'myHelper'=>[
            'class' => 'app\components\myHelper',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '2017',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Pegawai',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'qr' => [
        'class' => '\Da\QrCode\Component\QrCodeComponent',
               ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment

    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    
}

return $config;

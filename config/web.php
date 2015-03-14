<?php

$params = require(__DIR__ . '/params.php');
Yii::setAlias('@common', dirname(__DIR__));
$config = [
    'id' => 'basic',
    'timeZone'=>'Europe/Moscow',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'sourceLanguage' => 'ru',

    //'defaultRoute' => 'game/index',

    //when update site
    //'catchAll' => ['site/offline'],

    'modules' => [
        'vote' => [
            'class' => 'chiliec\vote\Module',
            'allow_guests' => true, // if true will check IP, otherwise - UserID
            'allow_change_vote' => true, // if true vote can be changed
            'matchingModels' => [ // matching model names with whatever unique integer ID
                'Game' => 1, // may be just integer value
//                'audio' => ['id'=>1], // or array with 'id' key
//                'video' => ['id'=>2, 'allow_guests'=>false], // own value 'allow_guests'
//                'photo' => ['id'=>3, 'allow_guests'=>false, 'allow_change_vote'=>false],
            ],
        ],
    ],

    'components' => [

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [

                ''=>'game/index',
                'answer'=>'site/answer',
                'contact'=>'site/contact',
                'search'=>'site/search',

                '<controller:\w+>/page/<page:\d+>' => '<controller>/index',

                'game/myfavorite' => 'game/myfavorite',
                'game/<alias>' => 'game/view',
                'categorys' => 'category/index',
                'category/<alias>' => 'category/view',
                'site/captcha'=>'site/captcha',

//
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                //'<controller:\w+>/<alias:\w+>' => '<controller>/view',
                //'<controller:\w+>/<id:\w+>' => '<controller>/view',

            ],
        ],


        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'af_8urUOLzmEQX8xHigj0wk6YAJnWHym',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;

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
    //when update site
    //'catchAll' => ['site/offline'],
    'modules' => [
        'vote' => [
            'class' => 'chiliec\vote\Module',
            'allow_guests' => true, // if true will check IP, otherwise - UserID
            'allow_change_vote' => true, // if true vote can be changed
            'matchingModels' => [ // matching model names with whatever unique integer ID
                'Game' => 1, // may be just integer value
            ],
        ],

        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'gameadmin',
        ],
    ],

    'components' => [

        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' :         'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [

                ''=>'game/index',
                'answer'=>'site/answer',
                'contact'=>'site/contact',
                'search'=>'site/search/',

                'login'=>'site/login',

                '<controller:\w+>/page/<page:\d+>' => '<controller>/index',

                'game/myfavorite' => 'game/myfavorite',
                'game/<alias>' => 'game/view',
                'categorys' => 'category/index',
                'category/<alias>' => 'category/view',
                'site/captcha'=>'site/captcha',

                //site map
                ['pattern'=>'sitemap','route'=>'site/sitemap','suffix'=>'.xml'],


                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/'=>'<module>/<controller>/index',
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
    'name' => $params['name'],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;

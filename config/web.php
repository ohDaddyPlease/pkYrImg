<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    /**
     * Изменен роут по дефолту
     */
    'defaultRoute' => 'dashboard/index',
    'id' => 'basic',

    /**
     * Изменено название приложения
     */
    'name' => 'pk yr img  ;)',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\api\modules\v1\Module',
        ],
    ],
    'components' => [

        /**
         * Добавлен собственный компонент picker в сервис локатор
         */
        'picker' => [
            'class' => 'app\components\Picker'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'o2_vkEFFnEy69Aahx0KVSm78m124Gm7q',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [

            /**
             * Изменен путь до модели пользователя
             */
            'identityClass'   => 'app\models\db\User',
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
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'          => $db,
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'rules'               => [
                '/'                         => 'dashboard/index',
                'profile'                   => 'profile/index',
                'profile/favorites'         => 'profile/favorites',
                'profile/dislikes'          => 'profile/dislikes',
                'profile/likes'             => 'profile/likes',
                'logout'                    => 'authorization/logout',
                'registration'              => 'authorization/registration',
                'login'                     => 'authorization/login',
                'dashboard/add-to-favorite' => 'dashboard/add-to-favorite',
                'dashboard/like-dislike'    => 'dashboard/like-dislike',
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/user']],
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

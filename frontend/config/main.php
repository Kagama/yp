<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'gii' => 'yii\gii\Module',
        'organization' => [
            'class' => 'frontend\modules\organization\OrganizationModule',
        ],
        'locality' => [
            'class' => 'common\modules\locality\LocalityModule',
        ],

        'user' => [
            'class' => 'frontend\modules\user\UserModule',
        ],

        'comment' => [
            'class' => 'frontend\modules\comment\CommentModule',
        ]
    ],
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclients\Facebook',
                    'clientId' => '651530411629071',
                    'clientSecret' => 'c54ca75c92e9a1f78ab7f6367aa03c67',
                ],
            ],
        ],

        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'frontend_session'
        ],
        'user' => [
            'identityClass' => 'common\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'user/login'
        ],
//        'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=localhost;dbname=yellow_pages',
//            'username' => 'root',
//            'password' => '',
//            'tablePrefix' => 'ka_',
//            'charset' => 'utf8',
//        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules', // <-- !!!
                ],
            ],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules'=>[

                'category/<alt_name_id:\w+>' => 'organization/category/open',
                'show-organization-info' => 'organization/default/show',
                'add-bookmark' => 'organization/default/add-bookmark',
                'remove-from-bookmarks' => 'organization/default/remove-from-bookmarks',

                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                '<module:\w+>/<action:\w+>'=>'<module>/default/<action>',
                'search-result' => 'organization/default/search-result',
//                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',


                'login' => 'user/default/login',
                'register' => 'user/default/register',
                'logout' => 'user/default/logout',
                'send-message' => 'user/default/send-message',

                'login/<service:google|facebook>' => 'organization/login',
//                'gii'=>'gii/default/index',
//                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
            ]
        ],
        'request' => [
            'baseUrl' => '', // данный адрес соответсвует с тем адресом который мы задали в .htaccess из общего рута нашего приложения.
            'cookieValidationKey' => 'MsTEwas232',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];

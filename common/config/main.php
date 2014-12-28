<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'language' => 'ru-RU',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'i18n' => array(
            'translations' => array(
                'eauth' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@eauth/messages',
                ),
            ),
        ),

        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],

        'eauth' => array(
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => array(
//                // uncomment this to use streams in safe_mode
//                //'useStreamsFallback' => true,
            ),
            'services' => array(
                'vkontakte' => array(
                    'class' => 'nodge\eauth\services\VKontakteOAuth2Service',
                    'clientId' => '4668162',
                    'clientSecret' => '4MW0EniaSGafO9e1pWc9',
                ),
                'facebook' => array(
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '651530411629071',
                    'clientSecret' => 'c54ca75c92e9a1f78ab7f6367aa03c67',
                ),

                'twitter' => array(
                    // register your app here: https://dev.twitter.com/apps/new
                    'class' => 'nodge\eauth\services\TwitterOAuth1Service',
                    'key' => '6L4wBoGhYEQvVTCKEMQoGuZJm',
                    'secret' => 'kX7Brk3uJQr5VJSKlffRqzTjcNJiKflSb8yPBGOxWRyg5D1NGe',
                ),

                'odnoklassniki' => array(
                    // register your app here: http://dev.odnoklassniki.ru/wiki/pages/viewpage.action?pageId=13992188
                    // ... or here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
                    'class' => 'nodge\eauth\services\OdnoklassnikiOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                    'clientPublic' => '...',
                    'title' => 'Одноклассники',
                ),
            ),
        )
    ],
];

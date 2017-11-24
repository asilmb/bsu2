<?php

return [
    'bootstrap' => [],
    'components' => [
        'user' => [
            //'identityClass' => 'yii2lab\user\models\identity\Disc',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['user/auth/login'],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => env('cookieValidationKey.frontend'),
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'errorHandler' => [
            'errorAction' => 'error/error/error',
        ],
        'assetManager' => array(
            'bundles' => array(
                'yii\web\JqueryAsset' => array(
                    'sourcePath' => null,
                    'js' => array(
                        null,
                    ),
                ),
            )
        ),
        'urlManager' => [
            'rules' => [
                '' => 'balhash/main',

                // ----------------- Main module -----------------
                'news' => 'balhash/main/news',
                'contacts' => 'balhash/main/contacts',
                'mailer' => 'balhash/main/mailer',
                'news/<id>' => 'balhash/main/news'
            ],
        ],
    ],
];

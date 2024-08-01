<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => getenv('1058095926754-5qq1fp156iantrhkqafl5l9qnhcki1i0.apps.googleusercontent.com'),
                    'clientSecret' => getenv('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'),
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'your_facebook_client_id',
                    'clientSecret' => 'your_facebook_client_secret',
                ],
                // Add other OAuth2 providers here
        ],
    ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'dd/M/Y',
            'datetimeFormat' => 'dd/M/Y H:mm',
            'timeFormat' => 'H:mm',
            'locale' => 'ro', //your language locale
            'defaultTimeZone' => 'Europe/Bucharest', // time zone
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
        ],
    ],
];

<?php

return [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@yiisolutions/user' => __DIR__ . '/../../../src/',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gaSwg0HXBtBMm5dQ9nPEVVjKLtnzSezG',
        ],
        'user' => [
            'identityClass' => 'yiisolutions\user\models\User',
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'yiisolutions\user\Module',
        ],
    ],
];

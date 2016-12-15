<?php

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@yiisolutions/user' => __DIR__ . '/../../../src/',
    ],
    'enableCoreCommands' => false,
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules' => [
        'user' => [
            'class' => 'yiisolutions\user\Module',
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@yiisolutions/user/migrations',
        ],
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'app\fixtures',
            'globalFixtures' => [
                'app\fixtures\UserFixture',
            ],
        ],
    ],
];

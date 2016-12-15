<?php

use yii\db\Expression;
use yiisolutions\user\models\User;

return [
    [
        'id' => 1,
        'username' => 'test',
        'email' => 'test@example.com',
        'password_hash' => User::generatePasswordHash('test'),
        'auth_key' => User::generateAuthKey(),
        'status' => User::STATUS_NEW,
        'created_at' => new Expression('NOW()'),
        'updated_at' => null,
    ],
    [
        'id' => 2,
        'username' => 'user',
        'email' => 'user@example.com',
        'password_hash' => User::generatePasswordHash('test'),
        'auth_key' => User::generateAuthKey(),
        'status' => User::STATUS_ACTIVATED,
        'created_at' => new Expression('NOW()'),
        'updated_at' => new Expression('NOW()'),
    ],
    [
        'id' => 3,
        'username' => 'man',
        'email' => 'man@example.com',
        'password_hash' => User::generatePasswordHash('test'),
        'auth_key' => User::generateAuthKey(),
        'status' => User::STATUS_DELETED,
        'created_at' => new Expression('NOW()'),
        'updated_at' => new Expression('NOW()'),
    ],
];

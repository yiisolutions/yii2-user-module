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
        'created_at' => new Expression('NOW()'),
        'updated_at' => null,
    ],
];

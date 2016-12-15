<?php

namespace app\fixtures;

use yii\test\ActiveFixture;
use yiisolutions\user\models\User;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}

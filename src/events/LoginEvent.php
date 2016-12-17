<?php

namespace yiisolutions\user\events;

use yii\base\Event;
use yiisolutions\user\models\LoginFormInterface;

class LoginEvent extends Event
{
    /**
     * @var LoginFormInterface
     */
    public $model;
}
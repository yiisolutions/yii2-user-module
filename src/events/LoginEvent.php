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

    /**
     * @var mixed alternative return value for sender
     */
    public $return;
}
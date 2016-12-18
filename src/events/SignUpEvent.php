<?php

namespace yiisolutions\user\events;

use yii\base\Event;
use yiisolutions\user\models\SignUpFormInterface;

class SignUpEvent extends Event
{
    /**
     * @var SignUpFormInterface
     */
    public $model;

    /**
     * @var mixed
     */
    public $return;
}
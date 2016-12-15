<?php

namespace yiisolutions\user;

use Yii;
use yii\console\Application as ConsoleApplication;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $controllerNamespace = 'yiisolutions\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'yiisolutions\user\commands';
        }
    }
}

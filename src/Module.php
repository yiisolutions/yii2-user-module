<?php

namespace yiisolutions\user;

use yii\base\Application;
use yii\console\Application as ConsoleApplication;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;

class Module extends BaseModule implements BootstrapInterface
{
    public $controllerNamespace = 'yiisolutions\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();


    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $app->controllerNamespace = 'yiisolutions\user\commands';
        }
    }
}
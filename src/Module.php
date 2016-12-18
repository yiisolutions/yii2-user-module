<?php

namespace yiisolutions\user;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yii\base\Module as BaseModule;

/**
 * Yii2 user module.
 *
 * To add this module, add configuration
 *
 * ```php
 * <?php
 *
 * return [
 *     'modules' => [
 *         'user' => [
 *             'class' => 'yiisolutions\user\Module',
 *
 *             // module options
 *             'rememberMeDuration' => $params['rememberMeDuration'],
 *         ],
 *     ],
 * ];
 *
 * ```
 * @package yiisolutions\user
 */
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

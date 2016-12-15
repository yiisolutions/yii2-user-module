<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;

class LogoutAction extends Action
{
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        return $this->controller->goBack(Yii::$app->defaultRoute);
    }
}

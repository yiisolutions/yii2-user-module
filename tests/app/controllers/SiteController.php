<?php

namespace app\controllers;

use yii\web\Controller;
use yiisolutions\user\actions\LoginAction;
use yiisolutions\user\actions\LogoutAction;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'login' => [
                'class' => LoginAction::className(),
            ],
            'logout' => [
                'class' => LogoutAction::className(),
            ],
        ];
    }
}

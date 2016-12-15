<?php

namespace app\controllers;

use yii\web\Controller;
use yiisolutions\user\actions\LoginAction;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'login' => [
                'class' => LoginAction::className(),
            ],
        ];
    }
}
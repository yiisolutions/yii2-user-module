# yii2-user-module

[![Latest Stable Version](https://poser.pugx.org/yiisolutions/yii2-user-module/v/stable)](https://packagist.org/packages/yiisolutions/yii2-user-module)
[![Total Downloads](https://poser.pugx.org/yiisolutions/yii2-user-module/downloads)](https://packagist.org/packages/yiisolutions/yii2-user-module)
[![Build Status](https://travis-ci.org/yiisolutions/yii2-user-module.svg?branch=master)](https://travis-ci.org/yiisolutions/yii2-user-module)
[![codecov](https://codecov.io/gh/yiisolutions/yii2-user-module/branch/master/graph/badge.svg)](https://codecov.io/gh/yiisolutions/yii2-user-module)
[![License](https://poser.pugx.org/yiisolutions/yii2-user-module/license)](https://packagist.org/packages/yiisolutions/yii2-user-module)

Yii2 user module.

## Installation

Use composer

```bash
composer require "yiisolutions/yii2-user-module: @dev"
```

or add to `composer.json`

```json
{
  "require": {
    "yiisolutions/yii2-user-module": "@dev"
  }
}
```

## Configuration

For enable user module edit your configuration

```php
<?php

return [
    // ...
    'modules' => [
        // ...
        'user' => [
            'class' => 'yiisolutions\user\Module',
        ],
        // ...
    ],
    // ...
];
```

## Console commands

This module provider console commands for manager users

* `user/commands/create` - create new user
* `user/commands/truncate` - clear user table

## Web controller actions

This module provide web controller actions:

* `yiisolutions\user\actions\LoginAction` - for user login
* `yiisolutions\user\actions\LogoutAction` - for logout 
* `yiisolutions\user\actions\SignUpAction` - for sign up new user

For enable these actions use controller `actions()` method

```php
<?php

namespace app\controllers;

use yii\web\Controller;
use yiisolutions\user\actions\LoginAction;
use yiisolutions\user\actions\LogoutAction;
use yiisolutions\user\actions\SignUpAction;
use yiisolutions\user\events\LoginEvent;
use yiisolutions\user\models\LoginFormInterface;

class AccountController extends Controller
{
    public function actions()
    {
        return [
            'login' => [
                'class' => LoginAction::className(), 
                'view' => 'login',  // use @app/views/account/login.php view file
                'on loginSuccess' => [$this, 'onLoginSuccess'], // alternative success callback (default redirect to back)
                'on loginFailed' => [$this, 'onLoginFailed'], // do something when login failed (for example, logging)
            ],
            'logout' => [
                'class' => LogoutAction::className(),
            ],
            'sign-up' => [
                'class' => SignUpAction::className(),
            ],
        ];        
    }    
    
    /**
     * Run when login success.
     * 
     * @return mixed This value will be returned from LoginAction
     */
    public function onLoginSuccess(LoginEvent $event, LoginFormInterface $model)
    {
        // do something ...
        
        return $this->redirect('/profile');
    }
    
    /**
     * Run when login error. 
     */
    public function onLoginFailed(LoginEvent $event, LoginFormInterface $model)
    {
        // do something ...
        
        $user = $model->getUserIdentity();
        if ($user) {
            // send email notification, increment attempt counter etc ...
        }
    }
}

```

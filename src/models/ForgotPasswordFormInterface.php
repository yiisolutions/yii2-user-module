<?php

namespace yiisolutions\user\models;

use yii\web\IdentityInterface;

interface ForgotPasswordFormInterface
{
    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|User|false
     */
    public function getUserIdentity();

    public function forgotPassword();
}

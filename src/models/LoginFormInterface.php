<?php

namespace yiisolutions\user\models;

use yii\web\IdentityInterface;

interface LoginFormInterface
{
    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|false
     */
    public function getUserIdentity();

    /**
     * This method execute login process and return success of operation.
     *
     * @return boolean
     */
    public function login();
}

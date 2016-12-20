<?php

namespace yiisolutions\user\models;

use yii\web\IdentityInterface;

interface PasswordResetFormInterface
{
    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|User|false
     */
    public function getUserIdentity();

    /**
     * This method execute password reset process and return success of operation.
     *
     * @return bool
     */
    public function passwordReset();
}

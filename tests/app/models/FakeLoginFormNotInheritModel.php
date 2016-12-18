<?php

namespace app\models;

use yii\web\IdentityInterface;
use yiisolutions\user\models\LoginFormInterface;

class FakeLoginFormNotInheritModel implements LoginFormInterface
{
    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|false
     */
    public function getUserIdentity()
    {
        // TODO: Implement getUserIdentity() method.
    }

    /**
     * This method execute login process and return success of operation.
     *
     * @param array $options
     * @return bool
     */
    public function login()
    {
        // TODO: Implement login() method.
    }
}
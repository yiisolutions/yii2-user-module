<?php

namespace yiisolutions\user\models;

interface SignUpFormInterface
{
    /**
     * This method start sign of a new user.
     *
     * @return boolean
     */
    public function signUp();

    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|User|false
     */
    public function getUserIdentity();
}

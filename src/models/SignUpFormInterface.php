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
}

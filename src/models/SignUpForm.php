<?php

namespace yiisolutions\user\models;

use Yii;
use yii\base\Model;

class SignUpForm extends Model implements SignUpFormInterface
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat', 'email'], 'required'],
            [['username', 'password', 'password_repeat', 'email'], 'string'],
            [['email'], 'email'],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username', 'filter' => [
                'status' => [User::STATUS_ACTIVATED, User::STATUS_NEW],
            ]],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'filter' => [
                'status' => [User::STATUS_ACTIVATED, User::STATUS_NEW],
            ]],
            [['password'], 'compare'],
        ];
    }

    /**
     * This method start sign of a new user.
     *
     * @return boolean
     */
    public function signUp()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = $this->password;

        if (!$user->save()) {
            return false;
        }

        return true;
    }
}

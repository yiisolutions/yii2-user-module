<?php

namespace yiisolutions\user\models;

use yii\base\Model;
use yii\web\IdentityInterface;

class ForgotPasswordForm extends Model implements ForgotPasswordFormInterface
{
    public $email;

    /**
     * @var User
     */
    private $_user;

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string'],
            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'email', 'filter' => [
                'status' => User::STATUS_ACTIVATED,
            ]],
        ];
    }

    public function forgotPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUserIdentity();
        $user->generatePasswordResetToken();

        return $user->save();
    }

    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|User|false
     */
    public function getUserIdentity()
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentityByUsername($this->email);
        }

        return $this->_user;
    }
}

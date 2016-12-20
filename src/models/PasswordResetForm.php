<?php

namespace yiisolutions\user\models;

use yii\base\Model;
use yii\web\IdentityInterface;

class PasswordResetForm extends Model implements PasswordResetFormInterface
{
    public $password;
    public $password_repeat;

    /**
     * @var User
     */
    private $_user;

    public function __construct($token, array $config = [])
    {
        parent::__construct($config);

        $this->_user = User::findIdentityByPasswordResetToken($token);
        if (!$this->_user) {
            throw new \InvalidArgumentException("Invalid password reset token {$token}.");
        }
    }

    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string'],
            [['password'], 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|User|false
     */
    public function getUserIdentity()
    {
        return $this->_user;
    }

    /**
     * This method execute password reset process and return success of operation.
     *
     * @return bool
     */
    public function passwordReset()
    {
        $user = $this->getUserIdentity();
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false, ['password_hash', 'password_reset_token']);
    }
}

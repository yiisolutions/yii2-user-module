<?php

namespace yiisolutions\user\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;

class SignUpForm extends Model implements SignUpFormInterface
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;

    /**
     * @var User|IdentityInterface
     */
    private $_userIdentity;

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
     * @inheritdoc
     */
    public function getUserIdentity()
    {
        if ($this->_userIdentity === null) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = $this->password;

            if ($user->save()) {
                $this->_userIdentity = $user;
            } else {
                if ($user->hasErrors()) {
                    foreach ($user->getErrors() as $attribute => $errors) {
                        if (property_exists($this, $attribute)) {
                            foreach ($errors as $error) {
                                $this->addError($attribute, $error);
                            }
                        }
                    }
                }
                $this->_userIdentity = false;
            }
        }

        return $this->_userIdentity;
    }

    /**
     * @inheritdoc
     */
    public function signUp()
    {
        if (!$this->validate() || !$this->getUserIdentity()) {
            return false;
        }

        return true;
    }
}

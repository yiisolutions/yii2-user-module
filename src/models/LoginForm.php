<?php

namespace yiisolutions\user\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\web\IdentityInterface;
use yiisolutions\user\Module;

class LoginForm extends Model implements LoginFormInterface
{
    public $username;
    public $password;
    public $remember_me;

    /**
     * @var User
     */
    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string'],

            [['password'], 'validatePassword'],

            [['remember_me'], 'boolean'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->getUserIdentity()) {
                $this->addError($attribute, 'Username or password incorrect');
            }
        }
    }

    /**
     * This method should return user identity model or false if not found.
     *
     * @return IdentityInterface|false
     */
    public function getUserIdentity()
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentityByUsername($this->username);
            if (!$this->_user || !$this->_user->validatePassword($this->password)) {
                $this->_user = false;
            }
        }

        return $this->_user;
    }

    /**
     * @inheritdoc
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $rememberMeDuration = isset(Yii::$app->params['yiisolutions.user.rememberMeDuration'])
            ? Yii::$app->params['yiisolutions.user.rememberMeDuration'] : 3600 * 24 * 30;

        return Yii::$app->user->login($this->getUserIdentity(), $this->remember_me  ? $rememberMeDuration : 0);
    }
}

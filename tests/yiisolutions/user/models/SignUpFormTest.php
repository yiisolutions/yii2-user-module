<?php

namespace yiisolutions\user\models;

use yii\web\Application;
use yii\web\IdentityInterface;

class SignUpFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $_application;

    /**
     * @param $username
     * @param $email
     * @param $password
     * @param $password_repeat
     * @param $isValid
     *
     * @dataProvider signUpMethodDataProvider
     */
    public function testSignUpMethod($username, $email, $password, $password_repeat, $isValid)
    {
        $this->loadApplication();

        $model = new SignUpForm([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'password_repeat' => $password_repeat,
        ]);

        $this->assertEquals($isValid, $model->signUp());

        if ($isValid) {
            $model->getUserIdentity()->delete();
        }
    }

    public function signUpMethodDataProvider()
    {
        return [
            ['john.doe', 'john.doe@example.com', '123456', '123456', true],
            ['user', 'user@example.com', '123456', '123456', false],
        ];
    }

    /**
     * @return Application
     */
    private function loadApplication()
    {
        if (!$this->_application) {
            $this->_application = (new Application(require(__DIR__ . '/../../../app/config/web.php')));
        }

        return $this->_application;
    }
}

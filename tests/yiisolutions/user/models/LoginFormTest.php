<?php

namespace yiisolutions\user\models;

use yii\web\Application;

class LoginFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $_application;

    /**
     * @param $username
     * @param $password
     * @param $exists
     *
     * @dataProvider loginDataProvider
     */
    public function testLoginMethod($username, $password, $exists)
    {
        $this->loadApplication();

        $model = new LoginForm([
            'username' => $username,
            'password' => $password,
        ]);

        $this->assertEquals($exists, $model->login());
    }

    public function loginDataProvider()
    {
        return [
            ['user', 'test', true],
            ['test', 'test', false],
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

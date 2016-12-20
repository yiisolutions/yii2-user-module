<?php

namespace yiisolutions\user\actions;

use yii\web\Application;
use yii\web\Response;
use yiisolutions\user\models\User;

class LogoutActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $_application;

    public function testInitSuccessful()
    {
        $app = $this->loadApplication();

        $response = $app->runAction('site/logout');

        $this->assertNotEmpty($response);
        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @param $username
     *
     * @dataProvider logoutWorksDataProvider
     */
    public function testLogoutWorks($username)
    {
        $app = $this->loadApplication();

        $identity = User::findIdentityByUsername($username);
        $app->user->login($identity);

        $this->assertFalse($app->user->isGuest);

        $app->runAction('site/logout');

        $this->assertTrue($app->user->isGuest);
    }

    public function logoutWorksDataProvider()
    {
        return [
            ['user'],
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

<?php

namespace yiisolutions\user\actions;

use app\controllers\SiteController;
use app\models\FakeLoginForm;
use app\models\FakeLoginFormNotImplementInterface;
use app\models\FakeLoginFormNotInheritModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Application;
use yii\web\View;
use yiisolutions\user\models\LoginFormInterface;

class LoginActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $_application;

    public function testInitSuccessful()
    {
        $app = $this->loadApplication();
        $view = $this->getMockView(['render', 'renderFile']);

        $app->set('view', $view);

        $view->expects($this->once())
            ->method('render')
            ->with($this->equalTo('@yiisolutions/user/views/login'), $this->arrayHasKey('model'), $this->isInstanceOf(SiteController::class))
            ->will($this->returnValue('content'));

        $view->expects($this->once())
            ->method('renderFile')
            ->with($this->isType('string'), $this->equalTo(['content' => 'content']), $this->isInstanceOf(SiteController::class))
            ->will($this->returnValue('content'));

        $this->assertEquals('content', $app->runAction('site/login'));
    }

    /**
     * @param array $options
     * @param $exception
     * @param $message
     *
     * @dataProvider initErrorDataProvider
     */
    public function testInitError(array $options, $exception, $message)
    {
        $this->loadApplication();

        $this->expectException($exception);
        $this->expectExceptionMessage($message);

        new LoginAction('id', null, $options);
    }

    public function initErrorDataProvider()
    {
        return [
            [['modelClass' => null], InvalidConfigException::class, 'Model class not specified.'],
            [['modelClass' => 'wrongClass'], InvalidConfigException::class, 'Model class \'wrongClass\' not found.'],
            [['modelClass' => FakeLoginFormNotImplementInterface::class], InvalidConfigException::class, "Model class '" . FakeLoginFormNotImplementInterface::class . "' not implement interface '" . LoginFormInterface::class . "'"],
            [['modelClass' => FakeLoginFormNotInheritModel::class], InvalidConfigException::class, "Model class '" . FakeLoginFormNotInheritModel::class . "' not extend standard model class."]
        ];
    }

    /**
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|View
     */
    private function getMockView(array $methods = [])
    {
        return $this->getMockBuilder(View::class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
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

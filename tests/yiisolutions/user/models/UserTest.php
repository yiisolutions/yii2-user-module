<?php

namespace yiisolutions\user\models;

use yii\web\Application;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $_application;

    public function setUp()
    {
        parent::setUp();
        $this->_application = (new Application(require(__DIR__ . '/../../../app/config/web.php')));
    }

    public function testGetIdMethod()
    {
        $user = new User(['id' => 10]);
        $this->assertEquals($user->id, $user->getId());
    }
}

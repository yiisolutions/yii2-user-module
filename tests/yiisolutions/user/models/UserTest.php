<?php

namespace yiisolutions\user\models;

use yii\web\Application;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $_application;

    public function testGetIdMethod()
    {
        $this->loadApplication();

        $user = new User(['id' => 10]);
        $this->assertEquals($user->id, $user->getId());
    }

    /**
     * @param $attribute
     * @param $value
     * @param $isValid
     * @param $message
     *
     * @dataProvider attributeValidationDataProvider
     */
    public function testAttributeValidation($attribute, $value, $isValid, $message)
    {
        $this->loadApplication();

        $model = new User([
            $attribute => $value,
        ]);

        $this->assertEquals($isValid, $model->validate([$attribute]));
        $this->assertEquals($message, $model->getFirstError($attribute));
    }

    public function attributeValidationDataProvider()
    {
        return [
            ['username', null, false, 'Username cannot be blank.'],
            ['username', '', false, 'Username cannot be blank.'],
            ['username', false, false, 'Username must be a string.'],
            ['username', 0, false, 'Username must be a string.'],
            ['username', '11231sdasd', false, 'Username is invalid.'],
            ['username', 'user', false, 'Username "user" has already been taken.'],
            ['username', 'test', false, 'Username "test" has already been taken.'],
            ['username', 'man', true, ''],
            ['username', 'john.doe', true, ''],

            ['email', null, false, 'Email cannot be blank.'],
            ['email', '', false, 'Email cannot be blank.'],
            ['email', false, false, 'Email must be a string.'],
            ['email', 0, false, 'Email must be a string.'],
            ['email', 'user@example.com', false, 'Email "user@example.com" has already been taken.'],
            ['email', 'test@example.com', false, 'Email "test@example.com" has already been taken.'],
            ['email', 'man@example.com', true, ''],
            ['email', 'john.doe@example.com', true, ''],
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

<?php

namespace yiisolutions\user\models;

use Yii;
use yii\base\NotSupportedException;
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

    public function testGetAuthKeyMethod()
    {
        $this->loadApplication();

        $user = new User(['auth_key' => User::generateAuthKey()]);
        $this->assertEquals($user->auth_key, $user->getAuthKey());
    }

    /**
     * @param $expect
     * @param $authKey
     * @param $isValid
     *
     * @dataProvider validateAuthKeyDataProvider
     */
    public function testValidateAuthKey($expect, $authKey, $isValid)
    {
        $this->loadApplication();

        $model = new User(['auth_key' => $expect]);

        $this->assertEquals($isValid, $model->validateAuthKey($authKey));
    }

    /**
     * @param $username
     * @param $password
     * @param $isValid
     *
     * @dataProvider validatePasswordDataProvider
     */
    public function testValidatePassword($username, $password, $isValid)
    {
        $this->loadApplication();

        $model = User::findOne(['username' => $username]);

        $this->assertEquals($isValid, $model->validatePassword($password));
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

    public function testAuthKeyAutoFillBehavior()
    {
        $this->loadApplication();

        $model = new User([
            'username' => 'test.user',
            'email' => 'test.user@example.com',
            'password_hash' => User::generatePasswordHash('test.user'),
        ]);

        $this->assertTrue($model->validate());
        $this->assertNotEmpty($model->auth_key);
    }

    public function testAuthKeyDisableAutoFillWhenSpecified()
    {
        $this->loadApplication();

        $authKey = User::generateAuthKey();
        $model = new User([
            'username' => 'test.user',
            'email' => 'test.user@example.com',
            'password_hash' => User::generatePasswordHash('test.user'),
            'auth_key' => $authKey,
        ]);

        $this->assertTrue($model->validate());
        $this->assertEquals($authKey, $model->auth_key);
    }

    /**
     * @param $username
     * @param $exists
     *
     * @dataProvider findIdentityByUsernameDataProvider
     */
    public function testFindIdentityByUsername($username, $exists)
    {
        $this->loadApplication();

        $model = User::findIdentityByUsername($username);

        $this->assertEquals($exists, ($model instanceof User));
    }

    /**
     * @param $id
     * @param $exists
     *
     * @dataProvider findIdentityDataProvider
     */
    public function testFindIdentityMethodDirectly($id, $exists)
    {
        $this->loadApplication();

        $model = User::findIdentity($id);

        $this->assertEquals($exists, ($model instanceof User));
    }

    /**
     * @param $password
     *
     * @dataProvider setPasswordDataProvider
     */
    public function testSetPasswordGenerateHash($password)
    {
        $this->loadApplication();

        $model = new User();
        $model->setPassword($password);

        $this->assertNotEmpty($model->password_hash);
        $this->assertEquals($password, $model->getPassword());
    }

    public function testNotSupportFindIdentityByAccessToken()
    {
        $this->loadApplication();

        $this->expectException(NotSupportedException::class);
        $this->expectExceptionMessage('"findIdentityByAccessToken" is not implemented.');

        User::findIdentityByAccessToken('token');
    }

    public function findIdentityByUsernameDataProvider()
    {
        return [
            ['test', false],
            ['test@example.com', false],
            ['user', true],
            ['user@example.com', true],
            ['man', false],
            ['man@example.com', false],
            ['empty', false],
            ['empty@example.com', false],
        ];
    }

    public function findIdentityDataProvider()
    {
        return [
            [1, false],
            [2, true],
            [3, false],
            [4, false],
        ];
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

    public function validateAuthKeyDataProvider()
    {
        return [
            ['asdasdasd78asd88sa', null, false],
            ['asdasdasd78asd88sa', false, false],
            ['asdasdasd78asd88sa', '', false],
            ['asdasdasd78asd88sa', 'asdasdasd78asd88sa', true],
            ['asdasdasd78asd88sa', 'asdasdasd78asd885434sa', false],
            ['asdasdasd78asd88sa', 'asdasdasd78asd8sa', false],
            ['asdasdasd78asd88sa', 'asdasdasd78asdsa', false],
        ];
    }

    public function validatePasswordDataProvider()
    {
        return [
            ['user', 'test', true],
            ['test', 'test', true],
            ['man', 'test', true],
            ['user', 'test4', false],
            ['user', 'tes', false],
        ];
    }

    public function setPasswordDataProvider()
    {
        return [
            ['123'],
            ['4523574389'],
            ['d8fgsd9f6'],
            ['435345rt'],
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

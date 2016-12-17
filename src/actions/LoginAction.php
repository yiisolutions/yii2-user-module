<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yiisolutions\user\events\LoginEvent;
use yiisolutions\user\models\LoginForm;
use yiisolutions\user\models\LoginFormInterface;

class LoginAction extends Action
{
    const EVENT_LOGIN_SUCCESS = 'loginSuccess';
    const EVENT_LOGIN_FAILED = 'loginFailed';

    /**
     * @var string full name of the model class. This class must implement the interface
     * yiisolutions\user\models\LoginFormInterface and inherit yii\base\Model.
     */
    public $modelClass = LoginForm::class;

    /**
     * @var string view name for this action. You can specify your own view file. The file
     * will take one variable - $model. This will be an instance of the class specified
     * in the $modelClass.
     */
    public $view = '@yiisolutions/user/views/login';

    /**
     * @var int value for the duration of the user session life. Default is 30 days.
     * This option is passed to the method login() in $options array and is used if user
     * has selected "Remember me" checkbox. Otherwise, user session will live up to the
     * closing of browser window.
     */
    public $rememberMeDuration = 3600 * 24 * 30;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->modelClass)) {
            throw new InvalidConfigException('Model class not specified.');
        }

        if (!class_exists($this->modelClass)) {
            throw new InvalidConfigException("Model class '{$this->modelClass}' not found.");
        }

        if (!in_array(LoginFormInterface::class, class_implements($this->modelClass))) {
            throw new InvalidConfigException("Model class '{$this->modelClass}' not implement interface '" . LoginFormInterface::class . "'");
        }

        if (!in_array(Model::class, class_parents($this->modelClass))) {
            throw new InvalidConfigException("Model class '{$this->modelClass}' not extend standard model class.");
        }
    }

    public function run()
    {
        $model = $this->getModel();
        $data = Yii::$app->request->post();

        if ($model->load($data)) {
            if ($model->login(['rememberMeDuration' => $this->rememberMeDuration])) {
                $this->triggerModelEvent(self::EVENT_LOGIN_SUCCESS, $model);

                return $this->controller->goBack();
            }
        }

        if ($model->hasErrors()) {
            $this->triggerModelEvent(self::EVENT_LOGIN_FAILED, $model);
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }

    /**
     * @return LoginFormInterface|Model
     */
    private function getModel()
    {
        return new $this->modelClass();
    }

    /**
     * @param $eventName
     * @param LoginFormInterface $model
     */
    private function triggerModelEvent($eventName, LoginFormInterface $model)
    {
        $event = new LoginEvent();
        $event->model = $model;
        $this->trigger($eventName, $event);
    }
}

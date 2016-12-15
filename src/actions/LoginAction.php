<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yiisolutions\user\models\LoginFormInterface;

class LoginAction extends Action
{
    public $modelClassName = 'yiisolutions\user\models\LoginForm';

    public $viewName = '@yiisolutions/user/views/login';

    /**
     * @var \Closure
     */
    public $successCallback;

    public function init()
    {
        parent::init();

        if (empty($this->modelClassName)) {
            throw new InvalidConfigException("Model class name not specified");
        }

        if (!class_exists($this->modelClassName)) {
            throw new InvalidConfigException("Model class {$this->modelClassName} not found");
        }

        if (!in_array(LoginFormInterface::class, class_implements($this->modelClassName))) {
            throw new InvalidConfigException("Model class {$this->modelClassName} not implement interface " . LoginFormInterface::class);
        }

        if (!in_array(Model::class, class_parents($this->modelClassName))) {
            throw new InvalidConfigException("Model class {$this->modelClassName} not extend standard model class");
        }
    }

    public function run()
    {
        $model = $this->getModel();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->login()) {
                if ($this->successCallback instanceof \Closure) {
                    return $this->successCallback->__invoke($this, $model);
                }

                return $this->controller->goBack();
            }
        }

        return $this->controller->render($this->viewName, [
            'model' => $model,
        ]);
    }

    /**
     * @return LoginFormInterface|Model
     */
    private function getModel()
    {
        $modelClassName = $this->modelClassName;
        return new $modelClassName();
    }
}

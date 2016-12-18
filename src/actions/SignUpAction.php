<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yiisolutions\user\events\SignUpEvent;
use yiisolutions\user\models\SignUpFormInterface;

class SignUpAction extends Action
{
    const EVENT_SIGN_UP_SUCCESS = 'signUpSuccess';
    const EVENT_SIGN_UP_FAILED = 'signUpFailed';

    /**
     * @var string full name of the model class. This class must implement the interface
     * yiisolutions\user\models\SignUpFormInterface and inherit yii\base\Model.
     */
    public $modelClass = 'yiisolutions\user\models\SignUpForm';

    /**
     * @var string view name for this action. You can specify your own view file. The file
     * will take one variable - $model. This will be an instance of the class specified
     * in the $modelClass.
     */
    public $view = '@yiisolutions/user/views/sign-up';

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

        if (!in_array(SignUpFormInterface::class, class_implements($this->modelClass))) {
            throw new InvalidConfigException("Model class '{$this->modelClass}' not implement interface '" . SignUpFormInterface::class . "'");
        }

        if (!in_array(Model::class, class_parents($this->modelClass))) {
            throw new InvalidConfigException("Model class '{$this->modelClass}' not extend standard model class.");
        }
    }

    public function run()
    {
        $model = $this->getModel();

        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {
            $return = $this->triggerModelEvent(self::EVENT_SIGN_UP_SUCCESS, $model);
            if ($return !== null) {
                return $return;
            }

            return $this->controller->goBack();
        }

        if ($model->hasErrors()) {
            $this->triggerModelEvent(self::EVENT_SIGN_UP_FAILED, $model);
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }

    /**
     * @return SignUpFormInterface|Model
     */
    private function getModel()
    {
        $modelClassName = $this->modelClass;
        return new $modelClassName();
    }

    /**
     * @param $eventName
     * @param SignUpFormInterface $model
     * @return mixed
     */
    private function triggerModelEvent($eventName, SignUpFormInterface $model)
    {
        $event = new SignUpEvent();
        $event->model = $model;
        $this->trigger($eventName, $event);

        return $event->return;
    }
}

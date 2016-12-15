<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yiisolutions\user\models\SignUpFormInterface;

class SignUpAction extends Action
{
    public $modelClassName = 'yiisolutions\user\models\SignUpForm';

    public $viewName = '@yiisolutions/user/views/sign-up';

    /**
     * @var \Closure
     */
    public $successCallback;

    public function run()
    {
        $model = $this->getModel();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->signUp();

            if ($this->successCallback instanceof \Closure) {
                return $this->successCallback->__invoke($this, $model);
            }

            return $this->controller->goBack();
        }

        return $this->controller->render($this->viewName, [
            'model' => $model,
        ]);
    }

    /**
     * @return SignUpFormInterface|Model
     */
    private function getModel()
    {
        $modelClassName = $this->modelClassName;
        return new $modelClassName();
    }
}

<?php

namespace yiisolutions\user\actions;

use yii\base\Action;
use yii\web\NotFoundHttpException;
use yiisolutions\user\models\User;

class ActivationAction extends Action
{
    const EVENT_ACTIVATION_SUCCESS = 'activationSuccess';

    /**
     * @var string
     */
    public $modelClass = 'yiisolutions\user\models\User';

    /**
     * @var string
     */
    public $view = '@yiisolutions/user/views/activation';

    public function run($token)
    {
        /** @var User $modelClass */
        $modelClass = $this->modelClass;
        $model = $modelClass::findIdentityByActivationToken($token);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->status = User::STATUS_ACTIVATED;
        $model->save(false, ['status']);

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yiisolutions\user\models\PasswordResetFormInterface;

class PasswordResetAction extends Action
{
    public $modelClass = 'yiisolutions\user\models\PasswordResetForm';

    public $view = '@yiisolutions/user/views/password-reset';

    public function run()
    {
        $data = Yii::$app->request->post();
        $token = Yii::$app->request->getQueryParam('token');
        $model = $this->getModel($token);

        if ($model->load($data) && $model->passwordReset()) {
            return $this->controller->goBack();
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     *
     * @return Model|PasswordResetFormInterface
     */
    public function getModel($token)
    {
        return new $this->modelClass($token);
    }
}

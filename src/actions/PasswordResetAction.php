<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yiisolutions\user\models\PasswordResetFormInterface;

/**
 * Password reset action implements the password recovery process. For recovery user should be follow a special link.
 * With a link sends a unique token in query param. If exists token will open a form to enter a new password, after
 * which the token will be removed.
 *
 * Usign:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *         'password-reset' => [
 *             'class' => 'yiisolutions\user\actions\PasswordResetAction',
 *         ],
 *     ];
 * }
 * ```
 *
 * @package yiisolutions\user\actions
 */
class PasswordResetAction extends Action
{
    /**
     * @var string you can override standard model class and use its
     */
    public $modelClass = 'yiisolutions\user\models\PasswordResetForm';

    /**
     * @var string you can override standard view file
     */
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

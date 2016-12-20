<?php

namespace yiisolutions\user\actions;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yiisolutions\user\models\ForgotPasswordFormInterface;

class ForgotPasswordAction extends Action
{
    const EVENT_FORGOT_PASSWORD_SUCCESS = 'forgotPasswordSuccess';
    const EVENT_FORGOT_PASSWORD_FAILED = 'forgotPasswordFailed';

    public $modelClass = 'yiisolutions\user\models\ForgotPasswordForm';

    public $view = '@yiisolutions/user/views/forgot-password';

    public $passwordResetRouteName;

    public $passwordResetRouteParamName = 'token';

    public $passwordResetMailView = [
        'text' => '@yiisolutions/user/mail/password-reset-text',
        'html' => '@yiisolutions/user/mail/password-reset-html',
    ];

    public function run()
    {
        $model = $this->getModel();
        $data = Yii::$app->request->post();

        if ($model->load($data) && $model->forgotPassword()) {
            if (!empty($this->passwordResetRouteName)) {
                $this->sendEmail($model);
            }
        }

        if ($model->hasErrors()) {

        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }

    /**
     * @return Model|ForgotPasswordFormInterface
     */
    private function getModel()
    {
        return new $this->modelClass();
    }

    private function sendEmail(ForgotPasswordFormInterface $model)
    {
        $user = $model->getUserIdentity();
        $message = Yii::$app->mailer->compose($this->passwordResetMailView, [
            'model' => $user,
            'passwordResetUrl' => [
                $this->passwordResetRouteName,
                $this->passwordResetRouteParamName => $user->password_reset_token,
            ],
        ]);

        $fromEmail = isset(Yii::$app->params['yiisolutions.user.passwordResetEmail.from'])
            ? Yii::$app->params['yiisolutions.user.passwordResetEmail.from'] : null;
        if (!empty($fromEmail)) {
            $message->setFrom($fromEmail);
        }

        $message->setTo($user->email);

        $subject = isset(Yii::$app->params['yiisolutions.user.passwordResetEmail.subject'])
            ? Yii::$app->params['yiisolutions.user.passwordResetEmail.subject'] : null;

        if (!empty($subject)) {
            $message->setSubject($subject);
        }

        if (!$message->send()) {
//            $this->triggerModelEvent(self::EVENT_ACTIVATION_EMAIL_SEND_FAILED, $model);
        }
    }
}

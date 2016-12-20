<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \yiisolutions\user\models\User */
/* @var $passwordResetUrl string|array */

$passwordResetLink = Yii::$app->urlManager->createAbsoluteUrl($passwordResetUrl);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($model->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($passwordResetLink), $passwordResetLink) ?></p>
</div>

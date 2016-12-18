<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \yiisolutions\user\models\User */
/* @var $activationUrl string|array */

$activationLink = Yii::$app->urlManager->createAbsoluteUrl($activationUrl);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($model->username) ?>,</p>

    <p>Follow the link below to activate your account:</p>

    <p><?= Html::a(Html::encode($activationLink), $activationLink) ?></p>
</div>

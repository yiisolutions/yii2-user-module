<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \yiisolutions\user\models\User */
/* @var $passwordResetUrl string|array */

$passwordResetLink = Yii::$app->urlManager->createAbsoluteUrl($passwordResetUrl);
?>
Hello <?= Html::encode($model->username) ?>,

Follow the link below to reset your password:

<?= $passwordResetLink ?>


<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \yiisolutions\user\models\User */
/* @var $activationUrl string|array */

$activationLink = Yii::$app->urlManager->createAbsoluteUrl($activationUrl);
?>
Hello <?= Html::encode($model->username) ?>,

Follow the link below to activate your account:

<?= $activationLink ?>


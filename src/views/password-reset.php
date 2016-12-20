<?php

/* @var $this \yii\web\View */
/* @var $model \yii\base\Model|\yiisolutions\user\models\PasswordResetFormInterface */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Password Reset';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="user-forgot-password">
    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php $form->end() ?>
</div>

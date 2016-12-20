<?php

/* @var $this \yii\web\View */
/* @var $model \yii\base\Model|\yiisolutions\user\models\ForgotPasswordFormInterface */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="user-forgot-password">
    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php $form->end() ?>
</div>

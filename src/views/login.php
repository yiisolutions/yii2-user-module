<?php

/* @var $this \yii\web\View */
/* @var $model \yiisolutions\user\models\LoginFormInterface|\yii\base\Model */
/* @var $forgotPasswordUrl array|null */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="user-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'remember_me')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php if ($forgotPasswordUrl): ?>
        <p>
            <a href="<?= Url::to($forgotPasswordUrl) ?>">Forgot Password?</a>
        </p>
    <?php endif ?>

    <?php $form->end() ?>
</div>

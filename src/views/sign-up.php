<?php

/* @var $this \yii\web\View */
/* @var $model \yiisolutions\user\models\SignUpFormInterface|\yii\base\Model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="user-sign-up">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php $form->end(); ?>
</div>

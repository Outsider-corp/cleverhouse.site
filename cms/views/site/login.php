<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Войти";
?>
<div style="width: 50%">
<?php
$form = ActiveForm::begin(); ?>
<?= $form->field($model, 'login_user')->textInput(['autofocus'=>true]); ?>
<?= $form->field($model, 'password_user')->passwordInput(); ?>
<?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end(); ?>
</div>

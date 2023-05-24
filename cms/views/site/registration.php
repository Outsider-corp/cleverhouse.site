<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Регистрация";
?>
<?php
$form = ActiveForm::begin(); ?>
<?= $form->field($model, 'login_user'); ?>
<?= $form->field($model, 'password_user')->passwordInput(); ?>
<?= $form->field($model, 'name_user'); ?>
<?= $form->field($model, 'email_user'); ?>
<?= $form->field($model, 'telephone_user'); ?>
<?= $form->field($model, 'region_user'); ?>
<?= $form->field($model, 'city_user'); ?>
<?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end(); ?>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Обратная связь";
?>
<?php
$form = ActiveForm::begin(); ?>
<?php if (Yii::$app->user->isGuest):?>
<?= $form->field($model, 'email'); ?>
<?php else:?>
<?= $form->field($model, 'email')->textInput(['type' => 'text', 'readonly'=>true, 'value' => Yii::$app->user->identity->email_user]);?>
<?php endif;?>
<?= $form->field($model, 'subject');?>
<?= $form->field($model, 'body')->textarea(['rows'=>5]); ?>
<?= Html::submitButton('Отправить письмо', ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end(); ?>
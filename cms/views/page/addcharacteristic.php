<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Добавление/изменение атрибута";
?>
<?php
if (isset($char)) {
    $product = $char['id_product'];
    $form = ActiveForm::begin(['action' => ['page/addcharacteristic', 'id' => $char['id_сharacteristic'], 'product' => $product]]); ?>
    <?= $form->field($model, 'name')->textInput(['type' => 'text', 'value' => $char['name_сharacteristic']]); ?>
    <?= $form->field($model, 'description')->textInput(['value' => $char['description_сharacteristic']]);
} else {
    $form = ActiveForm::begin(['action' => ['page/addcharacteristic']]); ?>
    <?= $form->field($model, 'name')->textInput(['type' => 'text']); ?>
    <?= $form->field($model, 'description')->textInput();
} ?>
<?= Html::submitButton('Отправить запрос', ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end();
if (isset($char)):?>
    <div>
        <a href="<?= Url::toRoute(['page/deletecharacteristic', 'id' => $char['id_сharacteristic'], 'product' => $char['id_product']]);
        ?>">Удалить товар</a></div>
<?php endif; ?>

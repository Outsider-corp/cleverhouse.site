<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Вид доставки и оплаты";

$session = Yii::$app->session;
$session->open();
?>

<div class="col-lg-12">
    <ul class="cart_status">
        <li><span><a href="<?= Url::toRoute('page/cart') ?>"> 1. Заказ</a></span></li>
        <li><span><a href="<?= Url::toRoute('page/address') ?>"> 2. Адрес</a></span></li>
        <li class="active"><span>3. Доставка</span></li>
        <?php
        if (isset($session['dostavka'])): ?>
            <li><span><a href="<?= Url::toRoute('page/checkout') ?>"> 4. Подтверждение</a></span></li>
        <?php else: ?>
            <li><span>4. Подтверждение</span></li>
        <?php endif; ?>
    </ul>
</div>

<?php
$form = ActiveForm::begin([
    'id' => 'form',
    'method' => 'post',]); ?>
<div class="row equal-height">
    <div class="col-md-6">
        <?= $form->field($model, 'attribute', ['template' => "<h3>{label}</h3>\n<div class='radio-list'>{input}</div>\n{error}",])->radioList([
            'Почта' => 'Почта России',
            'CDEK' => 'CDEK',
            'Boxberry' => 'Boxberry',
            'Pickpoint' => 'Pickpoint',
            'Курьер' => 'Курьером',
        ], ['itemOptions' => ['labelOptions' => ['class' => 'radio']]]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'oplata', ['template' => "<h3>{label}</h3>\n<div class='radio-list'>{input}</div>\n{error}",])->radioList([
            'Карта' => 'Банковская карта',
            'Перевод' => 'Перевод через СБП',
            'Наличные' => 'Наличными при получении',
        ], ['itemOptions' => ['labelOptions' => ['class' => 'radio']]]); ?>
    </div>
    <div class="col-lg-12 btn_cart_wrap">
        <a href="<?= Url::toRoute('page/cart') ?>" class="btn_cart_im"><i class="glyphicon glyphicon-chevron-left"></i>Вернуться
            к заказу</a>
        <?= Html::a('Далее <i class="glyphicon glyphicon-chevron-right"></i>',
            '#', ['class' => 'btn_cart_zakaz', 'onclick' => '$("#form").yiiActiveForm("validate", true);
             if ($("#form").yiiActiveForm("validated")) $("#form").submit(); return false;']); ?>

    </div>
    <?php ActiveForm::end(); ?>

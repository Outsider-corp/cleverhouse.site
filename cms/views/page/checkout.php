<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Подтверждение заказа";

$session = Yii::$app->session;
$session->open();
?>

<div class="col-lg-12">
    <ul class="cart_status">
        <li><span><a href="<?= Url::toRoute('page/cart') ?>"> 1. Заказ</a></span></li>
        <li><span><a href="<?= Url::toRoute('page/address') ?>"> 2. Адрес</a></span></li>
        <li><span><a href="<?= Url::toRoute('page/dostavka') ?>"> 3. Доставка</a></span></li>
        <li class="active"><span>4. Подтверждение</span></li>
    </ul>
</div>

<h2>Информация о заказе</h2>
<div>
    <ul class="list-info">
        <li><b>E-mail:</b> <?= Yii::$app->user->identity->email_user ?></li>
        <li><b>Имя:</b> <?= Yii::$app->user->identity->name_user ?></li>
        <li>
            <b>Адрес:</b> <?= $session['order_city'] . ', ' . $session['order_address'] . ', ' . $session['order_region']; ?>
        </li>
        <li><b>Способ доставки:</b> <?= $session['dostavka']; ?></li>
        <li><b>Способ оплаты:</b> <?= $session['oplata']; ?></li>
    </ul>
</div>
<table class="table table-bordered">
    <tr class="cart_prod_head">
        <td class="img_cart">Товар</td>
        <td class="price_cart">Цена</td>
        <td class="value_cart">Кол-во</td>
        <td class="rez_price_cart">Стоимость</td>
    </tr>
    <?php $i = 0; ?>
    <?php foreach ($products as $value): ?>
        <tr class="cart_prod_content">
            <td class="title_cart"><?php echo $value['name_product']; ?></td>
            <td class="price_cart price_js"><?php echo number_format($value['price'], 0, '', ' '); ?> руб</td>
            <td class="value_cart"><?php echo $value['count_cart']; ?></td>
            <td class="rez_price_cart rez_one"><?php
                $sum += $value['price'] * $value['count_cart'];
                echo number_format($value['price'] * $value['count_cart'], 0, '', ' ');
                $i++; ?> руб
            </td>
        </tr>
    <?php endforeach; ?>
    <tr class="cart_prod_footer">
        <td colspan="1" class="rez_title_cart">Итого, к оплате:</td>
        <td colspan="2" class="null_cart"></td>
        <td class="rez_price_cart rez_sum"><?php echo number_format($sum, 0, '', ' '); ?> руб</td>
    </tr>
</table>
</div>
<div class="col-lg-12 btn_cart_wrap">
    <a href="<?php echo Url::toRoute(['page/order']); ?>" class="btn_cart_zakaz">Оформить заказ</a>
</div>


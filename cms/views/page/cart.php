<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Корзина";

$session = Yii::$app->session;
$session->open();
?>

<div class="col-lg-12 top_cart_block">
    <div>
        <p>Состояние корзины</p>
        <p>Товаров в корзине: <?php echo array_sum(array_column($products, 'count_cart')); ?></p>
    </div>
</div>
<div class="col-lg-12">
    <ul class="cart_status">
        <li class="active"><span>1. Заказ</span></li>
        <li><span>2. Адрес</span></li>
        <li><span>3. Доставка</span></li>
        <li><span>4. Проверка</span></li>
    </ul>
</div>
<div class="col-lg-12">
    <?php if (count($products) == 0): ?>
    <p>В корзине нет товаров</p>
</div>
<?php else: $sum = 0;?>

    <table class="table table-bordered">
        <tr class="cart_prod_head">
            <td class="img_cart">Товар</td>
            <td class="title_cart">Название</td>
            <td class="price_cart">Цена за единицу</td>
            <td class="value_cart">Кол-во</td>
            <td class="rez_price_cart">Стоимость</td>
        </tr>
        <?php $form1 = ActiveForm::begin(['id' => 'form1', 'method' => 'post',]); ?>
        <?php foreach ($products as $key => $value): ?>
            <tr class="cart_prod_content">
                <td class="img_cart"><img src="images/<?php echo $value['img_product']; ?>"></td>
                <td class="title_cart"><a class='product_cart_link'
                                          href="<?= Url::toRoute(['page/product', 'id' => $value['id']]) ?>"><?php echo $value['name_product']; ?></a>
                </td>
                <td class="price_cart price_js"
                    id="price-<?= $key ?>"><?php echo number_format($value['price'], 0, '', ' '); ?> руб
                </td>
                <td class="value_cart">
                    <div>
                        <div class="form-row">
                            <?= $form1->field($model, 'values[' . $key . ']')->textInput(['type' => 'number', 'readonly' => true,
                                'class' => 'input_text', 'id' => 'input-' . $key, 'value' => $value['count_cart']])->label(false); ?>
                            <button type="button" class="minus-cart-button form-cart" data-index="<?= $key ?>">-
                            </button>
                            <button type="button" class="plus-cart-button form-cart" data-index="<?= $key ?>">+</button>
                        </div>
                    </div>
                </td>
                <td class="rez_price_cart rez_one" id="rez-price-<?= $key ?>"><?php
                    $sum += $value['price'] * $value['count_cart'];
                    echo number_format($value['price'] * $value['count_cart'], 0, '', ' '); ?> руб
                </td>
            </tr>
        <?php endforeach; ?>
        <tr class="cart_prod_footer">
            <td colspan="2" class="null_cart"></td>
            <td colspan="2" class="rez_title_cart">Итого, к оплате:</td>
            <td class="rez_price_cart rez_sum" id="rez-sum"><?php echo number_format($sum, 0, '', ' '); ?> руб</td>
        </tr>
    </table>
    </div>
    <div class="col-lg-12 btn_cart_wrap">

        <?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i>Продолжить покупки', '#',
            ['class' => 'btn_cart_im', 'onclick' => 'submitFormCart("back"); return false;']); ?>
        <?= Html::a('Оформить заказ<i class="glyphicon glyphicon-chevron-right"></i>', '#',
            ['class' => 'btn_cart_zakaz', 'onclick' => 'submitFormCart("next"); return false;']); ?>
        <?= Html::hiddenInput('submit-button', '', ['id' => 'submit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php endif; ?>


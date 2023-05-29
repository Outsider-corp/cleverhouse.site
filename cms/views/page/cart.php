<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Корзина";
JqueryAsset::register($this);
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
        <?php if (count($products) > 0): ?>
            <li><span><a href="<?= Url::toRoute('page/address') ?>"> 2. Адрес</a></span></li>
        <?php else: ?>
            <li><span>2. Адрес</span></li>
        <?php endif;
        if (isset($session['order_city'])):?>
            <li><span><a href="<?= Url::toRoute('page/dostavka') ?>"> 3. Доставка</a></span></li>
        <?php
        else:?>
            <li><span>3. Доставка</span></li>
        <?php endif;
        if (isset($session['dostavka'])): ?>
            <li><span><a href="<?= Url::toRoute('page/checkout') ?>"> 4. Подтверждение</a></span></li>
        <?php else: ?>
            <li><span>4. Проверка</span></li>
        <?php endif; ?>
    </ul>
</div>
<div class="col-lg-12">
    <?php if (count($products) == 0): ?>
    <p>В корзине нет товаров</p>
</div>
<?php else: $sum = 0 ?>


    <table class="table table-bordered">
        <tr class="cart_prod_head">
            <td class="img_cart">Товар</td>
            <td class="title_cart">Название</td>
            <td class="price_cart">Цена за единицу</td>
            <td class="value_cart">Кол-во</td>
            <td class="rez_price_cart">Стоимость</td>
        </tr>
        <?php $i = 0; ?>
        <?php $form1 = ActiveForm::begin(['id' => 'form1']); ?>
        <?php foreach ($products as $value): ?>
            <tr class="cart_prod_content">
                <td class="img_cart"><img src="images/<?php echo $value['img_product']; ?>"></td>
                <td class="title_cart"><a class='product_cart_link'
                                          href="<?= Url::toRoute(['page/product', 'id' => $value['id']]) ?>"><?php echo $value['name_product']; ?></a>
                </td>
                <td class="price_cart price_js"><?php echo number_format($value['price'], 0, '', ' '); ?> руб</td>
                <td class="value_cart">
                    <div>
                        <div class="form-row">
                            <?= $form1->field($model, 'values[$i]')->textInput(['type' => 'number', 'readonly'=>true,
                                'class' => 'input_text', 'id'=>'input' . $i, 'value' => $value['count_cart']])->label(false); ?>
                            <button type="button" class="minus form-cart" data-index="<?=$i;?>">-</button>
                            <button type="button" class="plus form-cart" data-index="<?=$i;?>">+</button>
                        </div>

                        <!--                        <input type="text" class="value_cart_text" value="-->
                        <?php //echo $value['count_cart'] ?><!--" readonly>-->
                        <!--                        <span class="minus_cart" >-</span>-->
                        <!--                        <span class="plus_cart">+</span>-->
                    </div>
                </td>
                <td class="rez_price_cart rez_one"><?php
                    $sum += $value['price'] * $value['count_cart'];
                    echo number_format($value['price'] * $value['count_cart'], 0, '', ' ');
                    $i++; ?> руб
                </td>
            </tr>
        <?php endforeach; ?>
        <?php ActiveForm::end(); ?>
        <tr class="cart_prod_footer">
            <td colspan="2" class="null_cart"></td>
            <td colspan="2" class="rez_title_cart">Итого, к оплате:</td>
            <td class="rez_price_cart rez_sum"><?php echo number_format($sum, 0, '', ' '); ?> руб</td>
        </tr>
    </table>
    </div>
    <div class="col-lg-12 btn_cart_wrap">
        <!--        <a href="-->
        <?php //= Url::toRoute('site/index') ?><!--" class="btn_cart_im"><i class="glyphicon glyphicon-chevron-left"></i>Продолжить-->
        <!--            покупки</a>-->
        <!--        <a href="-->
        <?php //echo Url::toRoute('page/address'); ?><!--" class="btn_cart_zakaz">Оформить заказ<i-->
        <!--                    class="glyphicon glyphicon-chevron-right"></i></a>-->
        <?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i>Продолжить
            покупки',
            ['page/cart', 'param' => 'back'], ['class' => 'btn_cart_im', 'onclick' => '$("#form1").yiiActiveForm("validate", true);
                 if ($("#form1").yiiActiveForm("validated")) $("#form1").submit(); return false;']); ?>
        <?= Html::a('Оформить заказ<i class="glyphicon glyphicon-chevron-right"></i>',
            ['page/cart', 'param' => 'next'], ['class' => 'btn_cart_zakaz', 'onclick' => '$("#form1").yiiActiveForm("validate", true);
                 if ($("#form1").yiiActiveForm("validated")) $("#form1").submit(); return false;']); ?>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function() {
        // Обработчик нажатия кнопки "+"
        $('.plus').on('click', function() {
            var index = $(this).data('index'); // Получение индекса кнопки
            var input = $('#input' + index); // Получение соответствующего поля ввода
            var value = parseInt(input.val()); // Получение текущего значения поля ввода
            input.val(value + 1); // Увеличение значения на 1
        });

        // Обработчик нажатия кнопки "-"
        jQuery('.minus').on('click', function() {
            var index = $(this).data('index'); // Получение индекса кнопки
            var input = $('#input' + index); // Получение соответствующего поля ввода
            var value = parseInt(input.val()); // Получение текущего значения поля ввода
            if (value > 0) {
                input.val(value - 1); // Уменьшение значения на 1, если оно больше нуля
            }
        });
    });



    // var input_text = Number($(".input_text").val());
    // var count_prod = Number($(".count_prod").text());
    //
    //
    // jQuery(".plus").on("click", function () {
    //     if (input_text < count_prod) {
    //         input_text = input_text + 1;
    //         $(".input_text").val(input_text);
    //     }
    //
    // })
    //
    // jQuery(".minus").on("click", function () {
    //     if (input_text > 1) {
    //         input_text = input_text - 1;
    //         $(".input_text").val(input_text);
    //     }
    // })
</script>


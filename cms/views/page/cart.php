<?php

use yii\helpers\Url;

?>

<div class="col-lg-12 top_cart_block">
    <div>
        <p>Состояние корзины</p>
        <p>Товаров в корзине: <?php echo count($products);?></p>
    </div>
</div>
<div class="col-lg-12">
    <ul class="cart_status">
        <li class="active"><span>1. Заказ</span></li>
        <li><span>2. Адрес</span></li>
        <li><span>3. Доставка</span></li>
        <li><span>4. Оплата</span></li>
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
            <td class="title_cart">Описание</td>
            <td class="price_cart">Цена за единицу</td>
            <td class="value_cart">Кол-во</td>
            <td class="rez_price_cart">Стоимость</td>
        </tr>

        <?php foreach ($products as $value): ?>
            <tr class="cart_prod_content">
                <td class="img_cart"><img src="images/<?php echo $value['img_product']; ?>"></td>
                <td class="title_cart"><?php echo $value['name_product']; ?></td>
                <td class="price_cart price_js"><?php echo number_format($value['price'], 0, '', ' '); ?> руб</td>
                <td class="value_cart">
                    <div>
                        <input type="text" class="value_cart_text" value="<?php echo $value['count_cart'] ?>" readonly>
                        <span class="minus_cart">-</span>
                        <span class="plus_cart">+</span>
                    </div>
                </td>
                <td class="rez_price_cart rez_one"><?php
                    $sum += $value['price'] * $value['count_cart'];
                    echo number_format($value['price'] * $value['count_cart'], 0, '', ' '); ?> руб
                </td>
            </tr>
        <?php endforeach; ?>
        <tr class="cart_prod_footer">
            <td colspan="2" class="null_cart"></td>
            <td colspan="2" class="rez_title_cart">Итого, к оплате:</td>
            <td class="rez_price_cart rez_sum"><?php echo number_format($sum, 0, '', ' '); ?> руб</td>
        </tr>
    </table>
    </div>
    <div class="col-lg-12 btn_cart_wrap">
        <a href="#" class="btn_cart_im"><i class="glyphicon glyphicon-chevron-left"></i>Продолжить покупки</a>
        <a href="<?php echo Url::toRoute('page/checkout'); ?>" class="btn_cart_zakaz">Оформить заказ<i
                    class="glyphicon glyphicon-chevron-right"></i></a>
    </div>
<?php endif; ?>

<script>
    // Получаем ссылки на элементы DOM
    const valueInputs = document.querySelectorAll('.value_cart_text');
    const pluses = document.querySelectorAll('.plus_cart');
    const minuses = document.querySelectorAll('.minus_cart');
    const rez = document.querySelectorAll('.rez_one');
    const rez_all = document.querySelector('.rez_sum');
    var sum = <?php if (isset($sum))
        echo $sum;
    else
        echo 0?>;
    const prod = <?php echo json_encode($products);?>;

    pluses.forEach((btn, index) => {
        btn.addEventListener('click', function () {
            if (prod[index]['count'] >= parseInt(valueInputs[index].value) + 1) {
                valueInputs[index].value = parseInt(valueInputs[index].value) + 1;
                rez[index].textContent = (valueInputs[index].value * parseInt(prod[index]['price'])).toLocaleString().replace(/,/g, " ");
                rez[index].textContent += " руб";
                sum += parseInt(prod[index]['price']);
                rez_all.textContent = sum.toLocaleString().replace(/,/g, " ");
                rez_all.textContent += " руб";
            }
        });
    });

    minuses.forEach((btn, index) => {
        btn.addEventListener('click', function () {
            if (valueInputs[index].value > 0) {
                valueInputs[index].value = parseInt(valueInputs[index].value) - 1;
                rez[index].textContent = (valueInputs[index].value * parseInt(prod[index]['price'])).toLocaleString().replace(/,/g, " ");
                rez[index].textContent += " руб";
                sum -= parseInt(prod[index]['price']);
                rez_all.textContent = sum.toLocaleString().replace(/,/g, " ");
                rez_all.textContent += " руб";
            }
        });
    });
</script>

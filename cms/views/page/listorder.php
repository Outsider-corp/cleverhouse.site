<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = "Заказы";
?>

<table class="table table-bordered">
    <tr class="cart_prod_head">
        <td class="img_cart">Номер заказа</td>
        <td class="img_cart">Дата</td>
        <td class="title_cart">Состав</td>
        <td class="price_cart">Стоимость</td>
    </tr>
    <?php foreach ($orders as $orderId => $order): ?>
        <tr class="cart_prod_content">
            <td class="img_cart" style="text-align: center; vertical-align: middle;"><?= $orderId; ?></td>
            <td class="img_cart" style="vertical-align: middle;"><?= $order['date']; ?></td>
            <td class="title_cart" style="vertical-align: middle;">
                <ul>
                    <?php foreach ($order as $item) {
                        if (isset($item['name_product'])) {
                            ?>
                            <li><?= $item['name_product'] . ' (x' . $item['count'] . ')'; ?></li>
                        <?php }
                    } ?>
                </ul>
            </td>
            <td class="rez_price_cart" style="vertical-align: middle;"><?php echo number_format($order['sum'], 0, '', ' '); ?> руб</td>
        </tr>
    <?php endforeach; ?>
</table>
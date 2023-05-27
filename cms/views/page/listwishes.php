<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = "Список желаний";

$this->registerMetaTag(['name' => 'keywords', 'content' => 'техника, умный дом, интернет вещей']);
$this->registerMetaTag(['name' => 'description', 'content' => 'системы умного дома']);

?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php if ($count_products == 0): ?>
        <div class="value_prod" style="text-align: center;">
            <h1>Список желаний пуст</h1>
        </div>
    <?php else: ?>
        <div class="value_prod" style="text-align: center;">
            <h1>Список желаний</h1>
        </div>
        <?php foreach ($products_array as $product_array): ?>

            <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12">
                <div class="product">
                    <a href="<?= Url::toRoute(['page/product', 'id' => $product_array['id']]); ?>"
                       class="product_img">
                        <?php if ($product_array['price_old'] != ""): ?>
                            <span>-<?php echo 100 - intval($product_array['price'] * 100 / $product_array['price_old']); ?>%</span>
                        <?php endif ?>
                        <img src="images/<?= $product_array['img_product']; ?>">
                    </a>
                    <div class="desc">
                        <a href="<?= Url::toRoute(['page/product', 'id' => $product_array['id']]); ?>"
                           class="product_title"><?= $product_array['name_product']; ?></a>
                        <div class="product_price">
                                <span class="price"><?=
                                    number_format($product_array['price'], 0, '',
                                        ' ') ?> руб</span>
                            <?php if ($product_array['price_old'] != ""): ?>
                                <span class="price_old"><?=
                                    number_format($product_array['price_old'], 0, '', ' ') ?> руб</span>
                            <?php endif; ?>
                        </div>
                        <div class="product_btn">
                            <?php if ($product_array['count'] == 0): ?>
                                <a class="cart disabled"><i class="glyphicon glyphicon-shopping-cart disabled"></i></a>
                            <?php else: ?>
                                <a href="<?= Url::toRoute(['page/cart', 'id' => $product_array['id']]); ?>"
                                   class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                            <?php endif; ?>
                            <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array['id'], 'action'=>'del']); ?>"
                               class="mylist">Уже в списке желаний</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endforeach; endif; ?>
</div>

<div class="row pagination">

    <?php
    if (isset($_GET['number']))
        $number = $_GET['number'];
    if (isset($_GET['str']))
        $str = $_GET['str'];
    if (isset($count_pages) && $count_pages > 1) {
    ?>
    <ul>
        <?php
        for ($i = 1; $i <= $count_pages; $i++) {
            if ((!isset($_GET['page']) && $i == 1) || (isset($_GET['page']) && $_GET['page'] == $i)) {
                ?>
                <li class="active"><span><?php echo $i;
                        ?></span></li>
            <?php } else {
                if (isset($_GET['view']) && $_GET['view'] == 1) {
                    ?>
                    <li><a href="
        <?= Url::toRoute(['page/search', 'page' => $i, 'view' => 1, 'number' => $number, 'str' => $str,
                            'search_text' => $search_text, 'price_from' => $price_from,
                            'price_to' => $price_to, 'value' => $value]);
                        ?>">
                            <?php echo $i;
                            ?></a></li>
                <?php } else {
                    ?>
                    <li><a href="
        <?= Url::toRoute(['page/search', 'page' => $i, 'number' => $number, 'str' => $str, 'search_text' => $search_text,
                            'price_from' => $price_from, 'price_to' => $price_to, 'value' => $value]);
                        ?>">
                            <?php echo $i;
                            ?></a></li>
                <?php }
            }
        }
        ?>
    </ul>
    <?php
    }
    ?>
</div>
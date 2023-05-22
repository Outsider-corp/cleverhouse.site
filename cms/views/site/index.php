<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Умный дом';
?>

<div class="container-fluid tabs_block_main">
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Хиты</a></li>
                <li><a href="#tab2" data-toggle="tab">Новинки</a></li>
                <li><a href="#tab3" data-toggle="tab">Акции</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1">
                    <?php for ($x = count($product_array)-1; $x >= count($product_array)-3; $x--) {
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <div class="product">
                                <a href="<?= Url::toRoute(['page/product', 'id' => $product_array[$i]['id']]); ?>"
                                   class="product_img">
                                    <?php if ($product_array[$i]['price_old'] != ""): ?>
                                        <span>-<?php echo 100 - intval($product_array[$i]['price'] * 100 / $product_array[$i]['price_old']); ?>%</span>
                                    <?php endif ?>
                                    <img src="images/<?= $product_array[$i]['img_product']; ?>">
                                </a>
                                <div class="desc">
                                    <a href="<?= Url::toRoute(['page/product', 'id' => $product_array[$i]['id']]); ?>"
                                       class="product_title"><?= $product_array[$i]['name_product']; ?></a>
                                    <div class="product_price">
                                <span class="price"><?=
                                    number_format($product_array[$i]['price'], 0, '',
                                        ' ') ?> руб</span>
                                        <?php if ($product_array[$i]['price_old'] != ""): ?>
                                            <span class="price_old"><?=
                                                number_format($product_array[$i]['price_old'], 0, '', ' ') ?> руб</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product_btn">
                                        <?php if ($product_array[$i]['count'] == 0): ?>
                                            <a class="cart disabled"><i
                                                        class="glyphicon glyphicon-shopping-cart disabled"></i></a>
                                        <?php else: ?>
                                            <a href="<?= Url::toRoute(['page/cart', 'id' => $product_array[$i]['id']]); ?>"
                                               class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                                        <?php endif; ?>
                                        <a href="<?= Url::toRoute(['page/listorder', 'id' => $product_array[$i]['id']]); ?>"
                                           class="mylist">Список желаний</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
                <div class="tab-pane fade" id="tab2">
                    <?php for ($i = count($product_array)-1; $i >= count($product_array)-3; $i--) {?>
                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <div class="product">
                                <a href="<?= Url::toRoute(['page/product', 'id' => $product_array[$i]['id']]); ?>"
                                   class="product_img">
                                    <?php if ($product_array[$i]['price_old'] != ""): ?>
                                        <span>-<?php echo 100 - intval($product_array[$i]['price'] * 100 / $product_array[$i]['price_old']); ?>%</span>
                                    <?php endif ?>
                                    <img src="images/<?= $product_array[$i]['img_product']; ?>">
                                </a>
                                <div class="desc">
                                    <a href="<?= Url::toRoute(['page/product', 'id' => $product_array[$i]['id']]); ?>"
                                       class="product_title"><?= $product_array[$i]['name_product']; ?></a>
                                    <div class="product_price">
                                <span class="price"><?=
                                    number_format($product_array[$i]['price'], 0, '',
                                        ' ') ?> руб</span>
                                        <?php if ($product_array[$i]['price_old'] != ""): ?>
                                            <span class="price_old"><?=
                                                number_format($product_array[$i]['price_old'], 0, '', ' ') ?> руб</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product_btn">
                                        <?php if ($product_array[$i]['count'] == 0): ?>
                                            <a class="cart disabled"><i
                                                        class="glyphicon glyphicon-shopping-cart disabled"></i></a>
                                        <?php else: ?>
                                            <a href="<?= Url::toRoute(['page/cart', 'id' => $product_array[$i]['id']]); ?>"
                                               class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                                        <?php endif; ?>
                                        <a href="<?= Url::toRoute(['page/listorder', 'id' => $product_array[$i]['id']]); ?>"
                                           class="mylist">Список желаний</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
                <div class="tab-pane fade" id="tab3">
                    <?php for ($i = count($product_array)-1; $i >= count($product_array)-3; $i--) {?>
                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <div class="product">
                                <a href="<?= Url::toRoute(['page/product', 'id' => $product_array[$i]['id']]); ?>"
                                   class="product_img">
                                    <?php if ($product_array[$i]['price_old'] != ""): ?>
                                        <span>-<?php echo 100 - intval($product_array[$i]['price'] * 100 / $product_array[$i]['price_old']); ?>%</span>
                                    <?php endif ?>
                                    <img src="images/<?= $product_array[$i]['img_product']; ?>">
                                </a>
                                <div class="desc">
                                    <a href="<?= Url::toRoute(['page/product', 'id' => $product_array[$i]['id']]); ?>"
                                       class="product_title"><?= $product_array[$i]['name_product']; ?></a>
                                    <div class="product_price">
                                <span class="price"><?=
                                    number_format($product_array[$i]['price'], 0, '',
                                        ' ') ?> руб</span>
                                        <?php if ($product_array[$i]['price_old'] != ""): ?>
                                            <span class="price_old"><?=
                                                number_format($product_array[$i]['price_old'], 0, '', ' ') ?> руб</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product_btn">
                                        <?php if ($product_array[$i]['count'] == 0): ?>
                                            <a class="cart disabled"><i
                                                        class="glyphicon glyphicon-shopping-cart disabled"></i></a>
                                        <?php else: ?>
                                            <a href="<?= Url::toRoute(['page/cart', 'id' => $product_array[$i]['id']]); ?>"
                                               class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                                        <?php endif; ?>
                                        <a href="<?= Url::toRoute(['page/listorder', 'id' => $product_array[$i]['id']]); ?>"
                                           class="mylist">Список желаний</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>
</div>
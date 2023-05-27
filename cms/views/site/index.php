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
                    <?php
                    if (count($product_array) > 3) {
                        $product_array_small = [];
                        $keys = array_rand($product_array, 3);
                        foreach ($keys as $key) {
                            $product_array_small[] = $product_array[$key];
                        }
                    } else {
                        $product_array_small = $product_array;
                    }
                    for ($i = 0; $i < count($product_array_small); $i++) {
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="product">
                                <a href="<?= Url::toRoute(['page/product', 'id' => $product_array_small[$i]['id']]); ?>"
                                   class="product_img">
                                    <?php if ($product_array_small[$i]['price_old'] != ""): ?>
                                        <span>-<?php echo 100 - intval($product_array_small[$i]['price'] * 100 / $product_array_small[$i]['price_old']); ?>%</span>
                                    <?php endif ?>
                                    <img src="images/<?= $product_array_small[$i]['img_product']; ?>">
                                </a>
                                <div class="desc">
                                    <a href="<?= Url::toRoute(['page/product', 'id' => $product_array_small[$i]['id']]); ?>"
                                       class="product_title"><?= $product_array_small[$i]['name_product']; ?></a>
                                    <div class="product_price">
                                <span class="price"><?=
                                    number_format($product_array_small[$i]['price'], 0, '',
                                        ' ') ?> руб</span>
                                        <?php if ($product_array_small[$i]['price_old'] != ""): ?>
                                            <span class="price_old"><?=
                                                number_format($product_array_small[$i]['price_old'], 0, '', ' ') ?> руб</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!Yii::$app->user->isGuest): ?>
                                        <div class="product_btn">
                                            <?php if ($product_array_small[$i]['count'] == 0): ?>
                                                <a class="cart disabled"><i
                                                            class="glyphicon glyphicon-shopping-cart disabled"></i></a>
                                            <?php else: ?>
                                                <a href="<?= Url::toRoute(['page/cart', 'id' => $product_array_small[$i]['id']]); ?>"
                                                   class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                                            <?php endif;
                                            if ($product_array_small[$i]['wishlist'] > 0):?>
                                                <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array_small[$i]['id'], 'action' => 'del']); ?>"
                                                   class="mylist">Уже в списке желаний</a>
                                            <?php else: ?>
                                                <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array_small[$i]['id'], 'action' => 'add']); ?>"
                                                   class="mylist">В список желаний</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade" id="tab2">
                    <?php for ($x = 0; $x <= 2; $x++) {
                        if (count($product_array) - 1 - $x >= 0):
                            $i = count($product_array) - 1 - $x;
                        else:
                            break;
                        endif;
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
                                    <?php if (!Yii::$app->user->isGuest): ?>
                                        <div class="product_btn">
                                            <?php if ($product_array[$i]['count'] == 0): ?>
                                                <a class="cart disabled"><i
                                                            class="glyphicon glyphicon-shopping-cart disabled"></i></a>
                                            <?php else: ?>
                                                <a href="<?= Url::toRoute(['page/cart', 'id' => $product_array[$i]['id']]); ?>"
                                                   class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                                            <?php endif;
                                            if ($product_array[$i]['wishlist'] > 0):?>
                                                <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array[$i]['id'], 'action' => 'del']); ?>"
                                                   class="mylist">Уже в списке желаний</a>
                                            <?php else: ?>
                                                <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array[$i]['id'], 'action' => 'add']); ?>"
                                                   class="mylist">В список желаний</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade" id="tab3">
                    <?php $n = 0;
                    for ($x = 0; $x <= count($product_array); $x++) {
                        if ($n > 2) break;
                        if (count($product_array) - 1 - $x >= 0):
                            $i = count($product_array) - 1 - $x;
                            if (!isset($product_array[$i]['price_old'])) continue;
                            $n++;
                        else:
                            break;
                        endif;
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
                                    <?php if (!Yii::$app->user->isGuest): ?>
                                        <div class="product_btn">
                                            <?php if ($product_array[$i]['count'] == 0): ?>
                                                <a class="cart disabled"><i
                                                            class="glyphicon glyphicon-shopping-cart disabled"></i></a>
                                            <?php else: ?>
                                                <a href="<?= Url::toRoute(['page/cart', 'id' => $product_array[$i]['id']]); ?>"
                                                   class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                                            <?php endif;
                                            if ($product_array[$i]['wishlist'] > 0):?>
                                                <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array[$i]['id'], 'action' => 'del']); ?>"
                                                   class="mylist">Уже в списке желаний</a>
                                            <?php else: ?>
                                                <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array[$i]['id'], 'action' => 'add']); ?>"
                                                   class="mylist">В список желаний</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
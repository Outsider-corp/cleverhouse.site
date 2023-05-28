<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Карточка товара';
?>

<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
    <div class="img_prod">
        <img src="images/<?php echo $product_array['img_product']; ?>">
    </div>
</div>

<div class="col-lg-5 col-md-8 col-sm-7 col-xs-12">
    <div class="content_prod">
        <h1><?php echo $product_array['name_product']; ?></h1>
        <p><span>Артикул:</span> <?php echo $product_array['code']; ?></p>

        <?php
        if ($product_array['count'] > 0):
            ?>
            <p>В наличии: <strong class="count_prod"><?php echo $product_array['count']; ?></strong></p>
        <?php
        else:
            ?>
            <p>Нет в наличии</p>
        <?php
        endif;
        ?>
        <p><?php echo $product_array['description']; ?></p>
    </div>
</div>

<div class="col-lg-3 col-md-8 col-sm-7 col-sm-offset--5 col-xs-12 order_prod">
    <h2>Цена</h2>
    <p class="price_prod"><?php echo number_format($product_array['price'],
            0, '', ' '); ?> руб</p>
    <?php
    if (!empty($product_array['price_old'])):
        ?>
        <p class="price_old_prod"><?php echo number_format($product_array['price_old'],
                0, '', ' '); ?> руб</p>
    <?php
    endif; ?>
    <div><a href="<?= Url::toRoute(['page/addproduct', 'id' => $product_array['id']]);
        ?>" class="mylist">Изменить</a>
    </div>
</div>

<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
    <div class="h_prod">
        <?php if (count($product_array['chars'])): ?>
            <h3>Характеристики:</h3>
        <? endif; ?>
        <table class="table table-striped table-bordered">
            <?php foreach ($product_array['chars'] as $char): ?>
                <tr>
                    <td><?= $char['name_сharacteristic']; ?></td>
                    <td><?= $char['description_сharacteristic']; ?></td>
                    <td><a href="<?= Url::toRoute(['page/addcharacteristic', 'id' => $char['id_сharacteristic']]); ?>">Изменить</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="<?= Url::toRoute(['page/addcharacteristic', 'product' => $product_array['id']]);
        ?>" class="mylist">Добавить атрибут</a>
    </div>
</div>

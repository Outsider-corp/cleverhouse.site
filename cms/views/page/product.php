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
    endif;
    $class = "";
    $count = 1;
    if (!Yii::$app->user->isGuest):
    if ($product_array['count'] > 0):
    ?>
    <p>Количество:</p>
    <?php
    $form = ActiveForm::begin(['action' => ['page/product', 'id' => $product_array['id']]]);

    // Поле ввода
    echo $form->field($model, 'value')->textInput(['class' => 'input_text', 'value' => 1])->label(false);?>

    <button type="button" class="minus">-</button>
    <button type="button" class="plus">+</button>
<!--    --><?// echo Html::submitButton('<a class="add_cart_prod">
//<i class="glyphicon glyphicon-shopping-cart add_cart_prod"></i> В корзину</a>',
//        ['name' => 'submit']); ?>

    <?= Html::a('<i class="glyphicon glyphicon-shopping-cart"></i>В корзину',
        '#', ['class' => 'add_cart_prod', 'onclick' => '$("#form").yiiActiveForm("validate", true);
             if ($("#form").yiiActiveForm("validated")) $("#form").submit(); return false;']); ?>
    <?php // Закрытие формы
    ActiveForm::end(); ?>
<!--    <form class="form_count_prod">-->
<!--        <input type="text" name="" value="1" class="input_text">-->
<!--        <button type="button" class="minus">-</button>-->
<!--        <button type="button" class="plus">+</button>-->
<!--    </form>-->
    <div><a href="<?= Url::toRoute(['page/cart', 'id' => $product_array['id'], 'count' => $count]); ?>"
            class="add_cart_prod"><i
                    class="glyphicon glyphicon-shopping-cart"></i> В корзину</a>
        <?php else: ?>
            <p>Нет в наличии</p>
            <a class="add_cart_prod disabled"><i class="glyphicon glyphicon-shopping-cart"></i> В корзину</a>
        <?php
        endif;
        if ($product_array['wishlist'] > 0):?>
            <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array['id'], 'action' => 'del']); ?>"
               class="mylist">Уже в списке желаний</a>
        <?php else: ?>
            <a href="<?= Url::toRoute(['page/listwishes', 'id' => $product_array['id'], 'action' => 'add']); ?>"
               class="mylist">В список желаний</a>
        <?php endif;
        endif; ?>
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
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
    <div class="r_prod">
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="reviews_form">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p>Оставьте свой отзыв:</p>
                </div>
                <?php $form = ActiveForm::begin(['enableClientValidation' => false,
                    'options' => ['autocomplete' => 'off']]); ?>
                <div class="col-lg-12 reviews_rating">
                    <i class="glyphicon glyphicon-star star" data-value="1"></i>
                    <i class="glyphicon glyphicon-star star" data-value="2"></i>
                    <i class="glyphicon glyphicon-star star" data-value="3"></i>
                    <i class="glyphicon glyphicon-star star" data-value="4"></i>
                    <i class="glyphicon glyphicon-star star" data-value="5"></i>
                </div>
                <div class="col-lg-12">
                    <?= $form->field($reviewModel, 'rating')->hiddenInput(['id' => 'rating-input'])->label(false); ?>
                    <?= $form->field($reviewModel, 'text')->textarea(['placeholder' => 'Отзыв', 'rows' => 4])->label(false); ?>
                </div>
                <?= Html::submitButton('Оставить отзыв', ['class' => 'btn btn-primary']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        <?php endif; ?>
        <h3>Отзывы:</h3>
        <div class="reviews">
            <?php
            if (count($product_array['reviews']) == 0): ?>
                <h3 style="text-align: center;">Отзывов пока что нет</h3>
            <?php else:
                foreach ($product_array['reviews'] as $review): ?>
                    <div class="reviews_contant">
                        <p class="reviews_title"><?= $review['name_user']; ?> <span><?= $review['date']; ?></span></p>
                        <div class="reviews_rating">
                            <?php if (isset($review['rating'])): ?>
                                <?php for ($i = 0; $i < $review['rating']; $i++) { ?>
                                    <i class="glyphicon glyphicon-star active"></i>
                                <?php }
                                for ($i = 0; $i < 5 - $review['rating']; $i++) { ?>
                                    <i class="glyphicon glyphicon-star no_active"></i>
                                <?php } endif; ?>
                        </div>
                        <p class="reviews_text"><?= $review['text_review']; ?></p>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var stars = document.querySelectorAll('.reviews_rating .star');
        stars.forEach(function (star) {
            star.addEventListener('click', function () {
                var value = this.dataset.value;
                stars.forEach(function (star) {
                    if (star.dataset.value <= value) {
                        star.classList.add('active');
                    } else {
                        star.classList.remove('active');
                    }
                });
                this.classList.add('active');
                document.getElementById('rating-input').value = value;
            });
        });
    });
</script>
<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Карточка товара';
?>

<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
    <div class="img_prod">
        <img src="images/<?php echo $product_array['img'];?>">
    </div>
</div>

<div class="col-lg-5 col-md-8 col-sm-7 col-xs-12">
    <div class="content_prod">
        <h1><?php echo $product_array['name'];?></h1>
        <p><span>Артикул:</span> <?php echo $product_array['code'];?></p>

        <?php
            if($product_array['count'] > 0):
        ?>
            <p>В наличии <strong class="count_prod"><?php echo $product_array['count'];?></strong></p>
        <?php
            else:
        ?>
                <p>Нет в наличии</p>
        <?php
            endif;
        ?>
        <p><?php echo $product_array['description'];?></p>
    </div>
</div>

<div class="col-lg-3 col-md-8 col-sm-7 col-sm-offset--5 col-xs-12">
    <div class="order_prod">
        <p class="price_prod"><?php echo $product_array['price'];?> руб</p>

        <?php
            if(!empty($product_array['price_old'])):
        ?>
            <p class="price_old_prod"><?php echo $product_array['price_old'];?> руб</p>
        <?php
            endif;
        ?>

        <?php
            $class = "";
            if($product_array['count'] > 0):
        ?>
        <p>Количество:</p>
        <form class="form_count_prod">
            <input type="text" name="" value="1" class="input_text">
            <button type="button" class="minus">-</button>
            <button type="button" class="plus">+</button>
        </form>
        <?php
            else:
            $class = "disabled";
        ?>
            <p>Нет в наличии</p>
        <?php
            endif;
        ?>
        <a href="<?=Url::toRoute('page/cart');?>" class="add_cart_prod <?php echo $class;?>"><i class="glyphicon glyphicon-shopping-cart"></i> В корзину</a>
        <a href="#" class="add_mylist_prod <?php echo $class;?>"><i class="glyphicon glyphicon-heart"></i>В список желаний</a>
    </div>
</div>

<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
    <div class="h_prod">
        <h3>Характеристики:</h3>
        <table class="table table-striped table-bordered">
            <tr>
                <td>Объём, л</td>
                <td>40</td>
            </tr>
            <tr>
                <td>Вес, кг</td>
                <td>1,2</td>
            </tr>
            <tr>
                <td>Высота, см</td>
                <td>50</td>
            </tr>
        </table>

    </div>
    <div class="r_prod">
        <h3>Отзывы:</h3>
        <div class="reviews">
            <div class="reviews_img">
                <img src="images/avatar.png">
            </div>
            <div class="reviews_contant">
                <p class="reviews_title">Иван <span>9.06.2017</span></p>
                <div class="reviews_rating">
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star no_active"></i>
                </div>
                <p class="reviews_text">Хороший рюкзак, рекомендую</p>
            </div>
        </div>
        <div class="reviews">
            <div class="reviews_img">
                <img src="images/avatar.png">
            </div>
            <div class="reviews_contant">
                <p class="reviews_title">Иван <span>9.06.2017</span></p>
                <div class="reviews_rating">
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star active"></i>
                    <i class="glyphicon glyphicon-star no_active"></i>
                </div>
                <p class="reviews_text">Хороший рюкзак, рекомендую</p>
            </div>
        </div>
        <div class="reviews_form">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p>Отзыв о товаре:</p>
            </div>
            <form action="/" method="post">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="name" placeholder="Имя">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="email" placeholder="E-mail">
                </div>
                <div class="col-lg-12">
                    <textarea name="text" placeholder="Отзыв"></textarea>
                </div>
                <div class="col-lg-12">
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                </div>
                <div class="col-lg-12">
                    <button>Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

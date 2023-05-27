<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = "Панель администратора | " . $categories['name_category'];

?>
<div class="row content">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header_list_prod">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <h1><?php echo $categories['name_category'] ?></h1>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 value_prod">
                <a class="admin" href="<?= Url::toRoute(['page/addproduct']); ?>">Добавить товар</a>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 sortirovka_and_number_prod">
                <?php $form = ActiveForm::begin(['action' => ['page/admin_listproducts', 'id' => $categories['id']]]); ?>
                <p><strong>Сортировка по:</strong><?= $form->field($model, 'str')->dropDownList([
                        '0' => 'Цене, по возрастанию',
                        '1' => 'Цене, по убыванию',
                        '2' => 'Названию товара, от А до Я',
                        '3' => 'Названию товара, от Я до А'],
                        $params = [
                            'prompt' => '--',
                            'options' => [$str => ["Selected" => true]],
                        ]
                    ); ?></p>
                <p><strong>Показать:</strong>
                    <?= $form->field($model, 'number')->dropDownList(['3' => '3', '12' => '12', '24' => '24', '48' => '48'], $params = [
                        'options' => [$number => ['Selected' => true]],
                    ]
                    ); ?></p>
                <?= Html::submitButton('Go'); ?>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

    <?php

    foreach ($products_array as $product_array): ?>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
                        <a href="<?= Url::toRoute(['page/addproduct', 'id' => $product_array['id']]);
                        ?>" class="mylist">Изменить</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

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
            <?php } else { ?>
                <li><a href="
        <?= Url::toRoute(['page/admin_listproducts', 'id' => $id, 'page' => $i, 'number' => $number, 'str' => $str]);
                    ?>">
                        <?php echo $i;
                        ?></a></li>
            <?php }
        }
        }
        ?>
    </ul>
</div>

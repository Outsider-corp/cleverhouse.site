<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = "Интеренет-магазин";

$this->registerMetaTag(['name' => 'keywords', 'content' => 'техника, умный дом, интернет вещей']);
$this->registerMetaTag(['name' => 'description', 'content' => 'системы умного дома']);

?>

<div class="col-lg-3 col-md-3 col-sm-5 col-xs-12 filter">
    <h3>Фильтры</h3>
    <?php $form = ActiveForm::begin(['action' => ['page/search', 'view' => $view, 'search_text' => $search_text]]); ?>
    <div class="form-group">
        <label class="control-label">Цена / руб</label>
        <div class="input-group">
            <?= $form->field($filterModel, 'price_from')->textInput(['type' => 'text', 'class' => 'form-control',
                'value' => $price_from])->label(false) ?>
            <span class="input-group-addon">-</span>
            <?= $form->field($filterModel, 'price_to')->textInput(['type' => 'text', 'class' => 'form-control',
                'value' => $price_to])->label(false) ?>
        </div>
    </div>
    <?= $form->field($filterModel, 'volume')->label('Объем / л')->checkboxList(['10' => '10', '20' => '20', '30' => '30']) ?>
    <?= Html::submitButton('Подобрать', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
    <?php ActiveForm::end(); ?>
</div>

<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

    <div class="row content">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header_list_prod">
            <div class="row">
                <div class="value_prod" style="text-align: center;">
                    <h1>Найдено товаров, содержащих "<?php echo $search_text; ?>": <?= $count_products; ?></h1>
                </div>
            </div>
        </div>
        <?php if ($count_products != 0){ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 sortirovka_and_number_prod">

                    <?php $form = ActiveForm::begin(['action' => ['page/search', 'view' => $view,
                        'search_text' => $search_text, 'price_from' => $price_from, 'price_to' => $price_to,
                        'value'=>$value]]); ?>
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
                <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs view_list_prod">
                    <p><strong>Вид:</strong>
                        <?php
                        $class1 = "";
                        $class2 = "";
                        if ($view == 1)
                            $class2 = "active";
                        else
                            $class1 = "active";
                        ?>

                        <a href="
        <?= Url::toRoute(['page/search', 'str' => $str, 'number' => $number, 'search_text' => $search_text,
                            'price_from' => $price_from, 'price_to' => $price_to, 'value'=>$value]); ?>"
                           class="
        <?= $class1; ?>"><i class="glyphicon glyphicon-th"></i><span>Сетка</span></a>
                        <a href="
        <?= Url::toRoute(['page/search', 'view' => '1', 'str' => $str, 'number' => $number, 'search_text' => $search_text,
                            'price_from' => $price_from, 'price_to' => $price_to, 'value'=>$value]); ?>"
                           class="
        <?= $class2; ?>"><i class="glyphicon glyphicon-th-list"></i><span>Список</span></a>

                    </p>
                </div>
            </div>
        </div>

        <?php

        foreach ($products_array as $product_array): ?>

            <?php if ($view == 1):
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 view_list">
                    <div class="product">
                        <a href="<?= Url::toRoute(['page/product', 'id' => $product_array['id']]);
                        ?>" class="product_img">
                            <?php if ($product_array['price_old'] != ""):
                                ?>
                                <span>-<?php echo 100 - intval($product_array['price'] * 100 / $product_array['price_old']);
                                    ?>%</span>
                            <?php endif
                            ?>
                            <img src="images/<?= $product_array['img_product'];
                            ?>">
                        </a>
                        <div class="desc">
                            <a href="
                    <?= Url::toRoute(['page/product', 'id' => $product_array['id']]);
                            ?>" class="product_title"><?= $product_array['name_product'];
                                ?></a>
                            <div class="product_price">
                                            <span class="price"><?= number_format($product_array['price'], 0, '', ' ')
                                                ?> руб</span>
                                <?php if ($product_array['price_old'] != ""):
                                    ?>
                                    <span class="price_old"><?= number_format($product_array['price_old'], 0, '', ' ')
                                        ?> руб</span>
                                <?php endif;
                                ?>
                            </div>

                            <div class="desc_prod">
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

                            <div class="product_btn">
                                <a href="
                    <?= Url::toRoute(['page/cart', 'id' => $product_array['id']]);
                                ?>" class="cart"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                                <a href="
                    <?= Url::toRoute(['page/listorder', 'id' => $product_array['id']]);
                                ?>" class="mylist">Список желаний</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else:
                ?>

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
                                <a href="<?= Url::toRoute(['page/listorder', 'id' => $product_array['id']]); ?>"
                                   class="mylist">Список желаний</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;
        endforeach; ?>
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
                                    'price_to' => $price_to, 'value'=>$value]);
                                ?>">
                                    <?php echo $i;
                                    ?></a></li>
                        <?php } else {
                            ?>
                            <li><a href="
        <?= Url::toRoute(['page/search', 'page' => $i, 'number' => $number, 'str' => $str, 'search_text' => $search_text,
                                    'price_from' => $price_from, 'price_to' => $price_to, 'value'=>$value]);
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
        }
        ?>
    </div>
</div>
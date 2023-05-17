<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = "Каталог";

$this->registerMetaTag(['name'=> 'keywords', 'content' => 'снаряжение, туризм, рюкзаки']);
$this->registerMetaTag(['name'=> 'description', 'content' => 'снаряжение для туризма']);

?>

<div class="col-lg-3 col-md-3 col-sm-5 col-xs-12 left_banner_menu">
   Баннерное меню
</div>


<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 catalog">

    <div class="row content">
        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12 catalog_category">
            <a href="<?=Url::toRoute('page/listproducts');?>"><img src="images/prod1.jpg"></a>
                <a href="<?= Url::toRoute('page/listproducts');?>">Бытовая техника</a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12 catalog_category">
            <a href="<?=Url::toRoute('page/listproducts');?>"><img src="images/prod1.jpg"></a>
                <a href="<?=Url::toRoute('page/listproducts');?>">Охранные системы</a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12 catalog_category">
            <a href="<?=Url::toRoute('page/listproducts');?>"><img src="images/prod1.jpg"></a>
                <a href="<?=Url::toRoute('page/listproducts');?>">Гаджеты</a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12 catalog_category">
            <a href="<?=Url::toRoute('page/listproducts');?>"><img src="images/prod1.jpg"></a>
                <a href="<?=Url::toRoute('page/listproducts');?>">Освещение</a>
        </div>

<!--        --><?php
//
//        foreach ($products_array as $product_array):?>
<!---->
<!--            --><?php //if($view == 1):?>
<!--                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 catalog_category">-->
<!--                    <div class="product">-->
<!--                        <a href="--><?php //=Url::toRoute(['page/product', 'id' => $product_array['id']]);?><!--" class="product_img">-->
<!--                            <img src="images/--><?php //=$product_array['img'];?><!--">-->
<!--                        </a>-->
<!--                        <div class="desc">-->
<!--                            <a href="--><?php //=Url::toRoute(['page/product', 'id' => $product_array['id']]);?><!--" class="product_title">--><?php //=$product_array['name'];?><!--</a>-->
<!--                            <div class="product_price">-->
<!--                                <span class="price">--><?php //=$product_array['price']?><!-- руб</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            --><?php //else:?>
<!---->
<!--                <div class="col-lg-4 col-md-6 col-sm-4 col-xs-12">-->
<!--                    <div class="product">-->
<!--                        <a href="--><?php //=Url::toRoute(['page/product', 'id' => $product_array['id']]);?><!--" class="product_img">-->
<!--                            <img src="images/--><?php //=$product_array['img'];?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endif;?>
<!--        --><?php //endforeach;?>

    </div>

    <div class="row pagination">

        <?php
        if(isset($count_pages) && $count_pages > 1) {
            ?>
            <ul>
                <?php
                for($i = 1; $i <= $count_pages; $i++) {
                    ?>
                    <?php
                    if((!isset($_GET['page']) && $i == 1) || $_GET['page'] == $i){?>

                        <li class="active"><span><?php echo $i;?></span></li>
                    <?php }else{?>

                        <?php if(isset($_GET['view']) && $_GET['view'] == 1){?>
                            <li><a href="<?=Url::toRoute(['page/listproducts', 'id' => $id, 'page' => $i, 'view' => 1]);?>"><?php echo $i;?></a></li>
                        <?php }else{?>
                            <li><a href="<?=Url::toRoute(['page/listproducts', 'id' => $id, 'page' => $i]);?>"><?php echo $i;?></a></li>

                        <?php }?>

                    <?php }?>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>
    </div>
</div>


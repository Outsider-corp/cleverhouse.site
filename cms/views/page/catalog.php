<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = "Каталог";

$this->registerMetaTag(['name' => 'keywords', 'content' => 'снаряжение, туризм, рюкзаки']);
$this->registerMetaTag(['name' => 'description', 'content' => 'снаряжение для туризма']);

?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 catalog">
    <div class="row content">
        <?php
        foreach ($categories as $category): ?>
            <div class="col-lg-3 col-md-6 col-sm-3 col-xs-12 catalog_category">
                <a href="<?= Url::toRoute(['page/listproducts', 'id' => $category['id']]); ?>"><img
                            src="images/<?php echo $category['img_category']; ?>"></a>
                <a href="<?= Url::toRoute(['page/listproducts', 'id' => $category['id']]); ?>"><?php echo $category['name_category']; ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


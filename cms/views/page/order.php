<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = "Заказ оформлен";

?>
<?php if (isset($e)):?>
<h2>Произошла непредвиденная ошибка.</h2>
<?php else:?>
<h2>Ваш заказ успешно оформлен!</h2>
<h2>Номер заказа: <?= $order['id_order'];?></h2>
<?php endif;?>
<div class="col-lg-12 btn_cart_wrap">
    <a href="<?php echo Url::toRoute(['site/index']); ?>" class="btn_cart_zakaz">На главную</a>
</div>


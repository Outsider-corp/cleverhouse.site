<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Адрес";

$session = Yii::$app->session;
$session->open();
?>

    <div class="col-lg-12">
        <ul class="cart_status">
            <li><span><a href="<?= Url::toRoute('page/cart') ?>"> 1. Заказ</a></span></li>
            <li class="active"><span>2. Адрес</span></li>
            <?php if (isset($session['order_city'])): ?>
                <li><span><a href="<?= Url::toRoute('page/dostavka') ?>"> 3. Доставка</a></span></li>
            <?php
            else:?>
                <li><span>3. Доставка</span></li>
            <?php endif;
            if (isset($session['dostavka'])): ?>
                <li><span><a href="<?= Url::toRoute('page/checkout') ?>"> 4. Подтверждение</a></span></li>
            <?php else: ?>
                <li><span>4. Проверка</span></li>
            <?php endif; ?>
        </ul>
    </div>

<?php if (Yii::$app->user->isGuest): ?>
    <?php echo "Войдите в аккаунт, чтобы оформить заказ." ?>
<?php else:
    $form = ActiveForm::begin([
        'id' => 'form',
        'method' => 'post',]); ?>
    <?= $form->field($model, 'city')->textInput(['type' => 'text', 'value' => Yii::$app->user->identity->city_user]); ?>
    <?= $form->field($model, 'address')->textInput(['type' => 'text']); ?>
    <?= $form->field($model, 'region')->textInput(['type' => 'text', 'value' => Yii::$app->user->identity->region_user]); ?>
    <div class="col-lg-12 btn_cart_wrap">
        <a href="<?= Url::toRoute('page/cart') ?>" class="btn_cart_im"><i class="glyphicon glyphicon-chevron-left"></i>Вернуться
            к заказу</a>
        <?= Html::a('Далее <i class="glyphicon glyphicon-chevron-right"></i>',
            '#', ['class' => 'btn_cart_zakaz', 'onclick' => '$("#form").yiiActiveForm("validate", true);
             if ($("#form").yiiActiveForm("validated")) $("#form").submit(); return false;']); ?>

    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
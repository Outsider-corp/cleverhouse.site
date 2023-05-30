<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Добавление/изменение товара";
?>
<?php if (isset($product)){
$form = ActiveForm::begin(['action' => ['page/addproduct', 'id' => $product['id']]]); ?>
<?= $form->field($model, 'name_product')->textInput(['type' => 'text', 'value' => $product['name_product']]); ?>
<?= $form->field($model, 'price')->textInput(['type' => 'text', 'value' => $product['price']]); ?>
<?= $form->field($model, 'price_old')->textInput(['type' => 'text', 'value' => $product['price_old']]); ?>
<?= $form->field($model, 'count')->textInput(['type' => 'text', 'value' => $product['count']]); ?>
<?= $form->field($model, 'code')->textInput(['type' => 'text', 'value' => $product['code']]); ?>
<?= $form->field($model, 'description')->textarea(['rows' => 5, 'value' => $product['description_category']]); ?>
<?= $form->field($model, 'id_category')->dropDownList($categories, $params = ['prompt' => 'Выберите категорию',
    'options' => [$categories[$product['id_category']] => ['Selected' => true]],]); ?>
<?= $form->field($model, 'img_product')->textInput(['type' => 'text', 'value' => $product['img_product']]);}
else{
    $form = ActiveForm::begin(['action' => ['page/addproduct']]); ?>
    <?= $form->field($model, 'name_product')->textInput(['type' => 'text']); ?>
    <?= $form->field($model, 'price')->textInput(['type' => 'text']); ?>
    <?= $form->field($model, 'price_old')->textInput(['type' => 'text']); ?>
    <?= $form->field($model, 'count')->textInput(['type' => 'text']); ?>
    <?= $form->field($model, 'code')->textInput(['type' => 'text']); ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 5]); ?>
    <?= $form->field($model, 'id_category')->dropDownList($categories, $params = ['prompt' => 'Выберите категорию']); ?>
    <?= $form->field($model, 'img_product')->textInput(['type' => 'text']);
}?>
<?= Html::submitButton('Отправить запрос', ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end();
if (isset($product)):?><div>
<a href="<?= Url::toRoute(['page/deleteproduct', 'id'=>$product['id'], 'id_category'=>$product['id_category']]);
?>">Удалить товар</a></div>
<?php endif;?>
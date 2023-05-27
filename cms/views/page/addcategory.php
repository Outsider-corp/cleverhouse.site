<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = "Добавление/изменение категории";
?>
<?php
$form = ActiveForm::begin(['action' => ['page/addcategory', 'id' => $category['id']]]); ?>
    <?= $form->field($model, 'name')->textInput(['type' => 'text', 'value' => $category['name_category']]);?>
    <?= $form->field($model, 'img')->textInput(['type'=>'text', 'value'=>$category['img_category']]);?>
    <?= $form->field($model, 'description')->textarea(['rows'=>5, 'value'=>$category['description_category']]); ?>
    <?= Html::submitButton('Отправить запрос', ['class' => 'btn btn-success']); ?>
    <?php ActiveForm::end();
if (isset($category['id'])):?><div>
<a href="<?= Url::toRoute(['page/deletecategory', 'id'=>$category['id']]);
?>">Удалить товар</a></div>
<?php endif;?>

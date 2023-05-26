<?php

use yii\helpers\Url;

$this->title = "Личный кабинет";
?>

<h2>Информация об аккаунте</h2
<div>
    <ul class="list-info">
        <li><b>Логин:</b> <?= Yii::$app->user->identity->login_user ?></li>
        <li><b>E-mail:</b> <?= Yii::$app->user->identity->email_user ?></li>
        <li><b>Имя:</b> <?= Yii::$app->user->identity->name_user ?></li>
        <li><b>Телефон:</b><?= Yii::$app->user->identity->telephone_user ?></li>
        <li><b>Город:</b><?= Yii::$app->user->identity->city_user ?></li>
        <li><b>Почтовый индекс:</b><?= Yii::$app->user->identity->region_user ?></li>
    </ul>
</div>
<table class="table table-bordered" style="text-align: center;">
    <tr>
        <td><a href="<?= Url::toRoute('page/listorder') ?>">Заказы</a></td>
        <td><a href="<?= Url::toRoute('page/listwishes') ?>">Список желаний</a></td>
        <td><a href="<?= Url::toRoute('page/listreviews') ?>">Оставленные отзывы</a></td>
    </tr>
</table>

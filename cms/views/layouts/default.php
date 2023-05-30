<?php

/* @var $this \yii\web\View */
/* @var $content string */

/* @var $category string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\DefaultAsset;
use yii\helpers\Url;

DefaultAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<header>
    <div class="container">
        <div class="row header_top">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
            <div class="btn_top_wrap col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="btn_and_search">
                    <div class="btn_top">
                        <a href="<?= Url::toRoute('page/formcontact'); ?>"><i
                                    class="glyphicon glyphicon-map-marker"></i>Обратная связь</a>
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <a href="<?= Url::toRoute('page/lk'); ?>"><i class="glyphicon glyphicon-user"></i>Личный
                                кабинет (<?= Yii::$app->user->identity['login_user']; ?>)</a>
                            <a href="<?= Url::toRoute('site/logout'); ?>"><i
                                        class="glyphicon glyphicon-lock"></i>Выйти</a>
                        <?php else: ?>
                            <a href="<?= Url::toRoute('site/login'); ?>"><i
                                        class="glyphicon glyphicon-lock"></i>Войти</a>
                            <a href="<?= Url::toRoute('site/registration'); ?>"><i
                                        class="glyphicon glyphicon-lock"></i>Зарегистрироваться</a>
                        <?php endif; ?>
                    </div>
                    <div class="search_top">
                        <!-- Форма с текстовым полем и кнопкой отправки -->
                        <?= Html::beginForm(Url::to(['page/search']), 'get'); ?>
                        <?= Html::textInput('search_text', null, ['placeholder' => 'Поиск']); ?>
                        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['name' => 'submit_search']); ?>
                        <?= Html::endForm(); ?>
                    </div>
                </div>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="cart_top">
                        <?php echo \app\components\CartWidget::widget(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container-fluid menu_top">
        <div class="container">
            <div class="row">
                <?php

                NavBar::begin([
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => ' ',
                    ],
                ]);
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav'],
                    'items' => [
                        ['label' => 'Главная', 'url' => ['/site/index']],
                        ['label' => 'Каталог', 'url' => ['/page/catalog']],
                        ['label' => 'Контакты', 'url' => ['/page/contacts']],
                    ],
                ]);
                NavBar::end();

                ?>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-12 contant_wrap">
            <div class="navigation">
                <ul>
                    <li><a href="<?= Url::toRoute(['site/index']); ?>"><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="<?= Url::toRoute(['site/index']); ?>">Системы умного дома</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">


        <?= $content; ?>


    </div>
</div>

<div class="container-fluid write_email_and_sseti">
    <div class="container">
        <div class="row write_email_and_sseti_wrap">
            <div class="hidden-xs sseti_wrap">
                <div>
                    <a href="https://ru-ru.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="https://vk.com/" target="_blank"><i class="fa fa-vk"></i></a>
                    <a href="https://www.instagram.com/ " target="_blank"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid footer">
    <div class="container">
        <div class="row menu_footer_and_contact">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="footer_menu">
                    <h3>Категории</h3>
                    <ul>
                        <li><a href="#">Свет</a></li>
                        <li><a href="#">Датчики</a></li>
                        <li><a href="#">Розетки</a></li>
                        <li><a href="#">Пылесосы</a></li>
                        <li><a href="#">Кондиционеры</a></li>
                    </ul>
                </div>
                <div class="footer_menu">
                    <h3>Информация</h3>
                    <ul>
                        <li><a href="<?= Url::toRoute('page/dostavka_info'); ?>">Доставка</a></li>
                        <li><a href="<?= Url::toRoute('page/oplata_info'); ?>">Оплата</a></li>
                        <li><a href="<?= Url::toRoute('page/about'); ?>">О компании</a></li>
                    </ul>
                </div>
                <div class="footer_menu">
                    <h3>Учетная запись</h3>
                    <ul>
                        <li><a href="<?= Url::toRoute('site/login'); ?>">Войти</a></li>
                        <li><a href="<?= Url::toRoute('site/registration'); ?>">Зарегистрироваться</a></li>
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <li><a href="<?= Url::toRoute('page/listorder'); ?>">Мои заказы</a></li>
                            <li><a href="<?= Url::toRoute('page/listwishes'); ?>">Список желаний</a></li>
                            <?php if (Yii::$app->user->identity->login_user === 'admin'): ?>
                                <li><a href="<?= Url::toRoute('page/admin'); ?>">Панель администратора</a></li>
                            <?php endif; endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 contacts">
                <h3>Контакты</h3>
                <p><i class="glyphicon glyphicon-map-marker"></i>Адрес: пр. Просвещения, 14 г. Санкт-Петербург, 194355
                </p>
                <p><i class="glyphicon glyphicon-phone-alt"></i>Служба поддержки: 8 (921) 187-92-52</p>
                <p><i class="glyphicon glyphicon-envelope"></i>E-mail: sokolovalexandra@icloud.com</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 copy">
                <p>© 2023 ООО "Умный дом"</p>
            </div>
        </div>
    </div>
</div>


<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<? //= $content ?>


<?php $this->endBody() ?>


<script>

    function submitFormCart(button){
        var form = $("#form1");
        document.getElementById('submit-button').value = button;
        form.yiiActiveForm("validate", true);
        if (form.yiiActiveForm("validated"))
            form.submit();
    }
    $(document).ready(function () {
        function calcSum() {
            var sum = 0;
            var elements = document.querySelectorAll('[id^="rez-price-"]');
            for (var i = 0; i < elements.length; i++) {
                var element = elements[i];
                var val = parseInt(element.textContent.replace(/\D/g, ''));
                sum += val;
            }
            return sum;
        }
        // Обработчик нажатия кнопки "+"
        $('.plus-cart-button').on('click', function () {
            var index = $(this).data('index'); // Получение индекса кнопки
            var input = $('#input-' + index); // Получение соответствующего поля ввода
            var value = parseInt(input.val()); // Получение текущего значения поля ввода
            if (value >= products[index]['count'])
                return
            input.val(value + 1); // Увеличение значения на 1
            var price = parseInt($('#price-' + index).text().replace(/\D/g, ''));
            var rez_price = $('#rez-price-' + index);
            var add = price * (value + 1);
            rez_price.text(add.toLocaleString() + " руб");
            var rez_sum = $('#rez-sum');
            var rez_val = calcSum();
            rez_sum.text(rez_val.toLocaleString() + " руб");
        });

        // Обработчик нажатия кнопки "-"
        $('.minus-cart-button').on('click', function () {
            var index = $(this).data('index'); // Получение индекса кнопки
            var input = $('#input-' + index); // Получение соответствующего поля ввода
            var value = parseInt(input.val()); // Получение текущего значения поля ввода
            if (value > 0) {
                input.val(value - 1); // Уменьшение значения на 1, если оно больше нуля
                var price = parseInt($('#price-' + index).text().replace(/\D/g, ''));
                var rez_price = $('#rez-price-' + index);
                var add = price * (value + 1);
                rez_price.text((price * (value - 1)).toLocaleString() + " руб");
                var rez_sum = $('#rez-sum');
                var rez_val = calcSum();
                rez_sum.text(rez_val.toLocaleString() + " руб");
            }
        });

    });
</script>

</body>
</html>
<?php $this->endPage() ?>

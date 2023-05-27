<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\ProdAsset;
use yii\helpers\Url;

ProdAsset::register($this);
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
                        <form action="<?= Yii::$app->urlManager->createUrl(['page/search']) ?>" method="post">
                            <input placeholder="Поиск" type="text" name="search_text">
                            <button type="submit" name="submit_search">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </form>
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

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 catalog">
            <div class="row content">

                <?= $content; ?>

            </div>
        </div>

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
                        <?php if (!Yii::$app->user->isGuest):?>
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


<?php
/*
NavBar::begin([
    'brandLabel' => 'My Company',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        )
    ],
]);
NavBar::end();
*/
?>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<? //= $content ?>


<?php $this->endBody() ?>

<script>

    $("a.disabled").on('click', function (e) {
        e.preventDefault();
    })

    var input_text = Number($(".input_text").val());
    var count_prod = Number($(".count_prod").text());


    jQuery(".form_count_prod .plus").on("click", function () {
        if (input_text < count_prod) {
            input_text = input_text + 1;
            $(".input_text").val(input_text);
        }

    })

    jQuery(".form_count_prod .minus").on("click", function () {
        if (input_text > 1) {
            input_text = input_text - 1;
            $(".input_text").val(input_text);
        }
    })
</script>

</body>
</html>
<?php $this->endPage() ?>

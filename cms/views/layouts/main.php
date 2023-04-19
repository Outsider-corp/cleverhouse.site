<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\assets\AppAsset;


AppAsset::register($this);
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
          <div class="logo col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <a href="/"><img src="images/logo.png"></a>
          </div>
          <div class="btn_top_wrap col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="btn_and_search">
              <div class="btn_top">
                <a href="<?=Url::toRoute('page/formcontact');?>"><i class="glyphicon glyphicon-map-marker"></i>Обратная связь</a>
                <a href="<?=Url::toRoute('page/lk');?>"><i class="glyphicon glyphicon-user"></i>Личный кабинет</a>
                <a href="<?=Url::toRoute('page/login');?>"><i class="glyphicon glyphicon-lock"></i>Войти</a>
              </div>
              <div class="search_top">
                <form>
                    <input placeholder="Поиск" type="text">
                    <button type="submit" name="submit_search">
                      <i class="glyphicon glyphicon-search"></i>
                    </button>
                </form>
              </div>
            </div>
            <div class="cart_top">
                <?php echo \app\components\CartWidget::widget();?>
            </div>
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
                            ['label' => 'Новости', 'url' => ['/page/news']],
                            ['label' => 'Контакты', 'url' => ['/page/contacts']],
                        ],
                    ]);
                    NavBar::end();
                   
                    ?>
<!--
                 
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                  </div>


                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                      <li class="active"><a href="#">Одежда</a></li>
                      <li><a href="#">Обувь</a></li>
                      <li><a href="#">Снаряжение</a></li>
                      <li><a href="#">Амуниция</a></li>
                      <li><a href="#">Сувениры</a></li>
                    </ul>
                  </div>
-->

             
          </div>
        </div>
      </div>
    </header>


    <div class="container ban_block_wrap">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ban_block ban1">
          <div>
            <img src="images/ban1.jpg">
            <a href="#">
              <h2>Снаряжение для туризма</h2>
              <p>Широкий выбор уристического снаряжения</p>
              <span>Подробнее</span>
            </a>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ban_block">
          <div>
            <img src="images/ban2.jpg">
            <a href="#">
              <h2>Снаряжение для альпинистов</h2>
              <p>Качественное снаряжение для альпинизма от мировых брендов</p>
              <span>Подробнее</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <?=$content;?>

    <div class="container-fluid write_email_and_sseti">
        <div class="container">
            <div class="row write_email_and_sseti_wrap">
                <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12 write_email">
                    <p>Рассылка</p>
                    <form>
                        <button type="submit">
                          <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                        <input type="text" placeholder="Введите E-mail">
                    </form>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-5 hidden-xs sseti_wrap">
                    <div>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-vk"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
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
                            <li><a href="#">Одежда</a></li>
                            <li><a href="#">Обувь</a></li>
                            <li><a href="#">Снаряжение</a></li>
                            <li><a href="#">Амуниция</a></li>
                            <li><a href="#">Сувениры</a></li>
                        </ul>
                    </div>
                    <div class="footer_menu">
                        <h3>Информация</h3>
                        <ul>
                            <li><a href="<?=Url::toRoute('page/dostavka');?>">Доставка</a></li>
                            <li><a href="<?=Url::toRoute('page/oplata');?>">Оплата</a></li>
                            <li><a href="<?=Url::toRoute('page/about');?>">О компании</a></li>
                            <li><a href="<?=Url::toRoute('page/sale');?>">Скидки</a></li>
                            <li><a href="<?=Url::toRoute('page/sitemap');?>">Карта сайта</a></li>
                        </ul>
                    </div>
                    <div class="footer_menu">
                        <h3>Учетная запись</h3>
                        <ul>
                            <li><a href="<?=Url::toRoute('page/login');?>">Войти</a></li>
                            <li><a href="<?=Url::toRoute('page/registration');?>">Зарегистрироваться</a></li>
                            <li><a href="<?=Url::toRoute('page/cart');?>">Мои заказы</a></li>
                            <li><a href="<?=Url::toRoute('page/listorder');?>">Список желаний</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 contacts">
                    <h3>Контакты</h3>
                    <p><i class="glyphicon glyphicon-map-marker"></i>Адрес: ул. Ленина, 9 г. Москва, 603089</p>
                    <p><i class="glyphicon glyphicon-phone-alt"></i>Служба поддержки: 8 (800) 000-00-00</p>
                    <p><i class="glyphicon glyphicon-envelope"></i>E-mail: info@myshop.ru</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 copy">
                    <p>© 2017 не является действующим интернет-магазином</p>
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

        <?/*= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) */?>
        <?//= $content ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
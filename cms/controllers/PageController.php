<?php

namespace app\controllers;

use app\models\FilterForm;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use app\models\SortForm;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Categories;
use app\models\Products;
use yii\web\NotAcceptableHttpException;

/*Контроллер для страниц сайта*/

class PageController extends Controller
{

    /**
     * Для страницы списка товаров
     */
    public function actionListproducts()
    {
        if (isset($_GET['id']) && $_GET['id'] != "" && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $id = $_GET['id'];
            $categories = Categories::find()->where(['id' => $id])->asArray()->one();
            $filterModel = new FilterForm();
            if (isset($_GET['price_from']) && $_GET['price_from'] != "" && filter_var($_GET['price_from'], FILTER_VALIDATE_INT))
                $price_from = $_GET['price_from'];
            else
                $price_from = 0;
            if (isset($_GET['price_to']) && $_GET['price_to'] != "" && filter_var($_GET['price_to'], FILTER_VALIDATE_INT))
                $price_to = $_GET['price_to'];
            else
                $price_to = Products::find()->where(['id_category' => $id])->max('price');
            $value = 0;
            if ($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()) {
                if (isset($filterModel->price_from) && !empty($filterModel->price_from)) {
                    $price_from = $filterModel->price_from;
                }
                if (isset($filterModel->price_to) && !empty($filterModel->price_to) && $filterModel->price_to != 0) {
                    $price_to = $filterModel->price_to;
                }
                if (isset($filterModel->value) && !empty($filterModel->value)) {
                    $value = $filterModel->value;
                }
            }
            if (count($categories) > 0) {
                $model = new SortForm();

                $page = 1; // номер страницы
                $str = -1; // сортировка
                $number = 12; // количество товаров на странице

                if (isset($_GET['page']) && $_GET['page'] != "" && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
                    $page = $_GET['page'];
                }
                if (isset($_GET['str'])) {
                    $str = $_GET['str'];
                }
                if (isset($_GET['number']) && $_GET['number'] != "" && filter_var($_GET['number'], FILTER_VALIDATE_INT)) {
                    $number = $_GET['number'];
                }

                // Обработчик для формы сортировки
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    if (isset($model->number) && !empty($model->number)) {
                        $number = $model->number;
                    }
                    if (isset($model->str)) {
                        $str = $model->str;
                    }
                }
                switch ($str) {
                    case 0:
                        $products_array = $this->selectListProd($id, ['price' => SORT_ASC], $number,
                            $page, $price_from, $price_to, $value);
                        break;
                    case 1:
                        $products_array = $this->selectListProd($id, ['price' => SORT_DESC], $number,
                            $page, $price_from, $price_to, $value);
                        break;
                    case 2:
                        $products_array = $this->selectListProd($id, ['name_product' => SORT_ASC], $number,
                            $page, $price_from, $price_to, $value);
                        break;
                    case 3:
                        $products_array = $this->selectListProd($id, ['name_product' => SORT_DESC], $number,
                            $page, $price_from, $price_to, $value);
                        break;
                    default:
                        $products_array = $this->selectListProd($id, ['id' => SORT_ASC], $number, $page,
                            $price_from, $price_to, $value);
                        break;
                }
            }
            $count_products = count(Products::find()->where(['id_category' => $id])->andWhere(['>=', 'price', $price_from])->
            andWhere(['<=', 'price', $price_to])->asArray()->all());
            // количество страниц для пагинации
            $count_pages = ceil($count_products / $number);

            if (isset($_GET['view']) && $_GET['view'] == 1)
                $view = 1;
            else
                $view = 0;

            return $this->render('listproducts', compact('categories', 'products_array',
                'count_products', 'view', 'model', 'count_pages', 'id', 'number', 'str', 'filterModel', 'price_from',
                'price_to', 'value'));
        }
        return $this->redirect(['page/catalog']);
    }

    private
    function selectListProd($id, $field_sort, $limit, $start, $price_from, $price_to, $value)
    {
        if ($start == 1)
            $start = 0;
        else
            $start = ($start - 1) * $limit;
        return Products::find()->where(['id_category' => $id])->
        andWhere(['>=', 'price', $price_from])->
        andWhere(['<=', 'price', $price_to])->
        asArray()->orderBy($field_sort)->limit($limit)->offset($start)->all();
    }

    private
    function selectSearch($text, $field_sort, $limit, $start, $price_from, $price_to, $value)
    {
        if ($start == 1)
            $start = 0;
        else
            $start = ($start - 1) * $limit;

        return Products::find()->where(['like', 'name_product', '%' . $text . '%', false])->
        andWhere(['>=', 'price', $price_from])->
        andWhere(['<=', 'price', $price_to])->
        orderBy($field_sort)->limit($limit)->offset($start)->all();
    }

    /**
     * Для страницы каталога
     */
    public
    function actionCatalog()
    {
        $categories = Categories::find()->asArray()->all();
        return $this->render('catalog', compact('categories'));
    }

    public function actionSearch()
    {
        if (isset($_GET['search_text']) && $_GET['search_text'] != "") {
            $text = $_GET['search_text'];
            $filterModel = new FilterForm();
            if (isset($_GET['price_from']) && $_GET['price_from'] != "" && filter_var($_GET['price_from'], FILTER_VALIDATE_INT))
                $price_from = $_GET['price_from'];
            else
                $price_from = 0;
            if (isset($_GET['price_to']) && $_GET['price_to'] != "" && filter_var($_GET['price_to'], FILTER_VALIDATE_INT))
                $price_to = $_GET['price_to'];
            else
                $price_to = Products::find()->where(['like', 'name_product', '%' . $text . '%', false])->max('price');
            $value = 0;
            if ($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()) {
                if (isset($filterModel->price_from) && !empty($filterModel->price_from)) {
                    $price_from = $filterModel->price_from;
                }
                if (isset($filterModel->price_to) && !empty($filterModel->price_to) && $filterModel->price_to != 0) {
                    $price_to = $filterModel->price_to;
                }
                if (isset($filterModel->value) && !empty($filterModel->value)) {
                    $value = $filterModel->value;
                }
            }

            $search_text = $_GET['search_text'];
            $model = new SortForm();
            $products_array = Products::find()->where(['like', 'name_product', '%' . $search_text . '%', false])->all();
            $count_products = count($products_array);
            if ($count_products != 0) {
                $page = 1; // номер страницы
                $str = -1; // сортировка
                $number = 12; // количество товаров на странице

                if (isset($_GET['page']) && $_GET['page'] != "" && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
                    $page = $_GET['page'];
                }
                if (isset($_GET['str'])) {
                    $str = $_GET['str'];
                }
                if (isset($_GET['number']) && $_GET['number'] != "" && filter_var($_GET['number'], FILTER_VALIDATE_INT)) {
                    $number = $_GET['number'];
                }
                // Обработчик для формы сортировки
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    if (isset($model->number) && !empty($model->number)) {
                        $number = $model->number;
                    }
                    if (isset($model->str)) {
                        $str = $model->str;
                    }
                }
                switch ($str) {
                    case 0:
                        $products_array = $this->selectSearch($search_text, ['price' => SORT_ASC], $number, $page
                            , $price_from, $price_to, $value);
                        break;
                    case 1:
                        $products_array = $this->selectSearch($search_text, ['price' => SORT_DESC], $number, $page,
                            $price_from, $price_to, $value);
                        break;
                    case 2:
                        $products_array = $this->selectSearch($search_text, ['name_product' => SORT_ASC], $number, $page,
                            $price_from, $price_to, $value);
                        break;
                    case 3:
                        $products_array = $this->selectSearch($search_text, ['name_product' => SORT_DESC], $number, $page,
                            $price_from, $price_to, $value);
                        break;
                    default:
                        $products_array = $this->selectSearch($search_text, ['id' => SORT_ASC], $number, $page,
                            $price_from, $price_to, $value);
                        break;
                }
                $count_products = count(Products::find()->where(['like', 'name_product', '%' . $text . '%', false])->
                andWhere(['>=', 'price', $price_from])->
                andWhere(['<=', 'price', $price_to])->all());
                $count_pages = ceil($count_products / $number);
                if (isset($_GET['view']) && $_GET['view'] == 1)
                    $view = 1;
                else
                    $view = 0;
            }
            return $this->render('search', compact('products_array',
                'count_products', 'view', 'model', 'count_pages', 'number', 'str', 'search_text',
                'filterModel', 'price_from', 'price_to', 'value'));
        }
        return $this->redirect(['site/index']);
    }

    /**
     * Для страницы каталога
     */
    public
    function actionProduct()
    {
        $this->layout = "product";

        if (isset($_GET['id']) && !empty($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $id = $_GET['id'];
        } else {
            throw new NotAcceptableHttpException;
        }

        $product_array = Products::find()->where(['id' => $id])->asArray()->one();
        if (!is_array($product_array) || count($product_array) < 0) {
            throw new NotAcceptableHttpException;
        }


        return $this->render('product', compact('product_array', 'id'));
    }

    /**
     * Для страницы новостей
     */
    public
    function actionNews()
    {
        return $this->render('news');
    }

    /**
     * Для страницы контакты
     */
    public
    function actionContacts()
    {
        return $this->render('contacts');
    }

    /**
     * Для страницы входа
     */
    public
    function actionLogin()
    {
        return $this->render('login');
    }

    /**
     * Для страницы регистрации
     */
    public
    function actionRegistration()
    {
        return $this->render('registration');
    }

    /**
     * Для страницы обратная связь
     */
    public
    function actionFormcontact()
    {
        return $this->render('formcontact');
    }

    /**
     * Для страницы личный кабинет
     */
    public
    function actionLk()
    {
        return $this->render('lk');
    }

    /**
     * Для страницы Доставка
     */
    public
    function actionDostavka()
    {
        return $this->render('dostavka');
    }

    /**
     * Для страницы Оплата
     */
    public
    function actionOplata()
    {
        return $this->render('oplata');
    }

    /**
     * Для страницы О компании
     */
    public
    function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Для страницы Скидки
     */
    public
    function actionSale()
    {
        return $this->render('sale');
    }

    /**
     * Для страницы Карта сайта
     */
    public
    function actionSitemap()
    {
        return $this->render('sitemap');
    }

    /**
     * Для страницы корзина
     */
    public
    function actionCart()
    {
        $session = Yii::$app->session;
//        $session->destroy();
        $session->open();


        if ($session->has('productsSession')) {
            $productsSession = $session->get('productsSession');
        } else {
            $productsSession = array();
        }

        if (isset($_GET['id']) && !empty($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $productsArray = Products::find()->where(['id' => $_GET['id']])->asArray()->one();

            if (is_array($productsArray) && count($productsArray) > 0) {
                $flag = false;
                for ($i = 0; $i < count($productsSession); $i++) {
                    if ($productsSession[$i]['id'] == $_GET['id']) {
                        $flag = true;
                        if ($productsArray['count'] >= $productsSession[$i]['count'] + 1) {
                            $productsSession[$i]['count']++;
                        }
                        break;
                    }
                }
                if (!$flag) {
                    array_push($productsSession, ['id' => $_GET['id'], 'count' => 1]);
                }
            }
        }

        $session->set('productsSession', $productsSession);
        $productsSession = $session->get('productsSession');

        $arrayID = array();

        foreach ($productsSession as $value) {
            array_push($arrayID, $value['id']);
        }

        $products = Products::find()->where(['id' => $arrayID])->asArray()->All();

        foreach ($products as $key => $value) {
            $products[$key]['count_cart'] = $productsSession[$key]['count'];
        }


        return $this->render('cart', compact('products'));
    }

    /**
     * Авторизация и регистрация (адрес)
     */

    public
    function actionCheckout()
    {
        return $this->render('checkout');
    }

    /**
     * Для страницы Список желаний
     */
    public
    function actionListorder()
    {
        return $this->render('listorder');
    }


}

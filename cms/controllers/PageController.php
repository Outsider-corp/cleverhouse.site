<?php

namespace app\controllers;

use app\models\Cart;
use app\models\ContactForm;
use app\models\AddressForm;
use app\models\DostavkaForm;
use app\models\FilterForm;
use app\models\Order;
use app\models\SpecCart;
use Yii;
use yii\db\Exception;
use yii\db\Expression;
use yii\filters\AccessControl;
use app\models\SortForm;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Categories;
use app\models\Products;
use yii\web\NotAcceptableHttpException;
use yii\helpers\Url;

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
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail($model->email)) {
                // Успешно отправлено
                Yii::$app->session->setFlash('success', 'Ваше сообщение успешно отправлено.');
            } else {
                // Ошибка при отправке
                Yii::$app->session->setFlash('error', 'Произошла ошибка при отправке сообщения.');
            }

            return $this->refresh(); // Перенаправление на ту же страницу
        }

        return $this->render('formcontact', compact('model'));
    }

    /**
     * Для страницы личный кабинет
     */
    public
    function actionLk()
    {
        return $this->render('lk');
    }

    public
    function actionOplata_info()
    {
        return $this->render('oplata_info');
    }

    public
    function actionDostavka_info()
    {
        return $this->render('dostavka_info');
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
     * Для страницы корзина
     */
    public
    function actionCart()
    {
        $products = [];
        $productId = Yii::$app->request->get('id');
        if ($productId !== null && $productId > 0 && filter_var($productId, FILTER_VALIDATE_INT))
            $product = Products::findOne($productId);
        $addition = true;
        $count_add = Yii::$app->request->get('count');
        if ($count_add === null || !filter_var($count_add, FILTER_VALIDATE_INT)) {
            $count_add = 1;
        } else if ($count_add > $product['count']) {
            $count_add = null;
        }
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $cart = Cart::findOne(['id_user' => $userId]);
            if ($cart === null) {
                $cart = new Cart();
                $cart->id_user = $userId;
                $cart->save();
            }
            if (isset($product) and isset($count_add)) {
                $specCart = SpecCart::findOne(['id_cart' => $cart->id_cart, 'id_product' => $productId]);
                if ($specCart === null) {
                    $specCart = new SpecCart();
                    $specCart->id_cart = $cart->id_cart;
                    $specCart->id_product = $productId;
                    $specCart->count = $count_add;
                    $specCart->save();
                } else {
                    if ($product['count'] > $specCart->count + $count_add)
                        $specCart->count += $count_add;
                }
                $specCart->save();
            }
            $products = $this->UserCartInfo($userId);
        } else {

            $session = Yii::$app->session;
//        $session->destroy();
            $session->open();

            if ($session->has('productsSession')) {
                $productsSession = $session->get('productsSession');
            } else {
                $productsSession = array();
            }
            if (isset($product) and isset($count_add)) {
                if (isset($productsSession[$productId])) {
                    if ($productsSession[$productId]['count'] >= $productsSession[$productId]['count_cart'] + $count_add)
                        $productsSession[$productId]['count_cart'] += $count_add;
                } else {
                    $productsSession[$productId] = [
                        'id' => $productId,
                        'name_product' => $product->name_product,
                        'price' => $product->price,
                        'description' => $product->description,
                        'count' => $product->count,
                        'id_category' => $product->id_category,
                        'img_product' => $product->img_product,
                        'count_cart' => $count_add,
                    ];
                }
            }
            $products = array_values($productsSession);
            $session->set('productsSession', $productsSession);
        }
        return $this->render('cart', compact('products'));
    }

    private function UserCartInfo($userId)
    {
        $cart = Cart::findOne(['id_user' => $userId]);
        $specCartItems = SpecCart::find()
            ->select(['id_product', 'count'])
            ->where(['id_cart' => $cart->id_cart])
            ->asArray()
            ->all();
        $products = [];
        foreach ($specCartItems as $item) {
            $productId = $item['id_product'];
            $count = $item['count'];
            $product = Products::findOne($productId);
            if ($product !== null) {
                $products[] = [
                    'id' => $productId,
                    'name_product' => $product->name_product,
                    'price' => $product->price,
                    'description' => $product->description,
                    'count' => $product->count,
                    'id_category' => $product->id_category,
                    'img_product' => $product->img_product,
                    'count_cart' => $count,
                ];
            }
        }
        return $products;
    }

    public
    function actionAddress()
    {
        $model = new AddressForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $session = Yii::$app->session;
            $session->open();
            $session->set('order_city', $model->city);
            $session->set('order_address', $model->address);
            $session->set('order_region', $model->region);
            return $this->redirect(['page/dostavka']);
        }

        return $this->render('address', compact('model'));
    }

    public
    function actionDostavka()
    {
        $session = Yii::$app->session;
        $session->open();
        if (!isset($session['order_city']))
            return $this->redirect(['page/cart']);
        $model = new DostavkaForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $session['dostavka'] = $model->attribute;
            $session->set('dostavka', $model->attribute);
            $session->set('oplata', $model->oplata);
            return $this->redirect(['page/checkout']);
        }
        return $this->render('dostavka', compact('model'));
    }

    /**
     * Для страницы Оплата
     */
    public
    function actionCheckout()
    {
        $session = Yii::$app->session;
        $session->open();
        if (!isset($session['dostavka']))
            return $this->redirect(['page/cart']);
        $userId = Yii::$app->user->id;
        $products = $this->UserCartInfo($userId);

        return $this->render('checkout', compact('products'));
    }

    public function actionOrder()
    {
        $session = Yii::$app->session;
        $session->open();
        if (!isset($session['dostavka']))
            return $this->redirect(['site/index']);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $userId = Yii::$app->user->id;
            $cart = Cart::findOne(['id_user' => $userId]);
            $order = new Order();
            $order->id_user = $userId;
            $order->date_order = date('Y-m-d H:i:s');
            $order->id_cart = $cart->id_cart;
            $order->type_payment = $session['oplata'];
            $order->type_delivery = $session['dostavka'];
            $order->city = $session['order_city'];
            $order->address = $session['order_address'];
            $order->region = $session['order_region'];
            $order->save();
            $cart->id_user = null;
            $cart->save();
            $specCarts = $cart->getSpecCarts();
            foreach ($specCarts as $specCart) {
                $product = Products::findOne($specCart['id_product']);
                $product->count -= $specCart['count'];
                $product->save();
            }
            $session->remove('oplata');
            $session->remove('dostavka');
            $session->remove('productsSession');
            $session->remove('order_city');
            $session->remove('order_address');
            $session->remove('order_region');
            $transaction->commit();
            return $this->render('order', compact('order'));
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->render('order', compact('e'));
        }
    }

    /**
     * Для страницы Список желаний
     */
    public
    function actionListorder()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $orders_raw = Order::find()->where(['id_user' => $userId])->asArray()->all();
            $orders = [];
            foreach ($orders_raw as $order) {
                $cart = Cart::findOne(['id_cart' => $order['id_cart']]);
                $orders[$order['id_order']] = [];
                $specCarts = SpecCart::find()->where(['id_cart' => $cart])->asArray()->all();
                $sum = 0;
                foreach ($specCarts as $specCart) {
                    $product = Products::findOne($specCart['id_product']);
                    $orders[$order['id_order']][$specCart['id_product']] = [
                        'name_product' => $product->name_product,
                        'count' => $specCart['count'],
                    ];
                    $sum += $product['price'] * $specCart['count'];
                }
                $orders[$order['id_order']]['sum'] = $sum;
                $orders[$order['id_order']]['date'] = $order['date_order'];
            }
            return $this->render('listorder', compact('orders'));
        }
        return $this->redirect(['site/index']);
    }


}

<?php

namespace app\controllers;

use app\models\AddCartForm;
use app\models\AddCategoryForm;
use app\models\AddCharacteristicForm;
use app\models\AddProductForm;
use app\models\Cart;
use app\models\ChangeCartForm;
use app\models\Characteristics;
use app\models\ContactForm;
use app\models\AddressForm;
use app\models\DostavkaForm;
use app\models\FilterForm;
use app\models\Order;
use app\models\ReviewForm;
use app\models\Reviews;
use app\models\SpecCart;
use app\models\SpecWishlist;
use app\models\User;
use app\models\Wishlist;
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
use yii\db\Query;

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
            $indexes = [];
            if ($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()) {
                if (isset($filterModel->price_from) && !empty($filterModel->price_from)) {
                    $price_from = $filterModel->price_from;
                }
                if (isset($filterModel->price_to) && !empty($filterModel->price_to) && $filterModel->price_to != 0) {
                    $price_to = $filterModel->price_to;
                }
                if (is_array($filterModel->values))
                    $indexes = $filterModel->values;
            }
            try {
                $filter_value = (new Query())
                    ->select('name_сharacteristic')
                    ->from('characteristics')
                    ->where(['id_product' => (new Query())->select('id')->from('products')->where(['id_category' => $id])])
                    ->groupBy('name_сharacteristic')
                    ->orderBy(['COUNT(*)' => SORT_DESC])
                    ->limit(1)->scalar();
                $descriptions = (new Query())
                    ->select('description_сharacteristic')
                    ->from('characteristics')
                    ->where(['id_product' => (new Query())->select('id')->from('products')->where(['id_category' => $id])])
                    ->andWhere(['name_сharacteristic' => $filter_value])->distinct()
                    ->column();
            } catch (\Exception $e) {
                $filter_value = null;
                $descriptions = null;
            }
            $value = [];
            if (count($indexes) != 0)
                foreach ($indexes as $index) {
                    if (isset($descriptions[$index])) {
                        $value[] = $descriptions[$index];
                    }
                }
            if (isset($categories) && count($categories) > 0) {
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
                            $page, $price_from, $price_to, $filter_value, $value);
                        break;
                    case 1:
                        $products_array = $this->selectListProd($id, ['price' => SORT_DESC], $number,
                            $page, $price_from, $price_to, $filter_value, $value);
                        break;
                    case 2:
                        $products_array = $this->selectListProd($id, ['name_product' => SORT_ASC], $number,
                            $page, $price_from, $price_to, $filter_value, $value);
                        break;
                    case 3:
                        $products_array = $this->selectListProd($id, ['name_product' => SORT_DESC], $number,
                            $page, $price_from, $price_to, $filter_value, $value);
                        break;
                    default:
                        $products_array = $this->selectListProd($id, ['id' => SORT_ASC], $number, $page,
                            $price_from, $price_to, $filter_value, $value);
                        break;
                }
            if (!Yii::$app->user->isGuest) {
                $userId = Yii::$app->user->id;
                $wish = Wishlist::findOne(['id_user' => $userId]);
                foreach ($products_array as $key => $product) {
                    if (isset($wish))
                        $products_array[$key]['wishlist'] = SpecWishlist::find()
                            ->where(['id_wishlist' => $wish->id_wishlist, 'id_product' => $product['id']])->count();
                    else
                        $products_array[$key]['wishlist'] = 0;
                }
            }
            foreach ($products_array as $key => $product) {
                $products_array[$key]['chars'] = Characteristics::find()->where(['id_product' => $product['id']])->asArray()->all();
            }
            $count_products = count(Products::find()->where(['id_category' => $id])
                ->andWhere(['>=', 'price', $price_from])
                ->andWhere(['<=', 'price', $price_to])->asArray()->all());
            // количество страниц для пагинации
            $count_pages = ceil($count_products / $number);

            if (isset($_GET['view']) && $_GET['view'] == 1)
                $view = 1;
            else
                $view = 0;

            return $this->render('listproducts', compact('categories', 'products_array',
                'count_products', 'view', 'model', 'count_pages', 'id', 'number', 'str', 'filterModel', 'price_from',
                'price_to', 'filter_value', 'descriptions'));
        }}
        return $this->redirect(['page/catalog']);
    }

    private
    function selectListProd($id, $field_sort, $limit, $start, $price_from, $price_to, $filter_name, $value)
    {
        if ($start == 1)
            $start = 0;
        else
            $start = ($start - 1) * $limit;
        if (count($value) != 0) {
            return Products::find()->where(['id_category' => $id])->joinWith('characteristics')
                ->andWhere(['name_сharacteristic' => $filter_name])
                ->andWhere(['description_сharacteristic' => $value])
                ->asArray()->orderBy($field_sort)->limit($limit)->offset($start)->all();
        }
        if (isset($price_from) && isset($price_to)) {
            return Products::find()->where(['id_category' => $id])->
            andWhere(['>=', 'price', $price_from])->
            andWhere(['<=', 'price', $price_to])->
            asArray()->orderBy($field_sort)->limit($limit)->offset($start)->all();
        }
        return Products::find()->where(['id_category' => $id])
            ->asArray()->orderBy($field_sort)->limit($limit)->offset($start)->all();
    }

    private
    function selectSearch($text, $field_sort, $limit, $start, $price_from, $price_to, $filter_name, $value)
    {
        if ($start == 1)
            $start = 0;
        else
            $start = ($start - 1) * $limit;
        return Products::find()->where(['like', 'name_product', '%' . $text . '%', false])->
        andWhere(['>=', 'price', $price_from])->
        andWhere(['<=', 'price', $price_to])->asArray()->
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
            $search_text = $_GET['search_text'];
            $filterModel = new FilterForm();
            if (isset($_GET['price_from']) && $_GET['price_from'] != "" && filter_var($_GET['price_from'], FILTER_VALIDATE_INT))
                $price_from = $_GET['price_from'];
            else
                $price_from = 0;
            if (isset($_GET['price_to']) && $_GET['price_to'] != "" && filter_var($_GET['price_to'], FILTER_VALIDATE_INT))
                $price_to = $_GET['price_to'];
            else
                $price_to = Products::find()->where(['like', 'name_product', '%' . $search_text . '%', false])->max('price');
            if ($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()) {
                if (isset($filterModel->price_from) && !empty($filterModel->price_from)) {
                    $price_from = $filterModel->price_from;
                }
                if (isset($filterModel->price_to) && !empty($filterModel->price_to) && $filterModel->price_to != 0) {
                    $price_to = $filterModel->price_to;
                }
            }
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
                            , $price_from, $price_to, null, null);
                        break;
                    case 1:
                        $products_array = $this->selectSearch($search_text, ['price' => SORT_DESC], $number, $page,
                            $price_from, $price_to, null, null);
                        break;
                    case 2:
                        $products_array = $this->selectSearch($search_text, ['name_product' => SORT_ASC], $number, $page,
                            $price_from, $price_to, null, null);
                        break;
                    case 3:
                        $products_array = $this->selectSearch($search_text, ['name_product' => SORT_DESC], $number, $page,
                            $price_from, $price_to, null, null);
                        break;
                    default:
                        $products_array = $this->selectSearch($search_text, ['id' => SORT_ASC], $number, $page,
                            $price_from, $price_to, null, null);
                        break;
                }
                if (!Yii::$app->user->isGuest) {
                    $userId = Yii::$app->user->id;
                    $wish = Wishlist::findOne(['id_user' => $userId]);
                    foreach ($products_array as $key => $product) {
                        if (isset($wish))
                            $products_array[$key]['wishlist'] = SpecWishlist::find()
                                ->where(['id_wishlist' => $wish->id_wishlist, 'id_product' => $product['id']])->count();
                        else
                            $products_array[$key]['wishlist'] = 0;
                    }
                }
                foreach ($products_array as $key => $product) {
                    $products_array[$key]['chars'] = Characteristics::find()->where(['id_product' => $product['id']])->asArray()->all();
                }
                $count_products = count(Products::find()->where(['like', 'name_product', '%' . $search_text . '%', false])->
                andWhere(['>=', 'price', $price_from])->
                andWhere(['<=', 'price', $price_to])->all());
                $count_pages = ceil($count_products / $number);
                if (isset($_GET['view']) && $_GET['view'] == 1)
                    $view = 1;
                else
                    $view = 0;
            }
            $title = 'Умный дом | Поиск';
            return $this->render('search', compact('products_array',
                'count_products', 'view', 'model', 'count_pages', 'number', 'str', 'search_text',
                'filterModel', 'price_from', 'price_to', 'value', 'title'));
        }
        return $this->redirect(['site/index']);
    }

    public
    function actionProduct()
    {
        $this->layout = "product";

        if (isset($_GET['id']) && !empty($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $id = $_GET['id'];
        } else {
            throw new NotAcceptableHttpException;
        }
        $model = new AddCartForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['cart', 'id' => $id, 'count' => $model->value]);
        }
        $product_array = Products::find()->where(['id' => $id])->asArray()->one();
        if (!is_array($product_array) || count($product_array) < 0) {
            throw new NotAcceptableHttpException;
        }
        $product_array['chars'] = Characteristics::find()->where(['id_product' => $product_array['id']])->asArray()->all();
        if (!Yii::$app->user->isGuest) {
            $wish = Wishlist::findOne(['id_user' => Yii::$app->user->id]);
            if (isset($wish))
                $product_array['wishlist'] = SpecWishlist::find()
                    ->where(['id_wishlist' => $wish->id_wishlist, 'id_product' => $product_array['id']])
                    ->asArray()
                    ->count();
            else
                $product_array['wishlist'] = 0;
            $reviewModel = new ReviewForm();
            if ($reviewModel->load(Yii::$app->request->post()) && $reviewModel->validate()) {
                if ($reviewModel->text != "") {
                    $review = new Reviews();
                    $review->text_review = $reviewModel->text;
                    $review->rating = $reviewModel->rating;
                    $review->id_user = Yii::$app->user->id;
                    $review->id_product = $id;
                    $review->date = date('Y-m-d H:i:s');
                    $review->save();
                }
            }
            $reviewModel->reset();
        } else {
            $reviewModel = 0;
            $model = 0;
        }
        $product_array['reviews'] = array_reverse(Reviews::find()->where(['id_product' => $id])->asArray()->all());
        foreach ($product_array['reviews'] as $key => $review) {
            $product_array['reviews'][$key]['name_user'] = User::findOne($review['id_user'])->name_user;
        }
        return $this->render('product', compact('product_array', 'id', 'reviewModel', 'model'));
    }

    public
    function actionNews()
    {
        return $this->render('news');
    }

    public
    function actionContacts()
    {
        return $this->render('contacts');
    }


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

    public
    function actionAbout()
    {
        return $this->render('about');
    }

    public
    function actionCart()
    {
        if (!Yii::$app->user->isGuest) {
            $model = new ChangeCartForm();
            $userId = Yii::$app->user->id;
            $cart = Cart::findOne(['id_user' => $userId]);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $params = Yii::$app->request->post();
                $products = $this->UserCartInfo($userId);
                $values = $model->values;
                foreach ($values as $key => $value) {
                    $specCart = SpecCart::findOne(['id_cart' => $cart->id_cart, 'id_product' => $products[$key]['id']]);
                    if ($value == 0)
                        $specCart->delete();
                    else {
                        $specCart->count = $value;
                        $specCart->save();
                    }
                }
                $sumVals = array_sum($values);
                if ($params["submit-button"] == "next" && $sumVals > 0)
                    return $this->redirect(['page/address']);
                else if ($params["submit-button"] == "back")
                    return $this->redirect(['site/index']);
            }
            $products = [];
            if (!isset($cart)) {
                $cart = new Cart();
                $cart->id_user = $userId;
                $cart->save();
            }
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $productId = $_GET['id'];
                $product = Products::findOne($productId);
                if (isset($_GET['count']) && filter_var($_GET['count'], FILTER_VALIDATE_INT))
                    $count_add = $_GET['count'];
                else
                    $count_add = 1;
                if ($count_add > $product['count'])
                    $count_add = $product['count'];
                $specCart = SpecCart::findOne(['id_cart' => $cart->id_cart, 'id_product' => $productId]);
                if (!isset($specCart)) {
                    $specCart = new SpecCart();
                    $specCart->id_cart = $cart->id_cart;
                    $specCart->id_product = $productId;
                    $specCart->count = $count_add;
                } else {
                    if ($product['count'] > $specCart->count + $count_add)
                        $specCart->count += $count_add;
                    else
                        $specCart->count = $product['count'];
                }
                $specCart->save();
            }
            $products = $this->UserCartInfo($userId);
            $this->view->registerJsVar('products', $products);
            return $this->render('cart', compact('products', 'model'));
        } else {
            return $this->redirect(['site/index']);
        }
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
            $wish = Wishlist::findOne(['id_user' => $userId]);
            if (isset($wish))
                $wish_chk = SpecWishlist::find()
                    ->where(['id_wishlist' => $wish->id_wishlist, 'id_product' => $productId])->count();
            else
                $wish_chk = 0;
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
                    'wishlist' => $wish_chk,
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
            $session->set('dostavka', $model->attribute);
            $session->set('oplata', $model->oplata);
            return $this->redirect(['page/checkout']);
        }
        return $this->render('dostavka', compact('model'));
    }

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
            $specCarts = $cart->getSpecCarts();
            foreach ($specCarts as $specCart) {
                $product = Products::findOne($specCart['id_product']);
                $product->count -= $specCart['count'];
                $product->save();
            }
            $session->remove('oplata');
            $session->remove('dostavka');
            $session->remove('order_city');
            $session->remove('order_address');
            $session->remove('order_region');
            $cart->delete();
            $transaction->commit();
            return $this->render('order', compact('order'));
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->render('order', compact('e'));
        }
    }

    public
    function actionListorder()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $orders_raw = Order::find()->where(['id_user' => $userId])->asArray()->all();
            $orders = [];
            foreach ($orders_raw as $order) {
                $orders[$order['id_order']] = [];
                $specCarts = SpecCart::find()->where(['id_cart' => $order['id_cart']])->asArray()->all();
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

    public function actionListwishes()
    {
        $productId = Yii::$app->request->get('id');
        $action = Yii::$app->request->get('action');
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            if ($productId !== null && $action !== null && $productId > 0 && filter_var($productId, FILTER_VALIDATE_INT)) {
                $wish = Wishlist::findOne(['id_user' => $userId]);
                if (!isset($wish)) {
                    $wish = new Wishlist();
                    $wish->id_user = $userId;
                    $wish->save();
                }
                $exists_item = SpecWishlist::find()
                    ->where(['id_wishlist' => $wish->id_wishlist, 'id_product' => $productId])
                    ->asArray()
                    ->one();
                if ($action == 'add' && !isset($exists_item)) {
                    $specWish = new SpecWishlist();
                    $specWish->id_wishlist = $wish->id_wishlist;
                    $specWish->id_product = $productId;
                    $specWish->save();
                } else if ($action == 'del' && isset($exists_item)) {
                    $item = SpecWishlist::findOne($exists_item['id_spec_wishlist']);
                    $item->delete();
                }
            }

            $products_array = $this->UserWishInfo($userId);
            $title = 'Умный дом | Поиск';
            $count_products = count($products_array);
            return $this->render('listwishes', compact('products_array',
                'count_products', 'title', 'action'));
        }
        return $this->redirect(['site/index']);
    }

    private
    function UserWishInfo($userId)
    {
        $wish = Wishlist::findOne(['id_user' => $userId]);
        if (isset($wish))
            $specWishItems = SpecWishlist::find()
                ->where(['id_wishlist' => $wish->id_wishlist])
                ->asArray()
                ->all();
        else
            $specWishItems = [];
        $products = [];
        foreach ($specWishItems as $item) {
            $productId = $item['id_product'];
            $product = Products::findOne($productId);
            if ($product !== null) {
                $products[] = [
                    'id' => $productId,
                    'name_product' => $product->name_product,
                    'price' => $product->price,
                    'count' => $product->count,
                    'price_old' => $product->price_old,
                    'id_category' => $product->id_category,
                    'img_product' => $product->img_product,
                ];
            }
        }
        return $products;
    }

    public function actionAdmin()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login_user === 'admin') {
            $categories = Categories::find()->asArray()->all();
            return $this->render('admin', compact('categories'));
        } else {
            return $this->goHome();
        }
    }

    public function actionAdmin_listproducts()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login_user === 'admin') {
            if (isset($_GET['id']) && $_GET['id'] != "" && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $id = $_GET['id'];
                $categories = Categories::find()->where(['id' => $id])->asArray()->one();
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
                                $page, null, null, null, []);
                            break;
                        case 1:
                            $products_array = $this->selectListProd($id, ['price' => SORT_DESC], $number,
                                $page, null, null, null, []);
                            break;
                        case 2:
                            $products_array = $this->selectListProd($id, ['name_product' => SORT_ASC], $number,
                                $page, null, null, null, []);
                            break;
                        case 3:
                            $products_array = $this->selectListProd($id, ['name_product' => SORT_DESC], $number,
                                $page, null, null, null, []);
                            break;
                        default:
                            $products_array = $this->selectListProd($id, ['id' => SORT_ASC], $number, $page,
                                null, null, null, []);
                            break;
                    }
                    $count_products = count(Products::findAll(['id_category' => $id]));
                    $count_pages = ceil($count_products / $number);

                    if (isset($_GET['view']) && $_GET['view'] == 1)
                        $view = 1;
                    else
                        $view = 0;

                    return $this->render('admin_listproducts', compact('categories', 'products_array',
                        'model', 'count_pages', 'id', 'number', 'str'));
                }
            }
            return $this->redirect(['page/catalog']);
        } else {
            return $this->goHome();
        }
    }

    public function actionAdmin_product()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login_user === 'admin') {
            if (isset($_GET['id']) && !empty($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $id = $_GET['id'];
            } else {
                throw new NotAcceptableHttpException;
            }
            $product_array = Products::find()->where(['id' => $id])->asArray()->one();
            if (!is_array($product_array) || count($product_array) < 0) {
                throw new NotAcceptableHttpException;
            }
            $product_array['chars'] = Characteristics::find()->where(['id_product' => $product_array['id']])->asArray()->all();

            return $this->render('admin_product', compact('id', 'product_array'));
        }
        return $this->goHome();
    }

    public
    function actionAddcategory()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login_user === 'admin') {
            $model = new AddCategoryForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_GET['id'])) {
                    $update = Categories::findOne($_GET['id']);
                } else {
                    $update = new Categories();
                }
                $update->name_category = $model->name;
                $update->img_category = $model->img;
                $update->description_category = $model->description;
                $update->save();
                return $this->redirect(['page/admin']);
            }
            if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $category = Categories::find()->where(['id' => $_GET['id']])->asArray()->one();
                return $this->render('addcategory', compact('category', 'model'));
            } else {
                return $this->render('addcategory', compact('model'));
            }
        } else {
            return $this->goHome();
        }
    }

    public
    function actionAddproduct()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login_user === 'admin') {
            $model = new AddProductForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_GET['id'])) {
                    $update = Products::findOne($_GET['id']);
                } else {
                    $update = new Products();
                }
                $update->name_product = $model->name_product;
                $update->price = $model->price;
                $update->price_old = $model->price_old;
                $update->description = $model->description;
                $update->count = $model->count;
                $update->code = $model->code;
                $update->id_category = $model->id_category;
                $update->img_product = $model->img_product;
                $update->save();
                return $this->redirect(['page/admin_listproducts', 'id' => $update->id_category]);
            }
            $cats = Categories::find()->select(['id', 'name_category'])->asArray()->all();
            $categories = [];
            foreach ($cats as $category) {
                $categories[$category['id']] = $category['name_category'];
            }
            if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $product = Products::find()->where(['id' => $_GET['id']])->asArray()->one();
                return $this->render('addproduct', compact('product', 'model', 'categories'));
            } else {
                return $this->render('addproduct', compact('model', 'categories'));
            }
        } else {
            return $this->goHome();
        }
    }

    public function actionAddcharacteristic()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login_user === 'admin') {
            $model = new AddCharacteristicForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate() && isset($_GET['product'])) {
                if (isset($_GET['id'])) {
                    $update = Characteristics::findOne($_GET['id']);
                } else {
                    $update = new Characteristics();
                }
                $update->name_сharacteristic = $model->name;
                $update->description_сharacteristic = $model->description;
                $update->id_product = $_GET['product'];
                $update->save();
                return $this->redirect(['page/admin_product', 'id' => $update->id_product]);
            } else {
                if (isset($_GET['id'])) {
                    $char = Characteristics::find()->where(['id_сharacteristic'=>$_GET['id']])->asArray()->one();
                    return $this->render('addcharacteristic', ['model' => $model, 'product' => $_GET['product'],
                        'char'=>$char]);}else{
                    return $this->render('addcharacteristic', ['model' => $model, 'product' => $_GET['product']]);
                }
            }
        } else {
            return $this->goHome();
        }
    }

    public
    function actionDeletecategory()
    {
        if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $category = Categories::findOne($_GET['id']);
            $category->delete();
        }
        return $this->redirect(['page/admin']);
    }

    public
    function actionDeletecharacteristic()
    {
        if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)
            && isset($_GET['product']) && filter_var($_GET['product'], FILTER_VALIDATE_INT)) {
            $char = Characteristics::findOne($_GET['id']);
            $char->delete();
        }
        return $this->redirect(['page/admin_product']);
    }

    public
    function actionDeleteproduct()
    {
        if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $product = Products::findOne($_GET['id']);
            $product->delete();
            SpecCart::deleteAll(['id_product' => $_GET['id']]);
            Reviews::deleteAll(['id_product' => $_GET['id']]);
            Wishlist::deleteAll(['id_product' => $_GET['id']]);
        }
        return $this->redirect(['page/admin_listproducts', 'id' => $_GET['category_id']]);
    }
}

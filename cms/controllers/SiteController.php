<?php

namespace app\controllers;

use app\models\SpecWishlist;
use app\models\Wishlist;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Products;
use app\models\RegistrationForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        $product_array = Products::find()->asArray()->all();
        if (!Yii::$app->user->isGuest){
            $userId = Yii::$app->user->id;
            $wish = Wishlist::findOne(['id_user'=>$userId]);
            foreach ($product_array as $key=>$product) {
                $product_array[$key]['wishlist'] = SpecWishlist::find()
                    ->where(['id_wishlist'=>$wish->id_wishlist, 'id_product'=>$product['id']])->count();
            }}

        return $this->render('index', compact('product_array'));
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->login_user = $model->login_user;
            $user->password_user = Yii::$app->security->generatePasswordHash($model->password_user);
            $user->name_user = $model->name_user;
            $user->email_user = $model->email_user;
            $user->telephone_user = $model->telephone_user;
            $user->region_user = $model->region_user;
            $user->city_user = $model->city_user;
            if ($user->save()) {
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }
        return $this->render('registration', compact('model'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAdmin()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login_user === 'admin'){
            return $this->render('admin');
        }
        else{
            return $this->goHome();
        }
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}

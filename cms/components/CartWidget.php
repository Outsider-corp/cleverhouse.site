<?php

namespace app\components;

use app\models\Cart;
use app\models\SpecCart;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;


class CartWidget extends Widget
{
    public $count;

    public function init()
    {
        parent::init();

        if (Yii::$app->user->isGuest) {
            $session = Yii::$app->session;
//        $session->destroy();
            $session->open();

            if ($session->has('productsSession')) {
                $productsSession = $session->get('productsSession');


                if (isset($productsSession) && is_array($productsSession) && count($productsSession) > 0) {
                    $this->count = count($productsSession);
                } else {
                    $this->count = 0;
                }
            } else {
                $this->count = 0;
            }
        } else {
            $userId = Yii::$app->user->id;
            $productCount = SpecCart::find()
                ->joinWith('cart')
                ->where(['cart.id_user' => $userId])
                ->sum('count');
            $this->count = ($productCount !== null) ? $productCount : 0;
        }
        if ($this->count === null) {
            $this->count = 0;
        }
    }

    public
    function run()
    {
        echo "<a href='" . Url::toRoute('page/cart') . "'>
                <i class='glyphicon glyphicon-shopping-cart'></i>
                <span>" . $this->count . "</span>
              </a>";


    }
}
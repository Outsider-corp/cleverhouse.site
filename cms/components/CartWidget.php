<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;


class CartWidget extends Widget
{
    public $count;
    function __construct(){
        $session = Yii::$app->session;
//        $session->destroy();
        $session->open();

        if($session->has('productsSession')){
            $productsSession = $session->get('productsSession');
        }

        if(isset($productsSession) &&
            is_array($productsSession)
            && count($productsSession) > 0){
            $this->count = count($productsSession);
        }
        else{
            $this->count = 0;
        }
    }

    public function run(){
        echo "<a href='".Url::toRoute('page/cart')."'>
                <i class='glyphicon glyphicon-shopping-cart'></i>
                <span>".$this->count."</span>
              </a>";


    }
}
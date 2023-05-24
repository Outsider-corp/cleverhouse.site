<?php

namespace app\models;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public static function tableName()
    {
        return 'cart';
    }

    public function getSpecCarts(){
        return $this->hasMany(SpecCart::class, ['id_cart' => 'id_cart']);
    }
}

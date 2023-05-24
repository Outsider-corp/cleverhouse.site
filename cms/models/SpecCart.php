<?php

namespace app\models;

use yii\db\ActiveRecord;

class SpecCart extends ActiveRecord
{
    public static function tableName()
    {
        return 'spec_cart';
    }

    public function getCart()
    {
        return $this->hasOne(Cart::class, ['id_cart' => 'id_cart']);
    }
}

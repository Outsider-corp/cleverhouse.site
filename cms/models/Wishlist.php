<?php

namespace app\models;

use yii\db\ActiveRecord;

class Wishlist extends ActiveRecord
{
    public static function tableName()
    {
        return 'wishlist';
    }

    public function getSpecWishlists()
    {
        return $this->hasMany(SpecWishlist::class, ['id_wishlist' => 'id_wishlist'])->asArray()->all();
    }
}

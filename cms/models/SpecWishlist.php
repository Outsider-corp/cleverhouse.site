<?php

namespace app\models;

use yii\db\ActiveRecord;

class SpecWishlist extends ActiveRecord
{
    public static function tableName()
    {
        return 'spec_wishlist';
    }

    public function getWishlist()
    {
        return $this->hasOne(Wishlist::class, ['id_wishlist' => 'id_wishlist']);
    }

}

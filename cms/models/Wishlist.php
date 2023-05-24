<?php

namespace app\models;
use yii\db\ActiveRecord;

class Wishlist extends ActiveRecord
{
    public static function tableName()
    {
        return 'spec_wishlist';
    }
}

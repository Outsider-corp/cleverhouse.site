<?php

namespace app\models;
use yii\db\ActiveRecord;

class Products extends ActiveRecord
{
    public static function tableName()
    {
        return 'products';
    }

    public function getCharacteristics()
    {
        return $this->hasMany(Characteristics::class, ['id_product' => 'id']);
    }
}

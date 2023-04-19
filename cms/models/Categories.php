<?php

namespace app\models;
use yii\db\ActiveRecord;

class Categories extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }
}

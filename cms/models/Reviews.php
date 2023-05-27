<?php

namespace app\models;
use yii\db\ActiveRecord;

class Reviews extends ActiveRecord
{
    public static function tableName()
    {
        return 'reviews';
    }
}

<?php

namespace app\models;
use yii\db\ActiveRecord;

class Characteristics extends ActiveRecord
{
    public static function tableName()
    {
        return 'characteristics';
    }
}

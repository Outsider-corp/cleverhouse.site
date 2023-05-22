<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SearchForm extends Model
{
    public $text; // сортировать по правилу

    public function search()
    {
        return [
            [['str', 'number'], 'trim'],
        ];
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FilterForm extends Model
{
    public $price_from; // начальная цена
    public $price_to; // конечная цена
    public $volume; // по сколько товаров выводить на странице

    public function rules()
    {
        return [
            [['price_from', 'price_to'], 'integer'],
            [['volume'], 'each', 'rule' => ['integer']],
        ];
    }
}

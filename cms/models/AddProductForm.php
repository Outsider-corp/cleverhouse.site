<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddProductForm extends Model
{
    public $name_product;
    public $price;
    public $price_old;
    public $description;
    public $count;
    public $code;
    public $id_category;
    public $img_product;

    public function rules()
    {
        return [
            [['name_product', 'img_product', 'description', 'code'], 'trim'],
            [['name_product', 'img_product', 'code', 'price', 'id_category'], 'required'],
            [['name_product', 'code'], 'string', 'length' => [1, 30]],
            [['count', 'price', 'price_old', 'id_category'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name_product' => 'Название товара',
            'price' => 'Цена',
            'price_old' => 'Старая цена',
            'description' => 'Описание',
            'count' => 'Количество',
            'code' => 'Артикул',
            'id_category' => 'Категория',
            'img_product' => 'Изображение',
        ];
    }
}

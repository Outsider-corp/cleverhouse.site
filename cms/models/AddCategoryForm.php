<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddCategoryForm extends Model
{
    public $name;
    public $img;
    public $description;

    public function rules()
    {
        return [
            [['name', 'img', 'description'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'length' => [1, 30]],
            [['img'], 'string', 'length' => [0, 30]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название категории',
            'img' => 'Изображение для категории',
            'description' => 'Описание',

        ];
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddCharacteristicForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name', 'description'], 'trim'],
            [['name', 'description'], 'required'],
            [['name', 'description'], 'string', 'length' => [1, 30]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название характеристики',
            'description' => 'Описание',
        ];
    }
}

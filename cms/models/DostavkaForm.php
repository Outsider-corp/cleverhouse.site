<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class DostavkaForm extends Model
{
    public $attribute;
    public $oplata;

    public function rules()
    {
        return [
            [['attribute'], 'required', 'message' => "Выберите способ доставки"],
            [['oplata'], 'required', 'message' => "Выберите способ оплаты"],
        ];
    }

    public function attributeLabels()
    {
        return [
            'attribute' => 'Выберите способ доставки',
            'oplata' => 'Выберите способ оплаты',
        ];
    }
}

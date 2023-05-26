<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddressForm extends Model
{
    public $city;
    public $region;
    public $address;

    public function rules()
    {
        return [
            [['city', 'region', 'address'], 'trim'],
            [['city', 'region', 'address'], 'required'],
            ['region', 'match', 'pattern' => '/[0-9]*$/'],
            ['region', 'string', 'length' => [5, 15]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city' => 'Город',
            'region' => 'Индекс',
            'address' => 'Адрес (улица, дом,...)',

        ];
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddCartForm extends Model
{
    public $value;

    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['value'], 'required'],
        ];
    }

}

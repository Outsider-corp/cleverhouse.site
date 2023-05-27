<?php

namespace app\models;

use yii\base\Model;

class ReviewForm extends Model
{
    public $text;
    public $rating;

    public function rules()
    {
        return [
            ['rating', 'integer'],
            ['text', 'required'],
            ['text', 'trim'],
            ['text', 'string', 'min' => 2],
        ];
    }

    public function reset(){
        $this->text = null;
        $this->rating = null;
    }
}

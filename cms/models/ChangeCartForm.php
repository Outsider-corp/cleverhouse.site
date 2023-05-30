<?php
namespace app\models;

use yii\base\Model;

class ChangeCartForm extends Model
{
    public $values = array();

    public function rules()
    {
        return [
            ['values', 'each', 'rule' => ['integer']],
        ];
    }
}
?>

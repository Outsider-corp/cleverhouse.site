<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{

    public $name_user;
    public $telephone_user;
    public $email_user;
    public $region_user;
    public $city_user;
    public $login_user;
    public $password_user;

    public function rules()
    {
        return [
            [['name_user', 'email_user', 'login_user', 'password_user'], 'required'],
            [['name_user', 'email_user', 'login_user', 'password_user', 'region_user', 'city_user', 'telephone_user'], 'trim'],
            ['email_user', 'email'],
            ['email_user', 'string', 'max' => 20],
            [['email_user'], 'unique', 'targetClass' => 'app\models\User'],
            [['login_user'], 'unique', 'targetClass' => 'app\models\User', 'message' => 'Этот логин уже занят'],
            ['telephone_user', 'match', 'pattern' => '/[0-9+()-]*$/'],
            ['telephone_user', 'string', 'length' => [10, 15]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name_user' => 'Имя*',
            'email_user' => 'E-mail*',
            'login_user' => 'Логин*',
            'password_user' => 'Пароль*',
            'telephone_user' => 'Телефон',
            'region_user' => 'Регион',
            'city_user' => 'Город',

        ];
    }
}
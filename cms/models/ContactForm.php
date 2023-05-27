<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'subject', 'body'], 'trim'],
            ['email', 'required', 'message' => 'Вы не ввели E-mail, на который придёт ответ'],
            ['subject', 'required', 'message' => 'Введите тему обращения'],
            ['body', 'required', 'message' => 'Введите текст письма'],
            ['email', 'email'],
            ['email', 'string', 'max' => 50],
            ['subject', 'string', 'max' => 100],
//            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email'=>'E-mail',
            'body'=>'Текст',
            'subject'=>'Тема письма',
//            'verifyCode' => 'Verification Code',
        ];
    }

    public function sendEmail($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo('cleverhouse@internet.ru')
                ->setFrom('cleverhouse@internet.ru')
                ->setSubject($this->subject . " от " . $this->email)
                ->setTextBody($this->body)
                ->send();
            $text = "Спасибо за обратную связь, мы Вам ответим в ближайшее время. \n Текст Вашего письма:\n" . $this->body;
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom('cleverhouse@internet.ru')
                ->setSubject($this->subject)
                ->setTextBody($text)
                ->send();

            return true;
        }
        return false;
    }
}

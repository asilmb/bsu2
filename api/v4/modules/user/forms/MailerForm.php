<?php
/**
 * Created by PhpStorm.
 * User: Asylbek
 * Date: 18.11.2017
 * Time: 10:40
 */

namespace api\v4\modules\user\forms;

//models/MailerForm.php


use Yii;
use yii\base\Model;

class MailerForm extends Model
{
    public $fromEmail;
    public $fromName;
    public $toEmail;
    public $subject;
    public $body;

    public function rules()
    {
        return [
            [['fromEmail', 'fromName', 'body'], 'required'],
            ['fromEmail', 'email'],
            ['toEmail', 'email'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'fromEmail' => 'Email-адрес',
            'body' => 'Сообщение',
            'fromName' => 'Имя',
            'subject' => 'Тема',
        ];
    }
    public function sendEmail()
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($this->toEmail)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->getSubject())
                ->setTextBody($this->getBody())
                ->send();

            return true;
        }
        return false;
    }

    public function getSubject()
    {
        return 'Обращение прислал '. $this->fromName;
    }

    public function getBody()
    {
        return $this->body . "\n".'Адрес обратной связи ' . $this->fromEmail;
    }


}
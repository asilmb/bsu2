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
            [['fromEmail', 'fromName', 'toEmail', 'subject', 'body'], 'required'],
            ['fromEmail', 'email'],
            ['toEmail', 'email']
        ];
    }

    public function sendEmail()
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($this->toEmail)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }

    /**
     * @param mixed $toEmail
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = Yii::$app->params['workMail'];
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = Yii::$app->params['workMailSubject'];;
    }
}
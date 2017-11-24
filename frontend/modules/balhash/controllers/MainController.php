<?php

namespace frontend\modules\balhash\controllers;

use api\v4\modules\user\forms\MailerForm;
use Yii;
use yii\web\Controller;

class MainController extends Controller
{

    public function actionIndex()
    {
        $body = null;
        $news = Yii::$app->content->news->all();
        $extraNews = Yii::$app->content->extraNews->all();
        $directorMailModel = new MailerForm();
        if (!empty(Yii::$app->request->post())) {
            $body = Yii::$app->request->post();
            $body['MailerForm']['subject'] = Yii::$app->params['workMailSubject'];
            $body['MailerForm']['toEmail'] = Yii::$app->params['workMail'];
        }
        if ($directorMailModel->load($body) && $directorMailModel->sendEmail()) {
            Yii::$app->session->setFlash('mailerFormSubmitted');
            return $this->refresh();
        }
        return $this->render('index', ['news' => $news, 'extraNews' => $extraNews, 'directorMailModel' => $directorMailModel]);
    }

    public function actionNews($id = null)
    {
        $news = Yii::$app->content->news->all();
        if (empty($id)) {

            return $this->render('news/viewAll', ['news' => $news]);
        }
        $newsEntity = Yii::$app->content->news->oneById($id);
        return $this->render('news/view', ['newsEntity' => $newsEntity, 'news' => $news]);
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }
}

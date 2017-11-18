<?php

namespace frontend\modules\balhash\controllers;

use api\v4\modules\user\forms\MailerForm;
use Yii;
use yii\web\Controller;

class MainController extends Controller
{

    public function actionIndex()
    {
        $news = Yii::$app->content->news->all();
        $extraNews = Yii::$app->content->extraNews->all();
        return $this->render('index', ['news' => $news, 'extraNews' => $extraNews]);
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
    public function actionMailer()
    {
        $model = new MailerForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendEmail()) {
            Yii::$app->session->setFlash('mailerFormSubmitted');
            return $this->refresh();
        }
        return $this->render('mailer', [
            'model' => $model,
        ]);
    }

}

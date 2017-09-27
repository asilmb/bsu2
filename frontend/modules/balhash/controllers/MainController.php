<?php

namespace frontend\modules\balhash\controllers;

use Yii;
use yii\web\Controller;

class MainController extends Controller {
	
	public function actionIndex() {
		$news = Yii::$app->content->news->all();
		return $this->render('index', ['news' => $news]);
	}
    public function actionNews($id = null) {
	    if(empty($id)){
            $news = Yii::$app->content->news->all();
            return $this->render('news/viewAll', ['news' => $news]);
        }
        $newsEntity = Yii::$app->content->news->oneById($id);
        return $this->render('news/view', ['newsEntity' => $newsEntity]);
    }
}

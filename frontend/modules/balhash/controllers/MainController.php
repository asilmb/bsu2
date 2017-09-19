<?php

namespace frontend\modules\balhash\controllers;

use Yii;
use yii\web\Controller;

class MainController extends Controller {
	
	public function actionIndex() {
		$news = Yii::$app->content->news->all();
		return $this->render('index', ['news' => $news]);
	}
	
}

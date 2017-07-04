<?php

namespace frontend\modules\welcome\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{

	public function actionIndex()
	{
		return $this->render('index');
	}

}

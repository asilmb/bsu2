<?php
namespace backend\modules\app\controllers;

use Yii;
use yii\web\Controller;

class LangController extends Controller
{
	
	public function actionIndex()
	{
		return $this->render('index');
	}
	
}


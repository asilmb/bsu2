<?php

namespace frontend\modules\balhash\contrebution;

use yii\web\Controller;


class BalhashController extends Controller {
	
	public function beforeAction($action) {
		
		//$this->layout = 'main';
		
		return parent::beforeAction($action);
		
	}
	
}

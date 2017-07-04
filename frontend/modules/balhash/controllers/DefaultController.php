<?php

namespace frontend\modules\balhash\controllers;

use frontend\modules\balhash\contrebution\BalhashController;

class DefaultController extends BalhashController {
	
	public function actionIndex() {
		return $this->render('index');
	}
	
}

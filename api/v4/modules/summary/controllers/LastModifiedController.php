<?php

namespace api\v4\modules\summary\controllers;

use yii2lab\rest\rest\Controller;
use api\v4\modules\summary\models\Modified;

class LastModifiedController extends Controller
{
	
	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'index' => ['GET'],
		];
	}
	
	public function actionIndex()
	{
		return Modified::getList();
	}
	
}

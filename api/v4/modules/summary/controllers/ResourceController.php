<?php

namespace api\v4\modules\summary\controllers;

use Yii;
use yii2lab\rest\rest\Controller;

class ResourceController extends Controller
{
	
	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'tree' => ['GET'],
		];
	}
	
	public function actionTree()
	{
		return Yii::$app->summary->summary->all;
	}
}

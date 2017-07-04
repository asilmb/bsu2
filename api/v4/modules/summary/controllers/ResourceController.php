<?php

namespace api\v4\modules\summary\controllers;

use yii2lab\rest\rest\Controller;
use api\v4\modules\summary\helpers\ResourceHelper;

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
		return ResourceHelper::getTree();
	}
}

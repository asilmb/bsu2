<?php

namespace common\modules\user;

use Yii;
use yii\base\Module as YiiModule;
use yii\web\NotFoundHttpException;

/**
 * user module definition class
 */
class Module extends YiiModule
{
	
	public static $langDir = 'api/v4/modules/user/messages';
	
	public function beforeAction($action)
	{
		$controller = $action->controller->id;
		if(APP == BACKEND && in_array($controller, ['password', 'reg'])) {
			throw new NotFoundHttpException();
		}
		return parent::beforeAction($action);
	}

}

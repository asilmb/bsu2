<?php

namespace yii2lab\helpers\menu;

use Yii;

class ActiveHelper
{

	protected static $currentRoute;

	protected function GetCurrentRoute()
	{
		if(empty(self::$currentRoute)) {
			self::$currentRoute = SL .
				Yii::$app->controller->module->id . SL .
				Yii::$app->controller->id . SL .
				Yii::$app->controller->action->id;
		}
		return self::$currentRoute;
	}

	/**
	 * Get user
	 * @return User
	 */
	public function getUser()
	{
		//if (!$this->_user instanceof User) {
		//	$this->_user = Instance::ensure($this->_user, User::className());
		//}
		//return $this->_user;
		return Instance::ensure('user', User::className());
	}

	public function check($route)
	{
		$currentRoute = self::GetCurrentRoute();

		if($route[0] != '/') {
			if($route == Yii::$app->controller->action->id) {
				$route = $currentRoute;
			} else {
				$route = $currentRoute . '/' . $route;
			}
		}

		$pos = strpos($currentRoute, $route);
		return $pos === 0;
	}
}
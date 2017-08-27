<?php

namespace common\helpers;

use yii\helpers\ArrayHelper;

class ApiVersionCofig {
	
	static function configFileName($name) {
		$versionConfig = ROOT_DIR . DS . 'api' . DS . API_VERSION_STRING . DS . 'config' . DS . $name . '.php';
		return $versionConfig;
	}
	
	static function load($name, $config) {
		if(API_VERSION) {
			$configFileName = self::configFileName($name);
			$versionConfig = include($configFileName);
			return ArrayHelper::merge($config, $versionConfig);
		} else {
			return $config;
		}
	}
	
}

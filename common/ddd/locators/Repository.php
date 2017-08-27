<?php

namespace common\ddd\locators;

use yii\helpers\ArrayHelper;

class Repository extends Base {
	
	protected function genClassName($id, $config) {
		/** @var string $class */
		$driver = $this->getDriverFromConfig($config);
		$class = 'repositories\\' . $driver . '\\' . ucfirst($id) . 'Repository';
		return $class;
	}
	
	private function getDriverFromConfig($config) {
		if(!empty($config)) {
			if(is_array($config)) {
				$driver = ArrayHelper::getValue($config, 'driver');
			} else {
				$driver = $config;
			}
		}
		if(empty($driver)) {
			$driver = $this->domain->defaultDriver;
		}
		return $driver;
	}
	
}
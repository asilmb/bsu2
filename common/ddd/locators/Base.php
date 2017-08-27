<?php

namespace common\ddd\locators;

use yii\di\ServiceLocator;

abstract class Base extends ServiceLocator {
	
	public $domain;
	
	public function setComponents($components) {
		$components = $this->genConfigs($components);
		parent::setComponents($components);
	}
	
	private function genConfigs($components) {
		$configNew = [];
		foreach($components as $id => &$config) {
			if(is_integer($id)) {
				$id = $config;
				$config = null;
			}
			$configNew[$id] = $this->genConfig($id, $config);
		}
		return $configNew;
	}
	
	private function genConfig($id, $config) {
		$resultConfig = [];
		if(is_array($config)) {
			$resultConfig = $config;
		} else {
			if($this->isClass($config)) {
				$resultConfig['class'] = $config;
			}
		}
		if(empty($resultConfig['class'])) {
			$resultConfig['class'] = $this->domain->path . BSL . $this->genClassName($id, $config);
		}
		$resultConfig['id'] = $id;
		$resultConfig['domain'] = $this->domain;
		return $resultConfig;
	}
	
	private function isClass($name) {
		return strpos($name, '\\') !== false;
	}
	
	abstract protected function genClassName($id, $config);
	
}
<?php

namespace common\services;

use yii\base\Component;

class BaseService extends Component {
	
	use ErrorTrait;
	
	public $repositoryClass = 'Repository';
	protected $repository;
	
	public function init() {
		parent::init();
		if(!empty($this->repositoryClass)) {
			$this->repository = $this->getInstanceOfClassName($this->repositoryClass);
		}
	}
	
	private function getInstanceOfClassName($class) {
		parent::init();
		if(empty($class)) {
			return null;
		}
		if(mb_strpos($class, '\\') === false) {
			$namespace = $this->getNamespaceOfClassName(static::className());
			$class = $namespace . '\\' . $class;
		}
		if(class_exists($class)) {
			return new $class();
		}
		return null;
	}
	
	private function getNamespaceOfClassName($class) {
		$lastSlash = strrpos($class, '\\');
		return substr($class, 0, $lastSlash);
	}
}
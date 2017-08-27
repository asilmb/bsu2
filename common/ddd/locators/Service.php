<?php

namespace common\ddd\locators;

class Service extends Base {
	
	protected function genClassName($id, $config) {
		$class = 'services\\' . ucfirst($id) . 'Service';
		return $class;
	}
	
}
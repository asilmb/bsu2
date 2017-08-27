<?php

namespace api\v4\modules\service\helpers;

use yii\helpers\ArrayHelper;

class DynamicRulesHelper {
	
	private $rules;
	
	public function getRules($fields) {
		$this->rules = [];
		$fields = ArrayHelper::toArray($fields);
		foreach($fields as $field) {
			$this->fieldRules($field);
		}
		return $this->rules;
	}
	
	private function addRule($name, $type, $param) {
		$param = $this->cleanEmptyParams($param);
		$param = $this->paramMapping($param);
		$type = $this->typeMapping($type);
		
		$rule = [$name, $type];
		$rule = ArrayHelper::merge($rule, $param);
		return $this->rules[] = $rule;
	}
	
	private function fieldRules($field)
	{
		if(!empty($field['validations'])) {
			$this->extractValidations($field);
		}
		if(!empty($field['values'])) {
			$this->extractOptions($field);
		}
	}
	
	private function typeMapping($name)
	{
		$typeList = [
			'numerical' => 'number',
			'length' => 'string',
		];
		if(isset($typeList[$name])) {
			return $typeList[$name];
		}
		return $name;
	}
	
	private function paramMapping($params)
	{
		$typeList = [
			'allowEmpty' => 'skipOnEmpty',
			'is' => null,
		];
		foreach($typeList as $from => $to) {
			if(isset($params[$from])) {
				if($typeList[$from] !== null) {
					$params[$to] = $params[$from];
				}
				unset($params[$from]);
			}
		}
		return $params;
	}
	
	private function cleanEmptyParams($params)
	{
		if(empty($params)) {
			return [];
		}
		foreach($params as $name => $value) {
			if(is_string($value) && empty($value)) {
				unset($params[$name]);
			}
		}
		return $params;
	}
	
	private function extractValidations($field)
	{
		foreach($field['validations'] as $validation) {
			$this->addRule($field['name'], $validation['type'], $validation['param']);
		}
	}
	
	private function extractOptions($field)
	{
		if(!empty($field['values'])) {
			$range = ArrayHelper::getColumn($field['values'], 'key');
			$param = ['range' => $range];
			$this->addRule($field['name'], 'in', $param);
		}
	}
	
}

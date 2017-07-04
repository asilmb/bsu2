<?php

namespace common\ddd;

use common\ddd\helpers\Helper;
use ReflectionClass;
use yii\base\Arrayable;


class BaseEntity extends Component implements Arrayable {

	private $old_attributes = [];
	private $isNew = true;

	public function extraFields() {
		return [];
	}

	public function hideIfNullFields() {
		return [];
	}
	
	public static function primaryKey() {
		return [];
	}

	public function init() {}

	public function fields()
	{
		$fields = $this->attributes();
		$fields = array_diff($fields, $this->extraFields());
		return array_combine($fields, $fields);
	}

	public function __construct($config = [], $isNew = true)
	{
		if(!empty($config)) {
			$this->old_attributes = $this->setAttributes($config);
		}
		$this->isNew = $isNew;
		$this->init();
	}

	public function getIsNew()
	{
		return $this->isNew;
	}
	
	public function getPrimaryKey($asArray = false)
	{
		$keys = $this->primaryKey();
		$attributes = $this->toArray();
		if (!$asArray && count($keys) === 1) {
			return isset($attributes[$keys[0]]) ? $attributes[$keys[0]] : null;
		} else {
			$values = [];
			foreach ($keys as $name) {
				$values[$name] = isset($attributes[$name]) ? $attributes[$name] : null;
			}
			return $values;
		}
	}
	
	public function toArray(array $fields = [], array $expand = [], $recursive = true) {
		if(empty($fields)) {
			$fields = $this->fields();
		}
		//$fields = $this->hideNullFields($fields);
		$fields = $this->addExtraFields($fields, $expand);
		
		$result = [];
		foreach($fields as $name) {
			$value = $this->getFieldValue($name);
			$isHide = $value === null && $this->isInHiddenFieldOnNull($name);
			if(!$isHide) {
				$result[$name] = Helper::toArray($value);
			}
		}
		return $result;
	}

	protected function addExtraFields($fields, $expand) {
		$extra = $this->extraFields();
		if(empty($extra)) {
			return $fields;
		}
		foreach($expand as $field) {
			if(in_array($field, $extra)) {
				$fields[$field] = $field;
			}
		}
		return $fields;
	}
	
	public function load($attributes)
	{
		$this->setAttributes($attributes);
	}
	
	protected function setAttributes($attributes)
	{
		if(empty($attributes) || !is_array($attributes)) {
			return null;
		}
		$old_attributes = [];
		foreach($attributes as $name => $value) {
			if(isset($attributes[$name]) && $this->isVisibleField($name)) {
				$value = Helper::toArray($attributes[$name]);
				$old_attributes[$name] = $this->setFieldValue($name, $value);
			}
		}
		return $old_attributes;
	}

	protected function isVisibleField($name)
	{
		$class = new ReflectionClass($this);
		if(!$class->hasProperty($name)) {
			return false;
		}
		$property = $class->getProperty($name);
		$isVisible = $property->isProtected() || $property->isPublic();
		$isValidName = $name[0] != '_';
		return !$property->isStatic() && $isVisible && $isValidName;
	}

	protected function attributes()
	{
		$class = new ReflectionClass($this);
		$names = [];
		foreach ($class->getProperties() as $property) {
			$name = $property->getName();
			if ($this->isVisibleField($name)) {
				$names[] = $name;
			}
		}
		return $names;
	}

	private function isInHiddenFieldOnNull($name) {
		$hide = $this->hideIfNullFields();
		if(empty($hide)) {
			return false;
		}
		return !is_array($hide) || in_array($name, $hide);
	}
	
	/*private function hideNullFields($fields) {
		$hide = $this->hideIfNullFields();
		if($hide) {
			foreach($fields as $name => $value) {
				
				$isEmpty = $this->getFieldValue($name) === null;
				if($isForHidden && $isEmpty) {
					unset($fields[$name]);
				}
			}
		}
		return $fields;
	}*/

	private function getFieldValue($name)
	{
		$method = $this->magicMethodName($name, 'get');
		if(method_exists($this, $method)) {
			$value = $this->$method();
		} else {
			$value = $this->$name;
		}
		return $value;
	}

	private function setFieldValue($name, $value)
	{
		$method = $this->magicMethodName($name, 'set');
		if(method_exists($this, $method)) {
			$this->$method($value);
		} else {
			$this->$name = $value;
		}
		return $this->$name;
	}

}
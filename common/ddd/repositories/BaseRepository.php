<?php

namespace common\ddd\repositories;

use common\ddd\Alias;
use common\ddd\data\Query;
use common\ddd\factories\Factory;
use common\ddd\helpers\QueryValidator;
use Yii;
use yii\base\Component as YiiComponent;
use yii\helpers\ArrayHelper;

abstract class BaseRepository extends YiiComponent {
	
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_UPDATE = 'update';
	
	public $id;
	
	/** @var \common\ddd\Domain */
	public $domain;
	
	/** @var Alias */
	private $alias;
	
	/** @var \common\ddd\helpers\QueryValidator */
	private $queryValidator;
	public $driver;
	protected $primaryKey = 'id';
	
	public function scenarios() {
		$all = $this->allFields();
		$autoIncrementField = $this->autoIncrementField();
		$autoIncrementField = $this->alias->decode($autoIncrementField);
		if($autoIncrementField) {
			$all = array_diff($all, [$autoIncrementField]);
		}
		$scenario[ self::SCENARIO_INSERT ] = $all;
		$insert = $all;
		$scenario[ self::SCENARIO_INSERT ] = $insert;
		return $scenario;
	}
	
	public function autoIncrementField() {
		return null;
	}
	
	public function allFields() {
		return [];
	}
	
	public function uniqueFields() {
		return [];
	}
	
	public function whereFields() {
		return $this->allFields();
	}
	
	public function sortFields() {
		return $this->allFields();
	}
	
	public function selectFields() {
		return $this->allFields();
	}
	
	public function fieldAlias() {
		return [];
	}
	
	public function getAlias() {
		if(!isset($this->alias)) {
			$this->alias = new Alias();
			$this->alias->setAliases($this->fieldAlias());
		}
		return $this->alias;
	}
	
	public function getQueryValidator() {
		if(!isset($this->queryValidator)) {
			$this->queryValidator = Yii::createObject(QueryValidator::className());
			Yii::configure($this->queryValidator, ['repository' => $this]);
		}
		return $this->queryValidator;
	}
	
	protected function forgeQuery($query) {
		if($query instanceof Query) {
			return $query;
		}
		return new Query();
	}
	
	/**
	 * @param      $data
	 * @param null $class
	 *
	 * @return array|\common\ddd\BaseEntity
	 */
	public function forgeEntity($data, $class = null) {
		if(empty($data)) {
			return [];
		}
		if(empty($class)) {
			$class = $this->id;
		}
		$array = ArrayHelper::toArray($data);
		$array = $this->getAlias()->decode($array);
		return $this->domain->factory->entity->create($class, $array);
	}
	
}
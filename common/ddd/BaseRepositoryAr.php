<?php

namespace common\ddd;

use common\ddd\helpers\Helper;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\web\UnprocessableEntityHttpException;

class BaseRepositoryAr extends Component {
	
	protected $entityClass;
	protected $modelClass;
	protected $model;
	private $query;
	protected $privateKey;

	public function init() {
		parent::init();
		$this->initModel();
		$this->initEntityClass();
	}
	
	private function initModel() {
		$modelClass = $this->modelClass;
		$this->model = new $modelClass;
	}
	
	private function initEntityClass() {
		$class = static::className();
		$name = Helper::extractNameFromClass($class, 'Repository');
		$dir = Helper::dirLevelUp($class, 3);
		$entityClass = $dir . '\entities\\' . $name . 'Entity';
		$this->entityClass = $entityClass;
	}
	
	public function select($columns, $option = null) {
		$this->getQuery()->select($columns, $option);
		return $this;
	}
	
	public function with($condition) {
		$this->getQuery()->with($condition);
		return $this;
	}
	
	public function where($condition) {
		$this->getQuery()->where($condition);
		return $this;
	}
	
	public function limit($limit) {
		$this->getQuery()->limit($limit);
		return $this;
	}
	
	public function offset($offset) {
		$this->getQuery()->offset($offset);
		return $this;
	}
	
	public function addOrderBy($columns) {
		$this->getQuery()->addOrderBy($columns);
		return $this;
	}
	
	public function orderBy($columns) {
		$this->getQuery()->orderBy($columns);
		return $this;
	}
	
	public function count() {
		$count = $this->getQuery()->count();
		$this->resetQuery();
		return $count;
	}
	
	public function all() {
		$all = $this->getQuery()->all();
		$collection = $this->forgeEntity($all);
		$this->resetQuery();
		return $collection;
	}
	
	public function one() {
		$item = $this->getQuery()->one();
		$entity = $this->forgeEntity($item);
		$this->resetQuery();
		return $entity;
	}
	
	public function findOne($condition) {
		$this->whereByPk($condition);
		$item = $this->one();
		$entity = $this->forgeEntity($item);
		return $entity;
	}
	
	public function findAll($condition) {
		$this->where($condition);
		$item = $this->all();
		return $this->forgeEntity($item);
	}
	
	public function encodeAlias($name) {
		if(is_array($name)) {
			$result = [];
			foreach ($name as $item) {
				$result[] = $this->encodeAlias($item);
			}
			return $result;
		}
		$aliases = $this->fieldAlias();
		if(isset($aliases[$name])) {
			return $aliases[$name];
		}
		return $name;
	}
	
	public function decodeAlias($name) {
		if(is_array($name)) {
			$result = [];
			foreach ($name as $item) {
				$result[] = $this->decodeAlias($item);
			}
			return $result;
		}
		$aliases = $this->fieldAlias();
		$aliases = array_flip($aliases);
		if(isset($aliases[$name])) {
			return $aliases[$name];
		}
		return $name;
	}
	
	private function fillModel($model, BaseEntity $entity) {
		$attributes = $entity->toArray();
		foreach($attributes as $name => $value) {
			$fieldName = $this->encodeAlias($name);
			if(isset($model->$fieldName)) {
				$model->$fieldName = $value;
			}
		}
	}
	
	public function save(BaseEntity $entity) {
		$modelClass = $this->model->className();
		if($entity->getIsNew()) {
			$model = new $modelClass();
		} else {
			$model = $this->findByEntity($entity);
		}
		$this->fillModel($model, $entity);
		if(!$model->validate()) {
			throw new UnprocessableEntityHttpException();
		}
		$model->save();
	}
	
	public function whereByPk($condition) {
		$entityClass = $this->entityClass;
		$pk = $entityClass::primaryKey();
		if(is_array($condition)) {
			foreach($pk as $name) {
				$fieldName = $this->encodeAlias($name);
				$value = $condition[$name];
				$this->where([$fieldName => $value]);
			}
		} else {
			$fieldName = $this->encodeAlias($pk[0]);
			$this->where([$fieldName => $condition]);
		}
		return $this;
	}
	
	public function findByEntity(BaseEntity $entity) {
		$pk = $entity->getPrimaryKey(true);
		foreach($pk as $name => $value) {
			$fieldName = $this->encodeAlias($name);
			$this->where([$fieldName => $value]);
		}
		$model = $this->getQuery()->one();
		$this->resetQuery();
		return $model;
	}
	
	public function delete(BaseEntity $entity) {
		$model = $this->findByEntity($entity);
		return $model->delete();
	}

	public function __call___($method, $params) {
		/*if(in_array($method, ['findOne', 'findAll', 'one', 'all'])) {
			$data = call_user_func_array([$this->model, $method], $params);
			if(empty($data)) {
				return null;
			}
			return $data;
		}
		if(in_array($method, ['findOne', 'findAll'])) {
			$data = call_user_func_array([$this->model, $method], $params);
			return $this->forgeEntityCollection($data);
		}
		if(in_array($method, ['one', 'all'])) {
			$data = call_user_func_array([$this->query, $method], $params);
			return $this->forgeEntityCollection($data);
		}*/
		if(!empty($this->query)) {
			$obj = $this->query;
		} else {
			$obj = $this->model;
		}
		if(func_num_args() == 1) {
			return call_user_func_array([$obj, func_get_arg(0)], []);
		} elseif(func_num_args() > 1) {
			return call_user_func_array([$obj, func_get_arg(0)], func_get_arg(1));
		}
		return null;
	}

	protected function getQuery() {
		if($this->query === null) {
			$this->query = $this->model->find();
		}
		return $this->query;
	}
	
	protected function resetQuery() {
		$this->query = null;
	}

	protected function forgeEntity($data) {
		if(empty($data)) {
			return null;
		}
		//$entityClass = Helper::getClassName('Entity', static::className());
		return $this->forgeEntityCollection($data, $this->entityClass);
	}

	private function forgeEntityCollection($data, $class) {
		if(empty($data)) {
			return null;
		}
		if(!ArrayHelper::isIndexed($data)) {
			$array = ArrayHelper::toArray($data);
			return new $class($array, false);
		}
		$result = [];
		foreach($data as $item) {
			$result[] = $this->forgeEntityCollection($item, $class);
		}
		return $result;
	}

}
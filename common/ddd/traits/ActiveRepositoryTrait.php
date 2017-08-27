<?php

namespace common\ddd\traits;

use common\ddd\BaseEntity;
use common\ddd\data\Query;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;
use yii\web\NotFoundHttpException;

trait ActiveRepositoryTrait {
	
	public function isExistsById($id) {
		try {
			$this->oneById($id);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	public function isExists($condition) {
		/** @var Query $query */
		$query = $this->forgeQuery(null);
		if(is_array($condition)) {
			$query->whereFromCondition($condition);
		} else {
			$query->where($this->primaryKey, $condition);
		}
		try {
			$this->one($query);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	public function oneById($id, Query $query = null) {
		/** @var Query $query */
		$query = $this->forgeQuery($query);
		$query->removeParam('where');
		$query->where($this->primaryKey, $id);
		return $this->one($query);
	}
	
	public function one(Query $query = null) {
		$query = $this->forgeQuery($query);
		$model = $this->oneModel($query);
		if(empty($model)) {
			throw new NotFoundHttpException();
		}
		return $this->forgeEntity($model);
	}
	
	public function all(Query $query = null) {
		$query = $this->forgeQuery($query);
		$models = $this->allModels($query);
		return $this->forgeEntity($models);
	}
	
	protected function oneModelByCondition($condition, Query $query = null) {
		/** @var Query $query */
		$query = $this->forgeQuery($query);
		$query->whereFromCondition($condition);
		$model = $this->oneModel($query);
		if(empty($model)) {
			throw new NotFoundHttpException();
		}
		return $model;
	}
	
	protected function allModelsByCondition($condition = [], Query $query = null) {
		/** @var Query $query */
		$query = $this->forgeQuery($query);
		$query->whereFromCondition($condition);
		$models = $this->allModels($query);
		return $models;
	}
	
	protected function findUniqueItem(BaseEntity $entity, $uniqueItem) {
		$condition = [];
		foreach($uniqueItem as $name) {
			$entityValue = $entity->{$name};
			if(!empty($entityValue)) {
				$condition[ $name ] = $entityValue;
			}
		}
		if(empty($condition)) {
			return;
		}
		try {
			$first = $this->oneModelByCondition($condition);
			$error = new ErrorCollection();
			foreach($uniqueItem as $name) {
				$error->add($name, 'db', 'already_exists {value}', ['value' => $entity->{$name}]);
			}
			throw new UnprocessableEntityHttpException($error);
		} catch(NotFoundHttpException $e) {
			
		}
	}
	
}
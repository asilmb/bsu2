<?php

namespace common\ddd;

use common\ddd\data\ActiveDataProvider;
use common\ddd\helpers\Helper;
use yii\base\Component;
use common\ddd\traits\ErrorTrait;
use yii\web\NotFoundHttpException;

class BaseService extends Component {
	
	use ErrorTrait;
	
	public $repositoryDriver = '';
	private $repository;
	
	public function init() {
		parent::init();
		$this->initRepository();
	}
	
	protected function splitStringParam($value) {
		return is_string($value) ? preg_split('/\s*,\s*/', $value, -1, PREG_SPLIT_NO_EMPTY) : [];
	}
	
	protected function setExpandParams($value) {
		if(!empty($value)) {
			$with = $this->splitStringParam($value);
			$with = $this->repository->encodeAlias($with);
			$this->repository->with($with);
		}
	}
	
	protected function setFieldsParams($value) {
		if(!empty($value)) {
			$fields = $this->splitStringParam($value);
			$fields = $this->repository->encodeAlias($fields);
			$this->repository->select($fields);
		}
	}
	
	protected function setAllParams($params = []) {
		if(empty($params)) {
			return false;
		}
		if(!empty($params['expand'])) {
			$this->setExpandParams($params['expand']);
		}
		if(!empty($params['fields'])) {
			$this->setFieldsParams($params['fields']);
		}
	}
	
	public function findOne($id, $params = []) {
		$this->setAllParams($params);
		$entity = $this->repository->findOne($id);
		if(empty($entity)) {
			throw new NotFoundHttpException();
		}
		return $entity;
	}
	
	public function getDataProvider($params = []) {
		$this->setAllParams($params);
		$dataProvider = new ActiveDataProvider([
			'query' => $this->getRepository(),
		]);
		return $dataProvider;
	}
	
	public function getRepository() {
		return $this->repository;
	}
	
	private function initRepository() {
		$class = static::className();
		$name = Helper::extractNameFromClass($class, 'Service');
		$dir = Helper::dirLevelUp($class, 2);
		$repositoryClass = $dir . '\repositories\\' . $this->repositoryDriver . '\\' . $name . 'Repository';
		$this->repository = new $repositoryClass;
	}

}
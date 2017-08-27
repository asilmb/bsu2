<?php

namespace common\ddd\services;

use common\ddd\BaseEntity;
use common\ddd\data\Query;
use common\ddd\helpers\ErrorCollection;
use common\ddd\interfaces\services\ModifyInterface;
use common\ddd\interfaces\services\ReadInterface;
use common\ddd\repositories\BaseRepository;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\base\ActionEvent;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ActiveBaseService extends BaseService implements ReadInterface, ModifyInterface {
	
	/** @var \common\ddd\BaseEntity */
	public $foreignServices;
	public $forbiddenChangeFields;
	
	/** @var bool private data for user */
	public $userAccessOnly = false;
	public $userIdField = 'user_id';
	
	private function userAccessOnly(Query $query) {
		if($this->userAccessOnly) {
			$userId = Yii::$app->account->auth->identity->id;
			$query->where($this->userIdField, "$userId");
		}
	}
	
	protected function addUserId(BaseEntity $entity) {
		if($this->userAccessOnly) {
			$userId = Yii::$app->account->auth->identity->id;
			$entity->{$this->userIdField} = $userId;
		}
	}
	
	public function isExistsById($id) {
		return $this->repository->isExistsById($id);
	}
	
	public function isExists($condition) {
		return $this->repository->isExists($condition);
	}
	
	/**
	 * @param            $id
	 * @param Query|null $query
	 *
	 * @return \common\ddd\BaseEntity $entity
	 * @throws NotFoundHttpException
	 * @throws \yii\web\ServerErrorHttpException
	 */
	public function oneById($id, Query $query = null) {
		$this->beforeAction(__FUNCTION__);
		$query = $this->forgeQuery($query);
		$this->userAccessOnly($query);
		$result = $this->repository->oneById($id, $query);
		if(empty($result)) {
			throw new NotFoundHttpException();
		}
		return $this->afterAction(__FUNCTION__, $result);
	}
	
	public function count(Query $query = null) {
		$this->beforeAction(__FUNCTION__);
		$query = $this->forgeQuery($query);
		$this->userAccessOnly($query);
		$result = $this->repository->count($query);
		return $this->afterAction(__FUNCTION__, $result);
	}
	
	public function all(Query $query = null) {
		$this->beforeAction(__FUNCTION__);
		$query = $this->forgeQuery($query);
		$this->userAccessOnly($query);
		$result = $this->repository->all($query);
		return $this->afterAction(__FUNCTION__, $result);
	}
	
	public function create($data) {
		$this->beforeAction(__FUNCTION__);
		$data = ArrayHelper::toArray($data);
		$this->validateForeign($data);
		$this->validateForbiddenChangeFields($data);
		/** @var \common\ddd\BaseEntity $entity */
		$entity = $this->domain->factory->entity->create($this->id, $data);
		
		$entity->validate();
		$this->addUserId($entity);
		$this->repository->insert($entity);
		return $this->afterAction(__FUNCTION__, null);
	}
	
	public function updateById($id, $data) {
		$this->beforeAction(__FUNCTION__);
		$data = ArrayHelper::toArray($data);
		$this->validateForeign($data);
		$this->validateForbiddenChangeFields($data);
		$entity = $this->oneById($id);
		$entity->load($data);
		$entity->validate();
		$this->addUserId($entity);
		$this->repository->update($entity);
		return $this->afterAction(__FUNCTION__, null);
	}
	
	public function deleteById($id) {
		$this->beforeAction(__FUNCTION__);
		$entity = $this->oneById($id);
		$this->addUserId($entity);
		$this->repository->delete($entity);
		return $this->afterAction(__FUNCTION__, null);
	}
	
	protected function ensureForeignConfig($config) {
		foreach($config as $service => &$serviceConfig) {
			if(empty($serviceConfig['field'])) {
				throw new InvalidConfigException('The "foreignServices.field" property must be set.');
			}
			if(empty($serviceConfig['notFoundMessage'])) {
				$serviceConfig['notFoundMessage'] = ['service', 'foreign_entity_not_found'];
			}
		}
		return $config;
	}
	
	protected function validateForbiddenChangeFields($data) {
		if(empty($this->forbiddenChangeFields)) {
			return;
		}
		foreach($this->forbiddenChangeFields as $fieldName) {
			if(!empty($data[ $fieldName ])) {
				$error = new ErrorCollection();
				$error->add($fieldName, 'service', 'forbidden_change_field {field}', ['field' => $fieldName]);
				throw new UnprocessableEntityHttpException($error);
			}
		}
	}
	
	protected function validateForeign($data) {
		if(empty($this->foreignServices)) {
			return;
		}
		$config = $this->ensureForeignConfig($this->foreignServices);
		foreach($config as $serviceKey => $serviceConfig) {
			$fieldName = $serviceConfig['field'];
			if(!empty($serviceConfig['isChild'])) {
				continue;
			}
			if(!empty($data[ $fieldName ])) {
				try {
					$serviceInstance = ArrayHelper::getValue(Yii::$app, $serviceKey);
					$entity = $serviceInstance->oneById($data[ $fieldName ]);
				} catch(NotFoundHttpException $e) {
					$notFoundMessage = $serviceConfig['notFoundMessage'];
					$error = new ErrorCollection();
					$error->add($fieldName, $notFoundMessage[0], $notFoundMessage[1]);
					throw new UnprocessableEntityHttpException($error);
				}
			}
		}
	}
	
	protected function beforeAction($action) {
		$event = new ActionEvent($action);
		$this->trigger(self::EVENT_BEFORE_ACTION, $event);
		if(!$event->isValid) {
			throw new ServerErrorHttpException('Service method "' . $action . '" not allow!');
		}
	}
	
	protected function afterAction($action, $result) {
		$event = new ActionEvent($action);
		$event->result = $result;
		$this->trigger(self::EVENT_AFTER_ACTION, $event);
		return $event->result;
	}
}
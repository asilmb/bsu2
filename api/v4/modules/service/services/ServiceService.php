<?php

namespace api\v4\modules\service\services;

use Yii;
use common\ddd\BaseService;
use yii\data\ArrayDataProvider;
use yii\web\ForbiddenHttpException;
use api\v4\modules\service\entities\ServiceEntity;

class ServiceService extends BaseService {
	
	public function getDataProvider($params = []) {
		if(!empty($params['category'])) {
			$all = Yii::$app->service->findAll($params);
			return $this->dataProviderForCategory($all, $params['category']);
		} else {
			return parent::getDataProvider($params);
		}
	}
	
	public function findAll($params) {
		return $this->repository->findAllByCategory($params['category']);
	}
	
	public function delete($id) {
		$entity = $this->findOne($id);
		if(Empty($entity)) {
			throw new ForbiddenHttpException();
		}
		return $this->repository->delete($entity);
	}

	public function update($id, $data) {
		$entity = $this->findOne($id);
		if(Empty($entity)) {
			throw new ForbiddenHttpException();
		}
		$entity->load($data);
		return $this->repository->save($entity);
	}
	
	public function create($data) {
		$entity = new ServiceEntity($data);
		$entity->load($data);
		return $this->repository->save($entity);
	}
	
	private function dataProviderForCategory($list) {
		$dataProvider = new ArrayDataProvider([
			'allModels' => $list,
			'pagination' => [
				'pageSize' => 99999999,
			],
		]);
		return $dataProvider;
	}
	
}

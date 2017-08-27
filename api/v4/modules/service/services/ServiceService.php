<?php

namespace api\v4\modules\service\services;

use common\ddd\data\Query;
use common\ddd\services\ActiveBaseService;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class ServiceService extends ActiveBaseService {
	
	public function allByCategoryId($categoryId) {
		$query = new Query;
		$query->where('category', $categoryId);
		$dataProvider = $this->getDataProvider($query);
		return $dataProvider->allModels;
	}

	public function getDataProvider(Query $query = null) {
		$category = $query->getParam('where.category', 'integer');
		if(!empty($category)) {
			$all = $this->repository->findAllByCategory($query);
			$sort = $query->getParam('order');
			if(!empty($sort)) {
				ArrayHelper::multisort($all, array_keys($sort), array_values($sort));
			}
			return $this->dataProviderForCategory($all);
		} else {
			return parent::getDataProvider($query);
		}
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

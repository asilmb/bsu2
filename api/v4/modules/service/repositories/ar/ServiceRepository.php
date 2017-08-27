<?php

namespace api\v4\modules\service\repositories\ar;

use common\ddd\data\Query;
use yii\helpers\ArrayHelper;
use common\ddd\repositories\ActiveArRepository;

class ServiceRepository extends ActiveArRepository {

	protected $modelClass = 'api\v4\modules\service\modelsDeco\Service';
	
	public function fieldAlias() {
		return [
			'id' => 'service_id',
			'name' => 'service_name',
			'title' => 'name',
			'description' => 'description_company',
		];
	}

	public function findAllByCategory(Query $query = null) {
		$category = $query->getParam('where.category', 'integer');
		if(!empty($category)) {
			$all = $this->getAllWithCategory($query, $category);
			$allChilds = $this->getChildList($query, $all);
			if(!empty($allChilds)) {
				$all = ArrayHelper::merge($all, $allChilds);
			}
		} else {
			$all = $this->all($query);
		}
		return $all;
	}

	private function getAllWithCategory(Query $query, $category) {
		$this->query->joinWith('serviceCategories');
		$this->query->where(['service_menu_service.service_menu_id' => $category]);
		$all = $this->query->all();
		$all = $this->forgeEntity($all);
		return $all;
	}

	private function getChildList(Query $query, $parentList) {
		$parentIds = ArrayHelper::getColumn($parentList, 'id');
		$this->query->where(['parent_id' => $parentIds]);
		$all = $this->query->all();
		$all = $this->forgeEntity($all);
		return $all;
	}

}
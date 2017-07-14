<?php

namespace api\v4\modules\service\repositories\ar;

use common\ddd\db\CrudQueryInterface;
use common\ddd\db\PaginationQueryInterface;
use yii\helpers\ArrayHelper;
use common\ddd\BaseRepositoryAr;

class ServiceRepository extends BaseRepositoryAr implements PaginationQueryInterface, CrudQueryInterface {

	protected $modelClass = 'api\v4\modules\service\modelsDeco\Service';
	protected $privateKey = 'id';
	
	public function fieldAlias() {
		return [
			'id' => 'service_id',
			'name' => 'service_name',
			'title' => 'name',
			'description' => 'description_company',
		];
	}

	public function findAllByCategory($category) {
		$category = intval($category);
		if(!empty($category)) {
			$this->query->joinWith('serviceCategories');
			$this->where(['service_menu_service.service_menu_id' => $category]);
		}
		$all = $this->all();
		if(!empty($category)) {
			$allChilds = $this->getChildList($all);
			if(!empty($allChilds)) {
				$all = ArrayHelper::merge($all, $allChilds);
			}
		}
		return $this->forgeEntity($all);
	}

	private function getChildList($parentList) {
		$parentList = ArrayHelper::toArray($parentList);
		$parentIds = ArrayHelper::getColumn($parentList, 'id');
		$this->where(['parent_id' => $parentIds]);
		$all = $this->all();
		return $this->forgeEntity($all);
	}

}
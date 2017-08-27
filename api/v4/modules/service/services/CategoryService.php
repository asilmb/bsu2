<?php

namespace api\v4\modules\service\services;

use common\ddd\data\Query;
use common\ddd\services\ActiveBaseService;
use Yii;

class CategoryService extends ActiveBaseService {

	public function allByParentId($parentId) {
		$query = new Query;
		$query->where('parent_id', $parentId);
		return $this->repository->all($query);
	}
	
	public function getCategoryById($categoryId) {
		$query = new Query;
		$query->where("id", $categoryId);
		return $this->repository->all($query);
	}
	
	public function allRoot() {
		$query = new Query;
		$id = Yii::$app->summary->summary->getId();
		$query->where('parent_id', $id['category_root']);
		return $this->repository->all($query);
	}
	
	public function categoriesTree() {
		$allCategories = $this->all();
		foreach($allCategories as $k => $v) {
			$allCategoriesPreData[intval($v->parent_id)][] = $v;
		}

		foreach($allCategoriesPreData as $key => $val) {
			$i = 1;
			foreach($allCategoriesPreData[$key] as $key2 => $val2) {
				$childrenCategoriesPreData[$key]['children'][] = $val2;
				$i++;
			}
			$r[] = intval($key);
		}
		
		$categoryDataById = $this->getCategoryById($r);
		$i = 1;
		foreach($categoryDataById as $key => $val) {
			$parentCategoriesPreData[$i]['parent'] = $val;
			$i++;
		}
		
		$i = 0;
		foreach($parentCategoriesPreData as $key => $val) {
			$allCategoriesStructuredData[$i]['lvl1'] = $val['parent'];
			$allCategoriesStructuredData[$i]['lvl2'] = $childrenCategoriesPreData[$val['parent']->id]['children'];
			$i++;
		}
		
		$dataFirstElement = array_pop($allCategoriesStructuredData);
		array_unshift($allCategoriesStructuredData, $dataFirstElement);

		return $allCategoriesStructuredData;
	}
}

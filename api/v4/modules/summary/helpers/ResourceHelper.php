<?php

namespace api\v4\modules\summary\helpers;

use api\v4\modules\summary\models\Resource;
use yii\helpers\ArrayHelper;

class ResourceHelper {
	
	public static function getTree() {
		$idList = self::getResourceByType('id');
		$tree['static_id'] = self::listToInteger($idList);
		$tree['url'] = self::getResourceByType('url');
		$tree['last_modified'] = ModifiedHelper::getList();
		return $tree;
	}
	
	public static function getResourceByType($type) {
		$all = Resource::findAll(['type' => $type]);
		return self::formatList($all);
	}
	
	private static function listToInteger($all) {
		$all = array_map(function($value) {
			$value = intval($value);
			return $value;
		}, $all);
		return $all;
	}
	
	private static function formatList($list) {
		return ArrayHelper::map($list, 'name', 'value');
	}
	
}
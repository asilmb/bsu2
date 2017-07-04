<?php

namespace common\db;

use yii\helpers\ArrayHelper;

class ActiveRecordTps {
	
	public static function field($item) {
		return $item;
	}
	
	protected static function fields($data) {
		if(empty($data)) {
			return [];
		}
		if(ArrayHelper::isIndexed($data)) {
			foreach($data as &$item) {
				$item = static::field($item);
			}
		} else {
			$data = static::field($data);
		}
		return $data;
	}
	
}

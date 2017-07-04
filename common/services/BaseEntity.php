<?php

namespace common\services;

use Yii;
use yii\base\Model;

class BaseEntity extends Model {
	
	const SCENARIO_CREATE = 'create';
	const SCENARIO_UPDATE = 'update';
	
	protected $scenario = self::SCENARIO_CREATE;
	
	public static function forge($item, $scenario = self::SCENARIO_CREATE) {
		if(empty($item)) {
			return null;
		}
		$item['class'] = static::className();
		$entity = Yii::createObject($item);
		$entity->scenario = $scenario;
		return $entity;
	}
	
	public function loadVales($item) {
		
		$this->setAttributes($item);
		//Yii::configure($this, $item);
		return $this->validate();
	}
	
}
<?php

namespace common\services;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class BaseRepository extends Component {
	
	use ErrorTrait;
	
	protected $with = [];
	
	public function with($name) {
		$this->with[] = $name;
	}
	
	public function withReset() {
		$this->with = [];
	}
	
	public function reset() {
		$this->withReset();
	}
	
	public function init() {
		$this->error = new ErrorCollection();
	}
	
	protected function field($item) {
		return $item;
	}
	
	protected function fields($data) {
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
	
	protected function forgeEntity($item, $class) {
		return $class::forge($item, $class::SCENARIO_UPDATE);
	}
	
	protected function forgeEntityCollection($all, $class) {
		$result = [];
		foreach($all as $item) {
			$result[] = $class::forge($item, $class::SCENARIO_UPDATE);
		}
		return $result;
	}
	
}
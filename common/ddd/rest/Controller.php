<?php

namespace common\ddd\rest;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\rest\Controller as YiiController;

class Controller extends YiiController {
	/** @var \common\ddd\services\BaseService */
	protected $service;
	public $serviceName;
	
	public function format() {
		return [];
	}
	
	public function init() {
		parent::init();
		$this->initService();
		$this->initFormat();
	}
	
	private function initFormat() {
		$format = $this->format();
		if(empty($format)) {
			return;
		}
		$this->serializer = [
			'class' => 'common\ddd\rest\Serializer',
			'format' => $format,
		];
	}
	
	private function initService() {
		if($this->serviceName === null) {
			throw new InvalidConfigException('The "serviceName" property must be set.');
		}
		$this->service = ArrayHelper::getValue(Yii::$app, $this->serviceName);
	}
}

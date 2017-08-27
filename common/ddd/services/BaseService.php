<?php

namespace common\ddd\services;

use common\ddd\data\ActiveDataProvider;
use common\ddd\data\Query;
use common\ddd\Domain;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\base\Component as YiiComponent;

class BaseService extends YiiComponent {
	
	const EVENT_BEFORE_ACTION = 'beforeAction';
	const EVENT_AFTER_ACTION = 'afterAction';
	
	public $id;
	
	/** @var Domain */
	public $domain;
	
	//public $driver = '';
	
	public function getDataProvider(Query $query = null) {
		if(empty($query) || !is_object($query)) {
			$query = new Query();
		}
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'service' => $this,
		]);
		return $dataProvider;
	}
	
	public function setDriver($name) {
		//return $this->driver = $name;
	}
	
	public function getRepository($name = null) {
		$name = !empty($name) ? $name : $this->id;
		return $this->domain->repositories->{$name};
	}
	
	// todo: move method in helper
	
	public function forgeQuery($query) {
		if($query instanceof Query) {
			return $query;
		}
		return new Query();
	}
	
	protected function validateForm($form, $data = null, $scenario = null) {
		if(is_string($form) || is_array($form)) {
			$form = Yii::createObject($form);
		}
		/** @var \yii\base\Model $form */
		if(!empty($data)) {
			Yii::configure($form, $data);
		}
		if(!empty($scenario)) {
			$form->scenario = $scenario;
		}
		if(!$form->validate()) {
			throw new UnprocessableEntityHttpException($form);
		}
		return $form->getAttributes();
	}
	
}
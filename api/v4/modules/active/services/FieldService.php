<?php

namespace api\v4\modules\active\services;

use api\v4\modules\active\entities\FieldEntity;
use api\v4\modules\service\helpers\DynamicRulesHelper;
use common\ddd\services\ActiveBaseService;
use common\ddd\data\Query;
use yii\helpers\ArrayHelper;
use yii2lab\validator\DynamicModel;

class FieldService extends ActiveBaseService {
	
	// todo: make unique [active_id, name] and [active_id, title]
	
	//public $forbiddenChangeFields = ['active_id'];
	public $foreignServices = [
		'active.type' => [
			'field' => 'active_id',
			'notFoundMessage' => ['active/type', 'not_found'],
		],
	];
	
	private function getAllWithOrder($typeId, Query $query = null) {
		$query = $this->forgeQuery($query);
		$query->orderBy('priority');
		$query->where('active_id', $typeId);
		return $this->all($query);
	}
	
	//public function getAllByTypeId($typeId, Query $query = null) {
	//	$query = $this->forgeQuery($query);
	//	$query->where('active_id', $typeId);
	//	return $this->getAllWithOrder($query);
	//}
	
	public function getAllByTypeIdWithRelations($typeId) {
		$query = new Query();
		$query->with(['options', 'validations']);
		return $this->getAllWithOrder($typeId, $query);
	}
	
	// todo: create test
	
	public function validate($typeId, $body) {
		$form = $this->createDynamicModel($typeId);
		$form->load($body, '');
		
		$this->validateForm($form);
		return $form->toArray();
	}
	
	public function createDynamicModel($typeId) {
		$fields = $this->getAllByTypeIdWithRelations($typeId);
		$fields = ArrayHelper::toArray($fields);
		$form = new DynamicModel();
		
		$labels = ArrayHelper::map($fields, 'name', 'title');
		$form->loadAttributeLabels($labels);
		
		$dynamicRules = new DynamicRulesHelper;
		$rules = $dynamicRules->getRules($fields);
		$form->loadRules($rules);
		$form->loadScenarios([
			DynamicModel::SCENARIO_DEFAULT => ArrayHelper::getColumn($fields, 'name'),
		]);
		return $form;
	}
	
	public function getEnums() {
		$enums = [
			FieldEntity::TYPE_STRING => t('active/field', 'string'),
			FieldEntity::TYPE_INTEGER => t('active/field', 'integer'),
		];
		return $enums;
	}
	
}

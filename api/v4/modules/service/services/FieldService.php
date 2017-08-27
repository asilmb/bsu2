<?php

namespace api\v4\modules\service\services;

use api\v4\modules\service\helpers\DynamicLabelsHelper;
use api\v4\modules\service\helpers\DynamicRulesHelper;
use common\ddd\services\BaseService;
use yii\helpers\ArrayHelper;
use yii2lab\validator\DynamicModel;

class FieldService extends BaseService {
	
	public function getAllByServiceId($serviceId) {
		$all = $this->repository->getAllByServiceId($serviceId);
		return $all;
	}
	
	public function validate($serviceId, $body) {
		$fields = $this->getAllByServiceId($serviceId);
		$fields = ArrayHelper::toArray($fields);
		
		$dynamicLabels = new DynamicLabelsHelper;
		$labels = $dynamicLabels->getLabels($fields);
		
		$dynamicRules = new DynamicRulesHelper;
		$rules = $dynamicRules->getRules($fields);
		
		$form = new DynamicModel();
		$form->loadRules($rules);
		$form->loadAttributeLabels($labels);
		$form->loadData($body);
		
		$this->validateForm($form);
		return $form->toArray();
	}
	
}

<?php

namespace api\v4\modules\service\modelsDeco;

use api\v4\modules\service\models\Service as BaseService;
use yii\helpers\ArrayHelper;

class Service extends BaseService
{
	public function fields()
	{
		$fields['service_id'] = 'service_id';
		$fields['service_name'] = 'service_name';
		$fields['parent_id'] = 'parent_id';
		$fields['title'] = 'title';
		$fields['name'] = 'name';
		$fields['description'] = 'description';
		$fields['description_company'] = 'description_company';
		$fields['merchant'] = 'merchant';
		$fields['picture'] = 'picture';
		$fields['synonyms'] = function () {
			$data = str_replace(['{','}','"'], '', $this->synonyms);
			if($data) {
				return $data;
			}
		};
		unset($fields['fields']);
		$fields['fields'] = function () {
			if($this->field) {
				$fields = ArrayHelper::toArray($this->field);
				$isAddedButton = false;
				foreach($fields as &$field) {
					if(!$isAddedButton && !empty($field['button'])) {
						$fields[] = [
							'name' => 'button',
							'type' => 'button',
							'title' => 'Button',
							'mask' => null,
							'value' => null,
							'is_need_send' => false,
						];
					}
					unset($field['button']);
				}
				return $fields;
			}
		};
		return $fields;
	}
	public function extraFields() {
		return [
			'categories'
		];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getField()
	{
		return $this->hasMany(Fields::className(), ['service_id' => 'service_id'])
			->with(['translate', 'validations', 'values'])
			->where("name <> 'txn_id'")
			->andWhere("type <> 'label'")
			->andWhere(['hidden' => 0])
			->orderBy(['sort' => SORT_ASC]);
	}
	
}

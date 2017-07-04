<?php

namespace api\v4\modules\service\modelsDeco;

use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use api\v4\modules\service\models\Fields as BaseFields;

class Fields extends BaseFields
{

	public function fields()
	{
		$fields['name'] = 'name';
		$fields['title'] = function () {
			if($this->translate && $this->translate->value) {
				return $this->translate->value;
			}
			$title = Inflector::camel2words($this->name);
			$title = strtolower($title);
			return Inflector::humanize($title);
		};
		$fields['type'] = 'type';
		$fields['button'] = function () {
			return !empty($this->button);
		};
		$fields['mask'] = function () {
			if($this->mask) {
				return $this->mask;
			}
		};
		$fields['value'] = function () {
			if($this->value) {
				return $this->value;
			}
		};
		$fields['values'] = function () {
			if($this->values) {
				return ArrayHelper::getColumn($this->values, function ($element) {
					return [
						'key' => $element['key'],
						'value' => $element['value'],
					];
				});
			}
		};
		foreach ($this->validations as $item) {
			if($item['type'] == 'length') {
				$fields['min_length'] = function () use($item) {
					$propList = json_decode($item->param);
					if(property_exists($propList, 'min')) {
						return $propList->min;
					}
				};
				$fields['max_length'] = function () use($item) {
					$propList = json_decode($item->param);
					if(property_exists($propList, 'max')) {
						return $propList->max;
					}
				};
			}
		}
		$fields['is_need_send'] = function () {
			if($this->name == 'txn_id' || $this->name == 'button' || $this->name == 'capcha') {
				return false;
			} else {
				return true;
			}
		};
		return $fields;
	}
	
}
